<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Enums\DocumentType;
use App\Enums\MovementType;
use App\Models\User;
use App\Models\InventoryLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleXMLElement;

class InventoryController extends Controller
{

    public function __construct() {}

    public function index(Request $request)
    {
        $user = Auth::guard('web')->user();

        $search = (isset($request->search)) ? $request->search : '';
        
        $rows = Inventory::select('id', 'title','barcode', 'instructions', 'price', 'cabys', 'rate', 'markeplace', 'enabled', 'quantity')->where('id_vet', '=', $user->id_vet)->where('vet', '=', 1);

        if ($search != '') {
            $search = base64_decode($search);

            $searchParam = '%' . $search . '%';
            $rows = $rows->where('title', 'like', $searchParam);
        }

        $rows = $rows->paginate(30);

        return view('inventory.index', compact('rows', 'search'));
    }

    public function add()
    {
        return view('inventory.add');
    }

    public function store(Request $request)
    {
        $user = Auth::guard('web')->user();

        Inventory::create([
            'id_vet' => $user->id_vet,
            'title' => $request->mname,
            'description' => $request->detail,
            'barcode' => '',
            'quantity' => $request->quantity,
            'code' => '',
            'subprice' => number_format($request->subprice, 2, ".", ""),
            'price' => number_format($request->price, 2, ".", ""),
            'instructions' => $request->mindicator,
            'type' => $request->type,
            'cabys' => $request->cabys,
            'rate' => $request->rate,
            'unit' => $request->unit,
            'markeplace' => 0,
            'vet' => 1,
            'enabled' => 1
        ]);

        $row = Inventory::select('id')->orderBy('id', 'desc')->first();
        $row->registerMovement(MovementType::ENTRADA, DocumentType::AJUSTE_MANUAL, '', $request->quantity, 'Nuevo ingreso', $user->id);



        return redirect()->route('inventory.index');
    }

    public function edit(Request $request)
    {
        $user = Auth::guard('web')->user();

        $id = User::encryptor('decrypt', $request->id);

        $row = Inventory::where('id', '=', $id)->where('id_vet', '=', $user->id_vet)->where('vet', '=', 1)->first();

        return view('inventory.edit', compact('row'));
    }

    public function update(Request $request)
    {
        $user = Auth::guard('web')->user();

        $id = User::encryptor('decrypt', $request->hideId);

        $row = Inventory::where('id', '=', $id)->where('id_vet', '=', $user->id_vet)->first();
        if ($row->quantity > $request->quantity) {
            $row->registerMovement(MovementType::SALIDA, DocumentType::AJUSTE_MANUAL, '', $row->quantity - $request->quantity, 'Ajuste de inventario', $user->id);
        } elseif ($row->quantity < $request->quantity) {
            $row->registerMovement(MovementType::ENTRADA, DocumentType::AJUSTE_MANUAL, '', $request->quantity - $row->quantity, 'Ajuste de inventario', $user->id);
        }
        if (isset($row->id)) {
            $row->title = $request->mname;
            $row->instructions = $request->mindicator;
            $row->description = $request->detail;
            $row->quantity = $request->quantity;
            $row->subprice = number_format($request->subprice, 2, ".", "");
            $row->price = number_format($request->price, 2, ".", "");
            $row->type = $request->type;
            $row->cabys = $request->cabys;
            $row->rate = $request->rate;
            $row->unit = $request->unit;
            $row->update();
        }

        return redirect()->route('inventory.index');
    }

    public function delete(Request $request)
    {
        $user = Auth::guard('web')->user();

        $id = User::encryptor('decrypt', $request->id);

        $row = Inventory::select('id')
            ->where('id', '=', $id)
            ->first();

        if (isset($row->id)) {
            $row->delete();

            return response()->json(array('type' => '200', 'process' => '1'));
        }
        $row->registerMovement(MovementType::SALIDA, DocumentType::AJUSTE_MANUAL, '', $row->quantity, 'Eliminación de inventario', $user->id);

        return response()->json(array('type' => '200', 'process' => '500'));
    }

    public function changeEnabled(Request $request)
    {
        $user = Auth::guard('web')->user();

        $id = User::encryptor('decrypt', $request->id);

        $row = Inventory::select('id', 'enabled')
            ->where('id', '=', $id)
            ->first();

        if (isset($row->id)) {
            $row->enabled = $request->status;
            $rowupdate();

            return response()->json(array('type' => '200', 'process' => '1'));
        }
        $row->registerMovement(MovementType::AJUSTE, DocumentType::AJUSTE_MANUAL, '', 0, 'Cambio de estado de inventario', $user->id);

        return response()->json(array('type' => '200', 'process' => '500'));
    }

    public function history(Request $request)
    {
        // Desencriptar el id que corresponde al inventory
        $inventoryId = User::encryptor('decrypt', $request->id);

        $info = new \stdClass();
        $info->product = '';
        $info->user_name = '';

        // Obtener los logs del inventario específico, junto con el nombre y apellido del usuario
        $rows = InventoryLogs::select(
            'inventory_logs.id',
            'inventory_logs.movement_type',
            'inventory_logs.document_type',
            'inventory_logs.movement_status',
            'inventory_logs.user_id',
            'inventory_logs.inventory_id',
            'inventory_logs.quantity',
            'inventory_logs.document_id',
            'inventory_logs.notes',
            'inventory_logs.created_at',
            'inventory_logs.updated_at',
            'inventory_logs.deleted_at',
            'users.name',
            'users.lastname'
        )
            ->join('users', 'users.id', '=', 'inventory_logs.user_id')
            ->where('inventory_logs.inventory_id', $inventoryId)
            ->paginate(30); // Se aplica la paginación sobre el query

        // Obtener el título del inventario (producto)
        $info->product = Inventory::where('id', $inventoryId)->value('title') ?? '';

        return view('inventory.history', compact('rows', 'info'));
    }


    public function upload()
    {
        return view('inventory.upload');
    }

    public function uploadxml(Request $request)
    {
        $user = Auth::guard('web')->user();
        // Validar que el archivo está presente y es un XML
        $request->validate([
            'xml_file' => 'required|mimes:xml|max:2048',
        ]);

        // Obtener el archivo
        $file = $request->file('xml_file');

        // Cargar el contenido del XML
        $xmlContent = file_get_contents($file->getPathname());

        // Convertir en un objeto SimpleXMLElement
        try {
            $xml = new SimpleXMLElement($xmlContent);
        } catch (\Exception $e) {
            return back()->withErrors(['xml_file' => 'El archivo XML no es válido.']);
        }

        // Verificar si existe <FacturaElectronica><DetalleServicio><LineaDetalle>
        if (!isset($xml->DetalleServicio->LineaDetalle)) {
            return back()->withErrors(['xml_file' => 'El XML no contiene la estructura esperada.']);
        }

        foreach ($xml->DetalleServicio->LineaDetalle as $linea) {
            $documento = (string) $xml->Clave;
            $codigo = isset($linea->CodigoComercial->Codigo) ? (string) $linea->CodigoComercial->Codigo : (string) $linea->Codigo;
            $cantidad = floatval(str_replace(',', '.', $linea->Cantidad));
            $subprice = number_format((float) $linea->PrecioUnitario, 2, ".", "");
            $impuestoMonto = isset($linea->Impuesto->Monto) ? (float) $linea->Impuesto->Monto : 0;
            $price = number_format($subprice + $impuestoMonto, 2, ".", "");

            // Buscar si el producto ya existe en la base de datos
            $row = Inventory::select('id', 'enabled', 'quantity')
                ->where(function ($query) use ($codigo) {
                    $query->where('barcode', $codigo)
                        ->orWhere('code', $codigo);
                })
                ->first();

            if ($row) {
                // Si el producto existe, aumentar el inventario

                $row->increaseInventory($cantidad, $documento, DocumentType::ORDEN_COMPRA, 'Carga de inventario desde XML', $user->id);
            } else {
                // Si el producto no existe, crearlo
                $inventory = Inventory::create([
                    'id_vet' => $user->id_vet ?? null,  // Verifica que $user esté definido
                    'title' => (string) $linea->Detalle,
                    'description' => '',
                    'barcode' => $codigo,
                    'quantity' => $cantidad,
                    'code' => $codigo,
                    'subprice' => $subprice,
                    'price' => $price, // Ahora incluye el impuesto
                    'instructions' => '',
                    'type' => isset($linea->Impuesto->CodigoTarifa) && $linea->Impuesto->CodigoTarifa == '01' ? 'exento' : 'gravado',
                    'cabys' => (string) $linea->Codigo,
                    'rate' => isset($linea->Impuesto->CodigoTarifa) ? (string) $linea->Impuesto->CodigoTarifa : null,
                    'unit' => 'Producto',
                    'markeplace' => 0,
                    'vet' => 1,
                    'enabled' => 1
                ]);

                $inventory->registerMovement(MovementType::ENTRADA, DocumentType::ORDEN_COMPRA, $documento, $cantidad, 'Carga de inventario desde XML', $user->id);
            }
        }



        return redirect()->route('inventory.index');
    }

    public function previewXml(Request $request)
    {
        $user = Auth::guard('web')->user();

        // Validar que el archivo está presente y es un XML
        $request->validate([
            'xml_file' => 'required|mimes:xml|max:2048',
        ]);

        // Obtener el archivo y cargar el contenido
        $file = $request->file('xml_file');
        $xmlContent = file_get_contents($file->getPathname());

        // Convertir a objeto SimpleXMLElement
        try {
            $xml = new SimpleXMLElement($xmlContent);
        } catch (\Exception $e) {
            return back()->withErrors(['xml_file' => 'El archivo XML no es válido.']);
        }

        // Verificar la estructura esperada
        if (!isset($xml->DetalleServicio->LineaDetalle)) {
            return back()->withErrors(['xml_file' => 'El XML no contiene la estructura esperada.']);
        }

        // Extraer los datos a mostrar en el preview
        $rows = [];
        foreach ($xml->DetalleServicio->LineaDetalle as $linea) {
            $documento   = (string)$xml->Clave;
            $codigo      = isset($linea->CodigoComercial->Codigo) ? (string)$linea->CodigoComercial->Codigo : (string)$linea->Codigo;
            $cantidad    = floatval(str_replace(',', '.', $linea->Cantidad));
            $subprice    = number_format((float)$linea->PrecioUnitario, 2, ".", "");
            $impuestoMonto = isset($linea->Impuesto->Monto) ? (float)$linea->Impuesto->Monto : 0;
            $price       = number_format($subprice + $impuestoMonto, 2, ".", "");

            $row = Inventory::select('id')
                ->where(function ($query) use ($codigo) {
                    $query->where('barcode', $codigo)
                        ->orWhere('code', $codigo);
                })
                ->first();
            $exists = isset($row->id) ? 1 : 0;

            $rows[] = [
                'documento'     => $documento,
                'codigo'        => $codigo,
                'cantidad'      => $cantidad,
                'subprice'      => $subprice,
                'impuestoMonto' => $impuestoMonto,
                'price'         => $price,
                'detalle'       => (string)$linea->Detalle,
                'tipo'          => (isset($linea->Impuesto->CodigoTarifa) && $linea->Impuesto->CodigoTarifa == '01') ? 'exento' : 'gravado',
                'cabys'         => (string)$linea->Codigo,
                'rate'          => isset($linea->Impuesto->CodigoTarifa) ? (string)$linea->Impuesto->CodigoTarifa : null,
                'exist'        => $exists,
            ];
        }

        // Retornar la vista de previsualización con los datos extraídos
        // En la vista, se generará un formulario con estos datos para que el usuario pueda editarlos
        return view('inventory.preview', compact('rows'));
    }

    public function storeXmlProducts(Request $request)
    {
        $user = Auth::guard('web')->user();

        // Se espera que los datos editados se envíen en un arreglo llamado 'data'
        $data = $request->input('data');
        if (!$data) {
            return redirect()->route('inventory.index')->withErrors(['No se recibieron datos para guardar.']);
        }

        foreach ($data as $item) {
            // Buscar si el producto ya existe en la base de datos
            $row = Inventory::select('id', 'enabled', 'quantity')
                ->where(function ($query) use ($item) {
                    $query->where('barcode', $item['codigo'])
                        ->orWhere('code', $item['codigo']);
                })->first();

            if ($row) {
                // Si el producto existe, aumentar el inventario
                $row->increaseInventory($item['cantidad'], $item['documento'], DocumentType::ORDEN_COMPRA, 'Carga de inventario desde XML', $user->id);
            } else {
                // Si el producto no existe, crearlo
                $inventory = Inventory::create([
                    'id_vet'      => $user->id_vet ?? null,
                    'title'       => $item['detalle'],
                    'description' => '',
                    'barcode'     => $item['codigo'],
                    'quantity'    => $item['cantidad'],
                    'code'        => $item['codigo'],
                    'subprice'    => $item['subprice'],
                    'price'       => $item['price'],
                    'instructions' => '',
                    'type'        => $item['tipo'],
                    'cabys'       => $item['cabys'],
                    'rate'        => $item['rate'],
                    'unit'        => 'Producto',
                    'markeplace'  => 0,
                    'vet'         => 1,
                    'enabled'     => 1,
                ]);

                $inventory->registerMovement(MovementType::ENTRADA, DocumentType::ORDEN_COMPRA, $item['documento'], $item['cantidad'], 'Carga de inventario desde XML', $user->id);
            }
        }

        return redirect()->route('inventory.index');
    }
}

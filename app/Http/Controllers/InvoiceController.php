<?php

namespace App\Http\Controllers;

use App\Models\AppointmentClient;
use App\Models\AppointmentRecipe;
use App\Models\Inventory;
use App\Enums\DocumentType;
use App\Enums\MovementType;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserVetDoctor;
use App\Models\Vets;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use SimpleXMLElement;

class InvoiceController extends Controller {
    
    public function __construct() {}

    public function index(Request $request) {
        $user = Auth::guard('web')->user();

        $month  = (isset($request->month)) ? base64_decode($request->month) : date('m');
        $year   = (isset($request->year)) ? base64_decode($request->year) : date('Y');
        $billtype = (isset($request->billtype)) ? $request->billtype : 0;

        $from = $year . '-' . $month . '-01';
        $to = Carbon::createFromFormat('Y-m-d', $from)->endOfMonth()->format('Y-m-d');
        $from = $from . ' 00:00:00';
        $to = $to . ' 23:59:59';

        $setting = Setting::select('id', 'user_invoice', 'pass_invoice', 'environment_invoice')->where('id', '=', 1)->first();

        $urlService = ($setting->environment_invoice == 1) ? env('InvoiceUrlTest') : env('InvoiceUrlProd');

        $token = base64_encode($setting->user_invoice) . ':' . base64_encode($setting->pass_invoice);
        $token = base64_encode($token);

        $vetRow = Vets::select('id', 'dni')->where('id', '=', $user->id_vet)->first();

        try {
            $invoices = [];
            if($billtype == 0) {
                $payload = '<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
                                <Body>
                                    <Recibe_Json_GetInvoicePeriod xmlns="urn:server">
                                        <veterinaria>' . $vetRow->dni . '</veterinaria>
                                        <fechaInicial>' . $from . '</fechaInicial>
                                        <fechaFinal>' . $to . '</fechaFinal>
                                    </Recibe_Json_GetInvoicePeriod>
                                </Body>
                            </Envelope>';

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $urlService,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>$payload,
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: text/xml',
                        'Authorization: Basic ' . $token
                    ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);

                $xml = simplexml_load_string($response);

                $xml = $xml->asXML();

                $pattern = '/<return[^>]*>(.*?)<\/return>/s';

                $result = '';
                if (preg_match($pattern, $xml, $matches)) {
                $result = $matches[1];
                }

                Log::notice(__METHOD__ . ', line #' . (__LINE__) . ' result create invoice decode= ' . json_encode($result));

                if($result != '') {
                    try {
                        $result = base64_decode($result);

                        $invoices = json_decode($result, true);
                    } catch (\Throwable $th) {
                        Log::notice(__METHOD__ . ', line #' . (__LINE__) . ' error create invoice= ' . json_encode($th));
                    }
                }
            } else if($billtype == 1) {
                $payload = '<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
                                <Body>
                                    <Recibe_Json_GetTicketPeriod xmlns="urn:server">
                                        <veterinaria>' . $vetRow->dni . '</veterinaria>
                                        <fechaInicial>' . $from . '</fechaInicial>
                                        <fechaFinal>' . $to . '</fechaFinal>
                                    </Recibe_Json_GetTicketPeriod>
                                </Body>
                            </Envelope>';
                
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $urlService,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>$payload,
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: text/xml',
                        'Authorization: Basic ' . $token
                    ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);

                $xml = simplexml_load_string($response);

                $xml = $xml->asXML();

                $pattern = '/<return[^>]*>(.*?)<\/return>/s';

                $result = '';
                if (preg_match($pattern, $xml, $matches)) {
                    $result = $matches[1];
                }

                Log::notice(__METHOD__ . ', line #' . (__LINE__) . ' result create invoice decode= ' . json_encode($result));

                if($result != '') {
                    try {
                        $result = base64_decode($result);

                        $invoices = json_decode($result, true);
                    } catch (\Throwable $th) {
                        Log::notice(__METHOD__ . ', line #' . (__LINE__) . ' error create invoice= ' . json_encode($th));
                    }
                }
            } else if($billtype == 2) {
                $payload = '<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
                                <Body>
                                    <Recibe_Json_GetCreditNotePeriod xmlns="urn:server">
                                        <veterinaria>' . $vetRow->dni . '</veterinaria>
                                        <fechaInicial>' . $from . '</fechaInicial>
                                        <fechaFinal>' . $to . '</fechaFinal>
                                    </Recibe_Json_GetCreditNotePeriod>
                                </Body>
                            </Envelope>';
                
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $urlService,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>$payload,
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: text/xml',
                        'Authorization: Basic ' . $token
                    ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);

                $xml = simplexml_load_string($response);

                $xml = $xml->asXML();

                $pattern = '/<return[^>]*>(.*?)<\/return>/s';

                $result = '';
                if (preg_match($pattern, $xml, $matches)) {
                    $result = $matches[1];
                }

                if($result != '') {
                    try {
                        $result = base64_decode($result);

                        $invoices = json_decode($result, true);
                    } catch (\Throwable $th) {
                        Log::notice(__METHOD__ . ', line #' . (__LINE__) . ' error create invoice= ' . json_encode($th));
                    }
                }
            }
        } catch (\Throwable $th) {
            $invoices = [];
        }

        return view('invoice.index', compact('invoices', 'month', 'year', 'billtype'));
    }

    public function proformas(Request $request) {
        $user = Auth::guard('web')->user();

        $invoices = Invoice::where('id_vet', '=', $user->id_vet)
                ->where('proforma', '=', 1)
                ->orderBy('created_at', 'ASC')
                ->paginate(50);

        return view('invoice.proformas', compact('invoices'));
    }

    public function proformaDetail(Request $request) {
        $user = Auth::guard('web')->user();

        $id = User::encryptor('decrypt', $request->id);

        $invoice = Invoice::where('id', '=', $id)
                ->where('proforma', '=', 1)
                ->where('id_vet', '=', $user->id_vet)
                ->first();

        $details = InvoiceDetail::where('id_invoice', '=', $id)->get();

        if(!isset($invoice->id)) {
            return redirect()->route('invoice.proform');
        }

        return view('invoice.proformas.detail', compact('invoice', 'details'));
    }

    public function proformaEdit(Request $request) {
        $user = Auth::guard('web')->user();

        $id = User::encryptor('decrypt', $request->id);

        $invoice = Invoice::where('id', '=', $id)
                ->where('proforma', '=', 1)
                ->where('id_vet', '=', $user->id_vet)
                ->first();

        $details = InvoiceDetail::where('id_invoice', '=', $id)->get();

        $owner = User::select('id', 'name', 'email', 'phone', 'type_dni', 'dni')->where('email', '=', $invoice->email)->get();

        $rows = [];
        foreach ($details as $detail) {
            $rows[$detail->id] = [
                'id' => ($detail->id_product != 0) ? $detail->id_product : 'xtr'.rand(111,999),
                'title' => $detail->detail,
                'quantity' => $detail->quantity,
                'cabys' => $detail->cabys,
                'subprice' => $detail->subprice,
                'price' => $detail->price,
                'type' => $detail->gravado,
                'rate' => $detail->rate,
                'unit' => $detail->line_type,
            ];
        }

        $products = Inventory::select('id', 'title', 'description', 'subprice', 'price', 'type', 'cabys', 'rate', 'unit')
            ->where('id_vet', '=', $user->id_vet)
            ->where(function ($query) {
                $query->where('markeplace', '=', 1)
                    ->orWhere('enabled', '=', 1);
            })
            ->get();

        $proformId = $request->id;

        return view('invoice.create-appointment', compact('owner', 'rows', 'products', 'proformId', 'invoice'));

    }

    public function detail(Request $request) {
        $user = Auth::guard('web')->user();

        $id = $request->id;
        $doctype = $request->doctype;
        $printer = (isset($request->printer)) ? $request->printer : '';

        $setting = Setting::select('id', 'user_invoice', 'pass_invoice', 'environment_invoice')->where('id', '=', 1)->first();

        $urlService = ($setting->environment_invoice == 1) ? env('InvoiceUrlTest') : env('InvoiceUrlProd');

        $token = base64_encode($setting->user_invoice) . ':' . base64_encode($setting->pass_invoice);
        $token = base64_encode($token);

        if ($doctype == 0) {
            $payload = '<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
                            <Body>
                                <Recibe_Json_GetInvoice xmlns="urn:server">
                                    <clave>'.$id.'</clave>
                                </Recibe_Json_GetInvoice>
                            </Body>
                        </Envelope>';
            $payloadDetail = '<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
                        <Body>
                            <Recibe_Json_GetInvoiceProducts xmlns="urn:server">
                                <clave>'.$id.'</clave>
                            </Recibe_Json_GetInvoiceProducts>
                        </Body>
                    </Envelope>';
        } else if($doctype == 1) {
            $payload = '<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
                            <Body>
                                <Recibe_Json_GetTicket xmlns="urn:server">
                                    <clave>'.$id.'</clave>
                                </Recibe_Json_GetTicket>
                            </Body>
                        </Envelope>';
            $payloadDetail = '<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
                        <Body>
                            <Recibe_Json_GetTicketProducts xmlns="urn:server">
                                <clave>'.$id.'</clave>
                            </Recibe_Json_GetTicketProducts>
                        </Body>
                    </Envelope>';
        } else if($doctype == 2) {
            $payload = '<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
                            <Body>
                                <Recibe_Json_GetCreditNote xmlns="urn:server">
                                    <clave>'.$id.'</clave>
                                </Recibe_Json_GetCreditNote>
                            </Body>
                        </Envelope>';
            $payloadDetail = '<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
                        <Body>
                            <Recibe_Json_GetCreditNoteProducts xmlns="urn:server">
                                <clave>'.$id.'</clave>
                            </Recibe_Json_GetCreditNoteProducts>
                        </Body>
                    </Envelope>';
        }

        try {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $urlService,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>$payload,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: text/xml',
                    'Authorization: Basic ' . $token
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            $xml = simplexml_load_string($response);

            $xml = $xml->asXML();

            $pattern = '/<return[^>]*>(.*?)<\/return>/s';

            $result = '';
            if (preg_match($pattern, $xml, $matches)) {
                $result = $matches[1];
            }

            Log::notice(__METHOD__ . ', line #' . (__LINE__) . ' result detail invoice decode= ' . json_encode($result));

            $invoice = [];
            if($result != '') {
                try {
                    $result = base64_decode($result);

                    $invoice = json_decode($result, true);
                    if(isset($invoice[0])) {
                        $invoice = $invoice[0];
                    }
                } catch (\Throwable $th) {
                    Log::notice(__METHOD__ . ', line #' . (__LINE__) . ' error detail invoice= ' . json_encode($th));
                }
            }

            $curlDetail = curl_init();
            curl_setopt_array($curlDetail, array(
                CURLOPT_URL => $urlService,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>$payloadDetail,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: text/xml',
                    'Authorization: Basic ' . $token
                ),
            ));

            $responseDetail = curl_exec($curlDetail);

            curl_close($curlDetail);

            $xmlDetail = simplexml_load_string($responseDetail);

            $xmlDetail = $xmlDetail->asXML();

            $pattern = '/<return[^>]*>(.*?)<\/return>/s';

            $resultDetail = '';
            if (preg_match($pattern, $xmlDetail, $matches)) {
                $resultDetail = $matches[1];
            }

            Log::notice(__METHOD__ . ', line #' . (__LINE__) . ' result detail invoice decode= ' . json_encode($resultDetail));

            $details = [];
            if($resultDetail != '') {
                try {
                    $resultDetail = base64_decode($resultDetail);

                    $details = json_decode($resultDetail, true);
                } catch (\Throwable $th) {
                    Log::notice(__METHOD__ . ', line #' . (__LINE__) . ' error detail invoice= ' . json_encode($th));
                }
            }
        } catch (\Throwable $th) {
            return redirect()->route('invoice.index');
        }

        if($printer == 'printer') {
            return view('printer.invoice', compact('invoice', 'details', 'doctype'));
        }else{
            return view('invoice.detail', compact('invoice', 'details', 'doctype'));
        }
    }
    
    public function create(Request $request) {
        $user = Auth::guard('web')->user();

        $id = (isset($request->id)) ? $request->id : '';
        
        if($id != '') {
            $id = User::encryptor('decrypt', $id);

            $appointment = AppointmentClient::select('id', 'id_owner')->where('id', '=', $id)->first();

            $owner = User::select('id', 'name', 'email', 'phone', 'type_dni', 'dni')->where('id', '=', $appointment->id_owner)->get();

            $recipes = AppointmentRecipe::select('id', 'created_at')->where('id_appointment', '=', $appointment->id)->with('detail')->get();;

            $rows = [];
            foreach ($recipes as $recipe) {
                foreach ($recipe['detail'] as $detail) {
                    if(isset($rows[$detail->id_medicine])) {
                        $rows[$detail->id_medicine]['quantity'] = $rows[$detail->id_medicine]['quantity'] + $detail->quantity;
                    }else{
                        if($detail->id_medicine != 0) {
                            $medicine = Inventory::select('id', 'title', 'subprice', 'price', 'cabys', 'type', 'rate', 'unit')->where('id', '=', $detail->id_medicine)->first();
                            if(isset($medicine->id)) {
                                $rows[$medicine->id] = [
                                    'id' => $medicine->id,
                                    'title' => $medicine->title,
                                    'quantity' => $detail->quantity,
                                    'cabys' => $medicine->cabys,
                                    'subprice' => $medicine->subprice,
                                    'price' => $medicine->price,
                                    'type' => $medicine->type,
                                    'rate' => $medicine->rate,
                                    'unit' => $medicine->unit,
                                ];
                            }
                        }else{
                            $rows['xtr'.rand(111,999)] = [
                                'id' => 'xtr'.rand(111,999),
                                'title' => $detail->title,
                                'quantity' => $detail->quantity,
                                'cabys' => '3564001000000',
                                'subprice' => 0,
                                'price' => 0,
                                'type' => '',
                                'rate' => '',
                                'unit' => 'Producto'
                            ];
                        }
                    }
                }
            }

            $products = Inventory::select('id', 'title', 'description', 'subprice', 'price', 'type', 'cabys', 'rate', 'unit')
                ->where('id_vet', '=', $user->id_vet)
                ->where(function ($query) {
                    $query->where('markeplace', '=', 1)
                        ->orWhere('enabled', '=', 1);
                })
                ->get();

            $invoice = [];
            if(isset($owner[0]->id)) {
                $data = [
                    'user_id' => $owner[0]->id,
                    'name' => $owner[0]->name,
                    'email' => $owner[0]->email,
                    'phone' => $owner[0]->phone,
                    'type_dni' => $owner[0]->type_dni,
                    'dni' => $owner[0]->dni
                ];
                $invoice = (new Invoice())->newInstance($data, true);
            }

            return view('invoice.create-appointment', compact('owner', 'rows', 'products', 'invoice'));
        }else{
            $products = Inventory::select('id', 'title', 'description', 'subprice', 'price', 'type', 'cabys', 'rate', 'unit')
                ->where('id_vet', '=', $user->id_vet)
                ->where(function ($query) {
                    $query->where('markeplace', '=', 1)
                        ->orWhere('enabled', '=', 1);
                })
                ->get();

            //$patients = UserVetDoctor::where('id_doctor', '=', $user->id)->distinct('id_client')->pluck('id_client');
            $patients = UserVetDoctor::all()->pluck('id_client');
            $owner = User::select('id', 'name', 'email', 'phone', 'type_dni', 'dni')->whereIn('id', $patients)->get();

            $rows = [];

            return view('invoice.create-appointment', compact('products', 'owner', 'rows'));
        }
    }

    public function store(Request $request) {
        $user = Auth::guard('web')->user();

        $typeInvoice = $request->typeInvoice;

        $ticket = 1;
        $name = $request->invoiceName;
        $type_dni = $request->invoiceDniType;
        $dni = $request->invoiceDni;
        $email = $request->invoiceEmail;
        $phone = $request->invoicePhone;
        
        if(($request->invoiceName != '') && ($request->invoiceDniType != '') && ($request->invoiceDni != '') && ($request->invoiceEmail != '')) {
            $ticket = 0;
        }
        
        if((isset($request->proformId)) && ($request->proformId != '0')) {
            $proformId = User::encryptor('decrypt', $request->proformId);
            $invoice = Invoice::where('id', '=', $proformId)->where('proforma', '=', 1)->where('id_vet', '=', $user->id_vet)->first();
        }

        if(isset($invoice->id)) {
            $invoice->id_vet = $user->id_vet;
            $invoice->proforma = $typeInvoice;
            $invoice->ticket = $ticket;
            $invoice->consecutive = '';
            $invoice->clave = '';
            $invoice->user_id = $request->client;
            $invoice->name = $name;
            $invoice->type_dni = $type_dni;
            $invoice->dni = $dni;
            $invoice->email = $email;
            $invoice->phone = $phone;
            $invoice->payment = $request->paymentMethod;
            $invoice->type_payment = $request->paymentType;
            $invoice->currency = 'CRC';
            $invoice->total = 0;
            $invoice->errors = '';
            $invoice->status = 0;
            $invoice->update();

            InvoiceDetail::where('id_invoice', '=', $invoice->id)->delete();
        }else{
            $invoice = Invoice::create([
                'id_vet' => $user->id_vet,
                'proforma' => $typeInvoice,
                'ticket' => $ticket,
                'consecutive' => '',
                'clave' => '',
                'user_id' => $request->client,
                'name' => $name,
                'type_dni' => $type_dni,
                'dni' => $dni,
                'email' => $email,
                'phone' => $phone,
                'payment' => $request->paymentMethod,
                'type_payment' => $request->paymentType,
                'currency' => 'CRC',
                'total' => 0,
                'errors' => '',
                'status' => 0,
            ]);
        }

        if(isset($_POST['productCode'])){
            $subtotal = 0;
            for($i = 0;$i < count($_POST['productCode']);$i++){
                if($_POST['productCode'][$i] != ""){

                    $rate = $_POST['rate'][$i];
                    $unit = $_POST['unit'][$i];

                    $tax = 0;
                    switch($rate) {
                        case '01': $tax = 0; break;
                        case '02': $tax = 0.01; break;
                        case '03': $tax = 0.02; break;
                        case '04': $tax = 0.04; break;
                        case '05': $tax = 0; break;
                        case '06': $tax = 0.04; break;
                        case '07': $tax = 0.08; break;
                        case '08': $tax = 0.13; break;
                        case '09': $tax = 0.5; break;
                        default: break;
                    }
                    
                    InvoiceDetail::create([
                        'id_invoice' => $invoice->id, 
                        'id_product' => (is_numeric($_POST['productId'][$i])) ? $_POST['productId'][$i] : 0, 
                        'cabys' => $_POST['cabys'][$i], 
                        'tax' => $tax, 
                        'rate' => $rate, 
                        'gravado' => $_POST['gravado'][$i], 
                        'detail' => $_POST['detail'][$i], 
                        'description' => $_POST['product'][$i], 
                        'line_type' => $_POST['unit'][$i],  
                        'subprice' => $_POST['productSubPrice'][$i], 
                        'price' => $_POST['productPrice'][$i], 
                        'quantity' => $_POST['quantity'][$i], 
                        'total' => number_format(($_POST['quantity'][$i] * $_POST['productPrice'][$i]), 2, ".","")
                    ]);

                    $subtotal = $subtotal + ($_POST['quantity'][$i] * $_POST['productPrice'][$i]);
                    $inventory = Inventory::where('id', '=', $_POST['productId'][$i])->first();
                    if(isset($inventory->id)) {
                        $inventory->decreaseInventory($_POST['quantity'][$i],$invoice->id,DocumentType::FACTURA, 'Factura de Venta #'. $invoice->id, $user->id);
                    }
                }
            }

            $invoice->total = $subtotal;
            $invoice->update();
        }

        if($typeInvoice == 0) {
            $this->sendToSystem($invoice);
        }

        if($typeInvoice == 1) {
            return redirect()->route('invoice.proform');
        }else{
            if($ticket == 1) {
                return redirect()->route('invoice.index', ['month' => base64_encode(date('m')), 'year' => base64_encode(date('Y')), 'billtype' => 1]);
            }else{
                return redirect()->route('invoice.index');
            }
        }
        
    }

    public function sendToSystem($invoice) {
        $details = InvoiceDetail::where('id_invoice', '=', $invoice->id)->get();

        $type_payment = '';
        switch ($invoice->type_payment) {
            case '01': $type_payment = 'Contado'; break;
            case '02': $type_payment = 'Crédito'; break;
            case '03': $type_payment = 'Consignación'; break;
            case '04': $type_payment = 'Apartado'; break;
            default: break;
        }

        if($invoice->ticket == 0) {
            $det = [
                "modoPago" => $type_payment,
                "medioPago" => $invoice->payment,
                "nombreCliente" => $invoice->name,
                "tipoCedula" => $invoice->type_dni,
                "cedula" => $invoice->dni,
                "email" => $invoice->email
            ];
            
            $prods = [];
            foreach ($details as $detail) {
                $aux = [
                    "cabys" => $detail->cabys,
                    "impuesto" => $detail->tax,
                    "tarifaCodigo" => $detail->rate,
                    "tipo" => $detail->gravado,
                    "description" => $detail->description,
                    "details" => $detail->detail,
                    "lineType" => $detail->line_type,
                    "unitPrice" => $detail->price,
                    "notes" => "Nada",
                    "cantidad" => $detail->quantity
                ];
                array_push($prods, $aux);
            }

            $products = [
                'productos' => $prods
            ];

            $vetRow = Vets::select('id', 'dni')->where('id', '=', $invoice->id_vet)->first();

            $payload = '<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
                            <Body>
                                <Recibe_Json_CreateTicket xmlns="urn:server">
                                    <veterinaria>' . $vetRow->dni . '</veterinaria>
                                    <detalles>' . json_encode($det) . '</detalles>
                                    <productos>' . json_encode($products) . '</productos>
                                    <modo>0</modo>
                                    <idCliente>' . $invoice->id_vet . '</idCliente>
                                    <idMascota>1</idMascota>
                                </Recibe_Json_CreateTicket>
                            </Body>
                        </Envelope>';
        }else{
            $det = [
                "modoPago" => $type_payment,
                "medioPago" => $invoice->payment
            ];
            
            $prods = [];
            foreach ($details as $detail) {
                $aux = [
                    "cabys" => $detail->cabys,
                    "impuesto" => $detail->tax,
                    "tarifaCodigo" => $detail->rate,
                    "tipo" => $detail->gravado,
                    "description" => $detail->description,
                    "details" => $detail->detail,
                    "lineType" => $detail->line_type,
                    "unitPrice" => $detail->price,
                    "notes" => "Nada",
                    "cantidad" => $detail->quantity
                ];
                array_push($prods, $aux);
            }

            $products = [
                'productos' => $prods
            ];

            $vetRow = Vets::select('id', 'dni')->where('id', '=', $invoice->id_vet)->first();

            $payload = '<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
                            <Body>
                                <Recibe_Json_CreateTicket xmlns="urn:server">
                                    <veterinaria>' . $vetRow->dni . '</veterinaria>
                                    <detalles>' . json_encode($det) . '</detalles>
                                    <productos>' . json_encode($products) . '</productos>
                                    <modo>0</modo>
                                    <idCliente>' . $invoice->id_vet . '</idCliente>
                                    <idMascota>1</idMascota>
                                </Recibe_Json_CreateTicket>
                            </Body>
                        </Envelope>';
        }

        $setting = Setting::select('id', 'user_invoice', 'pass_invoice', 'environment_invoice')->where('id', '=', 1)->first();

        $urlService = ($setting->environment_invoice == 1) ? env('InvoiceUrlTest') : env('InvoiceUrlProd');

        $token = base64_encode($setting->user_invoice) . ':' . base64_encode($setting->pass_invoice);
        $token = base64_encode($token);

        Log::notice(__METHOD__ . ', line #' . (__LINE__) . ' payload create invoice= ' . json_encode($payload));
        Log::notice(__METHOD__ . ', line #' . (__LINE__) . ' urlService create invoice= ' . json_encode($urlService));

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $urlService,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>$payload,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: text/xml',
                'Authorization: Basic ' . $token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        Log::notice(__METHOD__ . ', line #' . (__LINE__) . ' result create invoice= ' . json_encode($response));

        $xml = simplexml_load_string($response);

        $xml = $xml->asXML();

        $pattern = '/<return[^>]*>(.*?)<\/return>/s';

        $result = '';
        if (preg_match($pattern, $xml, $matches)) {
            $result = $matches[1];
        }

        Log::notice(__METHOD__ . ', line #' . (__LINE__) . ' result create invoice decode= ' . json_encode($result));

        if($result != '') {
            try {
                $result = base64_decode($result);

                $result = json_decode($result, true);

                $invoice->status = 2;
                $invoice->errors = json_encode($result);

                if(isset($result['CLAVE'])) {
                    $invoice->clave = $result['CLAVE'];
                }
                if(isset($result['RESPUESTA'])) {
                    $invoice->status = $result['RESPUESTA'];
                }
                $invoice->update();
            } catch (\Throwable $th) {
                Log::notice(__METHOD__ . ', line #' . (__LINE__) . ' error create invoice= ' . json_encode($th));
            }
        }

    }

    public function resend(Request $request) {

        try {
            $payload = '';

            if($request->type == 0) {
                $payload = '<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
                            <Body>
                                <Recibe_Json_ResendInvoice xmlns="urn:server">
                                    <clave>' . $request->clave . '</clave>
                                </Recibe_Json_ResendInvoice>
                            </Body>
                        </Envelope>';
            }

            if($request->type == 1) {
                $payload = '<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
                            <Body>
                                <Recibe_Json_ResendTicket xmlns="urn:server">
                                    <clave>' . $request->clave . '</clave>
                                </Recibe_Json_ResendTicket>
                            </Body>
                        </Envelope>';
            }

            if($payload != '') {
                $setting = Setting::select('id', 'user_invoice', 'pass_invoice', 'environment_invoice')->where('id', '=', 1)->first();

                $urlService = ($setting->environment_invoice == 1) ? env('InvoiceUrlTest') : env('InvoiceUrlProd');

                $token = base64_encode($setting->user_invoice) . ':' . base64_encode($setting->pass_invoice);
                $token = base64_encode($token);

                Log::notice(__METHOD__ . ', line #' . (__LINE__) . ' payload resend invoice= ' . json_encode($payload));
                Log::notice(__METHOD__ . ', line #' . (__LINE__) . ' urlService resend invoice= ' . json_encode($urlService));

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $urlService,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>$payload,
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: text/xml',
                        'Authorization: Basic ' . $token
                    ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);

                Log::notice(__METHOD__ . ', line #' . (__LINE__) . ' result resend invoice= ' . json_encode($response));          
            }

        } catch (\Throwable $th) {
            Log::notice(__METHOD__ . ', line #' . (__LINE__) . ' error resend invoice= ' . json_encode($th));
        }

        return response()->json(array('type' => '200'));
    }

    public function delete (Request $request) {
        $user = Auth::guard('web')->user();

        $id = User::encryptor('decrypt', $request->id);

        $invoice = Invoice::where('id', '=', $id)
                ->where('proforma', '=', 1)
                ->where('id_vet', '=', $user->id_vet)
                ->first();

        if(isset($invoice->id)) {
            $details = InvoiceDetail::where('id_invoice', '=', $invoice->id)->get();
            foreach ($details as $detail) {
                $inventory = Inventory::where('id', '=', $detail->id_product)->first();
                if (isset($inventory->id)) {
                    $inventory->increaseInventory($detail->quantity, $invoice->id, DocumentType::FACTURA, 'Anulacion Factura #' . $invoice->id, $user->id);
                }
            }
            $invoice->delete();
        }

        return response()->json(array('type' => '200'));
    }

    public function nc (Request $request) {
        $clave = $request->clave;

        if($clave != '') {
            try {
                $setting = Setting::select('id', 'user_invoice', 'pass_invoice', 'environment_invoice')->where('id', '=', 1)->first();

                $urlService = ($setting->environment_invoice == 1) ? env('InvoiceUrlTest') : env('InvoiceUrlProd');

                $token = base64_encode($setting->user_invoice) . ':' . base64_encode($setting->pass_invoice);
                $token = base64_encode($token);
                
                $payload = '<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
                            <Body>
                                <Recibe_Json_GetInvoice xmlns="urn:server">
                                    <clave>'.$clave.'</clave>
                                </Recibe_Json_GetInvoice>
                            </Body>
                        </Envelope>';
                $payloadDetail = '<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
                            <Body>
                                <Recibe_Json_GetInvoiceProducts xmlns="urn:server">
                                    <clave>'.$clave.'</clave>
                                </Recibe_Json_GetInvoiceProducts>
                            </Body>
                        </Envelope>';

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $urlService,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>$payload,
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: text/xml',
                        'Authorization: Basic ' . $token
                    ),
                ));
    
                $response = curl_exec($curl);
    
                curl_close($curl);
    
                $xml = simplexml_load_string($response);
    
                $xml = $xml->asXML();
    
                $pattern = '/<return[^>]*>(.*?)<\/return>/s';
    
                $result = '';
                if (preg_match($pattern, $xml, $matches)) {
                    $result = $matches[1];
                }
    
                $invoice = [];
                if($result != '') {
                    try {
                        $result = base64_decode($result);
    
                        $invoice = json_decode($result, true);
                        if(isset($invoice[0])) {
                            $invoice = $invoice[0];
                        }
                    } catch (\Throwable $th) {
                        Log::notice(__METHOD__ . ', line #' . (__LINE__) . ' error detail invoice= ' . json_encode($th));
                    }
                }
    
                $curlDetail = curl_init();
                curl_setopt_array($curlDetail, array(
                    CURLOPT_URL => $urlService,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>$payloadDetail,
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: text/xml',
                        'Authorization: Basic ' . $token
                    ),
                ));
    
                $responseDetail = curl_exec($curlDetail);
    
                curl_close($curlDetail);
    
                $xmlDetail = simplexml_load_string($responseDetail);
    
                $xmlDetail = $xmlDetail->asXML();
    
                $pattern = '/<return[^>]*>(.*?)<\/return>/s';
    
                $resultDetail = '';
                if (preg_match($pattern, $xmlDetail, $matches)) {
                    $resultDetail = $matches[1];
                }
        
                $details = [];
                if($resultDetail != '') {
                    try {
                        $resultDetail = base64_decode($resultDetail);
    
                        $details = json_decode($resultDetail, true);
                    } catch (\Throwable $th) {
                        Log::notice(__METHOD__ . ', line #' . (__LINE__) . ' error detail invoice= ' . json_encode($th));
                    }
                }

                $det = [
                    "codigo" => (isset($invoice['ID'])) ? $invoice['ID'] : '',
                    "veterinaria" => (isset($invoice['VETERINARIA'])) ? $invoice['VETERINARIA'] : '',
                    "fechaEmision" => (isset($invoice['FECHAEMISION'])) ? $invoice['FECHAEMISION'] : '',
                    "razon" => (isset($request->razon)) ? $request->razon : '',
                    "tipo" => (isset($request->action)) ? $request->action : '',
                    "fecha" => (isset($invoice['DATE'])) ? $invoice['DATE'] : '',
                    "modoPago" => (isset($invoice['PAYMENT'])) ? $invoice['PAYMENT'] : '',
                    "medioPago" => (isset($invoice['PAYMENTMODE'])) ? $invoice['PAYMENTMODE'] : '',
                    "nombreCliente" => (isset($invoice['CLIENT'])) ? $invoice['CLIENT'] : '',
                    "cedula" => (isset($invoice['DOCUMENT'])) ? $invoice['DOCUMENT'] : '',
                    "tipoCedula" => (isset($invoice['TIPODOCUMENTO'])) ? $invoice['TIPODOCUMENTO'] : '',
                    "clave" => (isset($invoice['CLAVE'])) ? $invoice['CLAVE'] : ''
                ];

                $prods = [];
                foreach ($details as $detail) {
                    $aux = [
                        "cabys" => $detail['CABYS'],
                        "impuesto" => $detail['IMPUESTOCODIGO'],
                        "tarifaCodigo" => $detail['TARIFACODIGO'],
                        "tipo" => $detail['TIPO'],
                        "description" => $detail['DESCRIPTION'],
                        "details" => $detail['DETAILS'],
                        "lineType" => $detail['LINETYPE'],
                        "unitPrice" => $detail['UNITPRICE'],
                        "notes" => $detail['NOTES'],
                        "cantidad" => $detail['AMOUNT'],
                    ];
                    array_push($prods, $aux);

                }

                $products = [
                    'productos' => $prods
                ];

                $payload = '<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
                            <Body>
                                <Recibe_Json_CreateCreditNote xmlns="urn:server">
                                    <veterinaria>' . $invoice['VETERINARIA'] . '</veterinaria>
                                    <detalles>' . json_encode($det) . '</detalles>
                                    <productos>' . json_encode($products) . '</productos>
                                    <modo>0</modo>
                                    <idCliente>' . $invoice['IDCLIENTE'] . '</idCliente>
                                    <idMascota>' . $invoice['IDMASCOTA'] . '</idMascota>
                                </Recibe_Json_CreateCreditNote>
                            </Body>
                        </Envelope>';

                Log::notice(__METHOD__ . ', line #' . (__LINE__) . ' payload create nc= ' . json_encode($payload));

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $urlService,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>$payload,
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: text/xml',
                        'Authorization: Basic ' . $token
                    ),
                ));
        
                $response = curl_exec($curl);
        
                curl_close($curl);
        
                Log::notice(__METHOD__ . ', line #' . (__LINE__) . ' result create nc= ' . json_encode($response));
        
                $xml = simplexml_load_string($response);
        
                $xml = $xml->asXML();
        
                $pattern = '/<return[^>]*>(.*?)<\/return>/s';
        
                $result = '';
                if (preg_match($pattern, $xml, $matches)) {
                    $result = $matches[1];
                }

                $claveCreate = '';
                if($result != '') {
                    try {
                        $result = base64_decode($result);
        
                        $result = json_decode($result, true);
                
                        if(isset($result['RESPUESTA']['resp']['clave'])) {
                            $claveCreate = $result['RESPUESTA']['resp']['clave'];
                        }
                    } catch (\Throwable $th) {
                        Log::notice(__METHOD__ . ', line #' . (__LINE__) . ' error create nc= ' . json_encode($th));
                    }
                }

                if($claveCreate != '') {
                    $invoice_ref= substr($invoice['CLAVE'], 31, 10);
                    $invoice_details = InvoiceDetail::where('id_invoice', '=', $invoice_ref);
                    foreach ($invoice_details as $detail) {
                        $inventory = Inventory::where('id', '=', $detail->id_product)->first();
                        $inventory->increaseInventory($detail->quantity, $invoice['ID'],DocumentType::NOTA_CREDITO, 'Nota de Crédito #' . $invoice['ID'], $user->id);
                    }
                    return response()->json(array('type' => '200', 'clave' => $claveCreate));
                }else{
                    return response()->json(array('type' => '500'));
                }

            } catch (\Throwable $th) {
                Log::notice(__METHOD__ . ', line #' . (__LINE__) . ' error create nc= ' . json_encode($th));
            }
        }

        return response()->json(array('type' => '500'));
    }

    public function uptake() {
        return view('invoice.uptake');
    }

    public function uploadUptake(Request $request) {
        $archivo = $request->file('uploadinvoice');

        $uptake = $request->uptake;
        $condition = $request->condition;

        try {            
            $xml = simplexml_load_file($archivo->getPathname());

            $json = json_encode($xml);
            $array = json_decode($json, TRUE);

            $emisor = (isset($array['Emisor'])) ? $array['Emisor'] : [];
            $fechaEmision = $array['FechaEmision'] ?? '';
            $Clave = $array['Clave'] ?? 'No disponible';
            $NumeroConsecutivo = $array['NumeroConsecutivo'] ?? 'No disponible';

            $CondicionVenta = $array['CondicionVenta'] ?? '';
            $MedioPago = $array['MedioPago'] ?? '';

            $CodigoMoneda = $array['ResumenFactura']['CodigoTipoMoneda']['CodigoMoneda'] ?? '';
            $TipoCambio = $array['ResumenFactura']['CodigoTipoMoneda']['TipoCambio'] ?? '';

            $TotalImpuesto = $array['ResumenFactura']['TotalImpuesto'] ?? '';
            $TotalComprobante = $array['ResumenFactura']['TotalComprobante'] ?? '';

        } catch (\Throwable $th) {
            $error = $th->getMessage();
            return view('invoice.uptake', compact('error'));
        }

        return view('invoice.uptake-detail', compact(
            'uptake',
            'condition',
            'emisor', 
            'fechaEmision',
            'Clave', 
            'NumeroConsecutivo',
            'CondicionVenta',
            'MedioPago',
            'CodigoMoneda',
            'TipoCambio',
            'TotalImpuesto',
            'TotalComprobante'
        ));
    }

    public function saveUptake(Request $request) {
        $user = Auth::guard('web')->user();
        
        $vetRow = Vets::select('id', 'dni')->where('id', '=', $user->id_vet)->first();

        $msg = trans('dash.finish.uptake');
        $msgType = 'success';

        try {
            $det = [
                "clave" => $request->Clave,
                "emisor" => $request->nombreEmisor,
                "cedulaEmisor" => $request->dniEmisor,
                "tipoCedula" => $request->typeEmisor,
                "fechaEmision" => $request->fechaEmision,
                "medioPago" => $request->MedioPago,
                "tipoDocumento" => "01",
                "veterinaria" => $vetRow->dni,
                "condicionVenta" => $request->CondicionVenta,
                "medioPago" => $request->MedioPago,
                "sucursal" => "001",
                "caja" => "00001",
                "tipoCambio" => $request->TipoCambio,
                "codigoMoneda" => $request->CodigoMoneda,
                "condicionImpuesto" => $request->condition,
                "tipoAceptacion" => $request->uptake,
                "totalImpuesto" => $request->totalTaxes,
                "totalComprobante" => $request->totalFactura,
            ];

            $payload = '';
            $payload = '<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
                        <Body>
                            <Recibe_Json_CreateAccept xmlns="urn:server">
                                <veterinaria>' . $vetRow->dni . '</veterinaria>
                                <detalles>' . json_encode($det) . '</detalles>
                                <modo>0</modo>
                            </Recibe_Json_CreateAccept>
                        </Body>
                    </Envelope>';
         
            if($payload != '') {
                $setting = Setting::select('id', 'user_invoice', 'pass_invoice', 'environment_invoice')->where('id', '=', 1)->first();

                $urlService = ($setting->environment_invoice == 1) ? env('InvoiceUrlTest') : env('InvoiceUrlProd');

                $token = base64_encode($setting->user_invoice) . ':' . base64_encode($setting->pass_invoice);
                $token = base64_encode($token);

                Log::notice(__METHOD__ . ', line #' . (__LINE__) . ' payload accept invoice= ' . json_encode($payload));
                Log::notice(__METHOD__ . ', line #' . (__LINE__) . ' urlService accept invoice= ' . json_encode($urlService));

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $urlService,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>$payload,
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: text/xml',
                        'Authorization: Basic ' . $token
                    ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);

                Log::notice(__METHOD__ . ', line #' . (__LINE__) . ' result accept invoice= ' . json_encode($response));    
                
                try {
                    $xml = simplexml_load_string($response);

                    $xml = $xml->asXML();

                    $pattern = '/<return[^>]*>(.*?)<\/return>/s';

                    $result = '';
                    if (preg_match($pattern, $xml, $matches)) {
                        $result = $matches[1];
                    }

                    Log::notice(__METHOD__ . ', line #' . (__LINE__) . ' result create invoice decode= ' . json_encode($result));

                } catch (\Throwable $th) {
                    $msgType = 'danger';
                    $msg = str_replace(['\n', '/'], ['', ' '], strip_tags($response));
                }
            }

            return redirect()->route('invoice.uptakeFinish', ['message' => $msg, 'msgType' => $msgType]);
            
        } catch (\Throwable $th) {
            Log::notice(__METHOD__ . ', line #' . (__LINE__) . ' error accept invoice= ' . json_encode($th));
            $error = $th->getMessage();
            return view('invoice.uptake', compact('error'));
        }
    }

    public function finishUptake(Request $request) {
        $message = $request->message;
        $msgType = $request->msgType;

        return view('invoice.uptake', compact('message', 'msgType'));
    }
}
<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Schedule;
use App\Models\ScheduleExtraSlots;
use App\Models\ScheduleExceptions;
use App\Models\ScheduleConfiguration;
use Carbon\CarbonPeriod;


class ScheduleController extends Controller
{
    /**
     * Display the schedule menu.
     */
    public function menu()
    {
        return view('schedule.menu');
    }

    /**
     * Show the authenticated user's schedule.
     */
    public function schedule()
    {
        $row = Schedule::with('scheduleDetails')->where('id_user', Auth::guard('web')->user()->id)->first();
        if ($row) {
            return view('schedule.schedule.edit', ['schedule' => $row]);
        }
        return view('schedule.schedule.add');
    }

    /**
     * Update an existing schedule in storage.
     */
    public function updateSchedule(Request $request)
    {
        $user = Auth::guard('web')->user();
        $schedule = Schedule::where('id_user', $user->id)->first();
        if (!$schedule) {
            abort(404, 'No se encontró el horario para actualizar.');
        }
        $days = $request->input('schedule');
        // First, delete existing schedule details for this schedule
        $schedule->scheduleDetails()->delete();
        foreach ($days as $day => $times) {

            foreach ($times as $time) {

                if (
                    empty($time['from']) ||
                    empty($time['to'])
                ) {
                    continue;
                }

                $schedule->scheduleDetails()->create([
                    'day_of_week' => $day,
                    'start_time'  => $time['from'],
                    'end_time'    => $time['to'],
                    'status'      => '1',
                ]);
            }
        }
        return redirect()->route('schedule.menu')->with('success', 'Horario actualizado exitosamente.');
    }

    /**
     * Store a newly created schedule in storage.
     */
    public function storeSchedule(Request $request)
    {
        $user = Auth::guard('web')->user();
        $scheduleObj = Schedule::create([
            'id_user' => $user->id,
            'description' => "Horario de " . $user->name,
            'status' => '1',
        ]);

        $schedule = $request->input('schedule');

        foreach ($schedule as $day => $times) {

            // Process each day's schedule
            foreach ($times as $time) {
                if (!isset($time['from']) || !isset($time['to'])) {
                    // skip invalid or empty day
                    continue;
                }

                $start = $time['from'];
                $end   = $time['to'];

                if (!$start || !$end) {
                    continue;
                }

                // Save or update the schedule in the database
                $scheduleObj->scheduleDetails()->create([
                    'day_of_week' => $day,
                    'start_time' => $start,
                    'end_time' => $end,
                    'status' => '1',
                ]);
            }
        }
        return redirect()->route('schedule.menu')->with('success', 'Horario creado exitosamente.');
    }

    /**
     * Show the list of extra schedule entries.
     */
    public function indexExtra(Request $request)
    {
        $row = Schedule::with('scheduleDetails')->where('id_user', Auth::guard('web')->user()->id)->first();
        if ($row) {

            $search = (isset($request->search)) ? $request->search : '';

            $rows = ScheduleExtraSlots::select('id', 'description', 'date', 'start_time', 'end_time')->where('id_schedule', '=', $row->id)->whereDate('date', '>=', Carbon::today());
            if ($search != '') {
                $search = base64_decode($search);

                $searchParam = '%' . $search . '%';
                $rows = $rows->where('description', 'like', $searchParam)
                    ->orWhere('date', 'like', $searchParam)
                    ->orWhere('start_time', 'like', $searchParam)
                    ->orWhere('end_time', 'like', $searchParam);
            }

            $rows = $rows->paginate(30);
            return view('schedule.extra.index', compact('rows', 'search'));
        }
        return view('schedule.schedule.add', ['message' => 'Primero debe crear su horario regular antes de agregar disponibilidad extra.']);
    }

    /**
     * Show the form for creating a new extra schedule entry.
     */
    public function addExtra()
    {
        return view('schedule.extra.add');
    }

    /**
     * Delete an extra schedule entry.
     */
    public function deleteExtra(Request $request)
    {

        $id = User::encryptor('decrypt', $request->id);

        $slot = ScheduleExtraSlots::find($id);
        if (!$slot) {
            return response()->json(['process' => '0', 'message' => 'No se encontró el segmento.']);
        }

        $slot->delete();

        return response()->json(['process' => '1', 'message' => 'Segmento eliminado exitosamente.']);
    }

    /**
     * Store a newly created extra schedule entry in storage.
     */
    public function storeExtra(Request $request)
    {

        $user = Auth::guard('web')->user();

        $schedule = Schedule::where('id_user', $user->id)->first();
        if (!$schedule) {
            abort(404, 'No se encontró el horario para actualizar.');
        }



        $description = $request->activityDescription;
        $dates       = [];

        /* =========================
       Resolver fechas según modo
       ========================= */
        switch ($request->dateMode) {

            case 'single':
                $dates[] = $request->datePicker;
                break;

            case 'multiple':
                $dates = array_map('trim', explode(',', $request->datePicker));
                break;

            case 'range':
                [$start, $end] = array_map('trim', explode('a', $request->datePicker));
                $period = CarbonPeriod::create(
                    Carbon::parse($start),
                    Carbon::parse($end)
                );
                foreach ($period as $date) {
                    $dates[] = $date->format('Y-m-d');
                }
                break;
        }


        /* =========================
       Guardar los segmentos
       ========================= */
        foreach ($dates as $date) {
            foreach ($request->schedule as $slot) {

                $from = $slot['from'] ?? null;
                $to   = $slot['to'] ?? null;

                if (!$from || !$to) {
                    continue;
                }

                // Normalizar formato de hora (evita errores de Carbon)
                try {
                    $startTime = Carbon::createFromFormat('H:i', $from)->format('H:i:s');
                    $endTime   = Carbon::createFromFormat('H:i', $to)->format('H:i:s');
                } catch (\Exception $e) {
                    continue; // formato inválido
                }

                // Validación lógica de horas
                if ($startTime >= $endTime) {
                    continue;
                }

                $schedule->scheduleExtraSlots()->create([
                    'description' => $description,
                    'date'        => $date,
                    'start_time'  => $startTime,
                    'end_time'    => $endTime,
                ]);
            }
        }

        return redirect()
            ->route('schedule.extra.index')
            ->with('success', 'Disponibilidad extra agregada exitosamente.');
    }

    /**
     * Show the form for editing an existing extra schedule entry.
     */
    public function editExtra(Request $request)
    {
        $user = Auth::guard('web')->user();

        $id = User::encryptor('decrypt', $request->id);

        $slot = ScheduleExtraSlots::find($id);
        if (!$slot) {
            return redirect()
                ->route('schedule.extra.index')
                ->with('error', 'No se encontró el segmento de disponibilidad extra.');
        }

        return view('schedule.extra.edit', compact('slot'));
    }

    /**
     * Update an existing extra schedule entry in storage.
     */
    public function updateExtra(Request $request)
    {
        $id = User::encryptor('decrypt', $request->hideId);

        $slot = ScheduleExtraSlots::find($id);
        if (!$slot) {
            return redirect()
                ->route('schedule.extra.index')
                ->with('error', 'No se encontró el segmento de disponibilidad extra.');
        }

        // Obtener horario desde el arreglo schedule
        $from = $request->schedule[0]['from'] ?? null;
        $to   = $request->schedule[0]['to'] ?? null;
        // Validación básica
        if (!$from || !$to || $from >= $to) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'El rango de horas no es válido.');
        }

        $slot->description = $request->activityDescription;
        $slot->date        = $request->datePicker;
        $slot->start_time  = Carbon::createFromFormat('H:i', $from)->format('H:i:s');
        $slot->end_time    = Carbon::createFromFormat('H:i', $to)->format('H:i:s');
        $slot->save();

        return redirect()
            ->route('schedule.extra.index')
            ->with('success', 'Segmento de disponibilidad extra actualizado exitosamente.');
    }

    /**
     * Show the list of exception schedule entries.
     */
    public function indexException(Request $request)
    {
        $row = Schedule::with('scheduleDetails')->where('id_user', Auth::guard('web')->user()->id)->first();
        if ($row) {

            $search = (isset($request->search)) ? $request->search : '';

            $rows = ScheduleExceptions::select('id', 'description', 'date', 'start_time', 'end_time')->where('id_schedule', '=', $row->id)->whereDate('date', '>=', Carbon::today());
            if ($search != '') {
                $search = base64_decode($search);

                $searchParam = '%' . $search . '%';
                $rows = $rows->where('description', 'like', $searchParam)
                    ->orWhere('date', 'like', $searchParam)
                    ->orWhere('start_time', 'like', $searchParam)
                    ->orWhere('end_time', 'like', $searchParam);
            }

            $rows = $rows->paginate(30);
            return view('schedule.exception.index', compact('rows', 'search'));
        }
        return view('schedule.schedule.add', ['message' => 'Primero debe crear su horario regular antes de agregar una exception.']);
    }

    /**
     * Show the form for creating a new exception schedule entry.
     */
    public function addException()
    {
        return view('schedule.exception.add');
    }

    /**
     * Delete an exception schedule entry.
     */
    public function deleteException(Request $request)
    {

        $id = User::encryptor('decrypt', $request->id);

        $slot = ScheduleExceptions::find($id);
        if (!$slot) {
            return response()->json(['process' => '0', 'message' => 'No se encontró el segmento.']);
        }

        $slot->delete();

        return response()->json(['process' => '1', 'message' => 'Segmento eliminado exitosamente.']);
    }

    /**
     * Store a newly created exception schedule entry in storage.
     */
    public function storeException(Request $request)
    {

        $user = Auth::guard('web')->user();

        $schedule = Schedule::where('id_user', $user->id)->first();
        if (!$schedule) {
            abort(404, 'No se encontró el horario para actualizar.');
        }



        $description = $request->activityDescription;
        $dates       = [];
        /* =========================
       Resolver fechas según modo
       ========================= */
        switch ($request->dateMode) {

            case 'single':
                $dates[] = $request->datePicker;
                break;

            case 'multiple':
                $dates = array_map('trim', explode(',', $request->datePicker));
                break;

            case 'range':
                [$start, $end] = array_map('trim', explode('a', $request->datePicker));
                $period = CarbonPeriod::create(
                    Carbon::parse($start),
                    Carbon::parse($end)
                );
                foreach ($period as $date) {
                    $dates[] = $date->format('Y-m-d');
                }
                break;
        }


        /* =========================
       Guardar los segmentos
       ========================= */
        foreach ($dates as $date) {
            foreach ($request->schedule as $slot) {

                $from = $slot['from'] ?? null;
                $to   = $slot['to'] ?? null;

                if (!$from || !$to) {
                    continue;
                }

                // Normalizar formato de hora (evita errores de Carbon)
                try {
                    $startTime = Carbon::createFromFormat('H:i', $from)->format('H:i:s');
                    $endTime   = Carbon::createFromFormat('H:i', $to)->format('H:i:s');
                } catch (\Exception $e) {
                    continue; // formato inválido
                }

                // Validación lógica de horas
                if ($startTime >= $endTime) {
                    continue;
                }

                $schedule->scheduleExceptions()->create([
                    'description' => $description,
                    'date'        => $date,
                    'start_time'  => $startTime,
                    'end_time'    => $endTime,
                ]);
            }
        }

        return redirect()
            ->route('schedule.exception.index')
            ->with('success', 'Disponibilidad exception agregada exitosamente.');
    }

    /**
     * Show the form for editing an existing exception schedule entry.
     */
    public function editException(Request $request)
    {
        $user = Auth::guard('web')->user();

        $id = User::encryptor('decrypt', $request->id);

        $slot = ScheduleExceptions::find($id);
        if (!$slot) {
            return redirect()
                ->route('schedule.exception.index')
                ->with('error', 'No se encontró el segmento de una exception.');
        }

        return view('schedule.exception.edit', compact('slot'));
    }

    /**
     * Update an existing exception schedule entry in storage.
     */
    public function updateException(Request $request)
    {
        $id = User::encryptor('decrypt', $request->hideId);

        $slot = ScheduleExceptions::find($id);
        if (!$slot) {
            return redirect()
                ->route('schedule.exception.index')
                ->with('error', 'No se encontró el segmento de una exception.');
        }

        // Obtener horario desde el arreglo schedule
        $from = $request->schedule[0]['from'] ?? null;
        $to   = $request->schedule[0]['to'] ?? null;
        // Validación básica
        if (!$from || !$to || $from >= $to) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'El rango de horas no es válido.');
        }

        $slot->description = $request->activityDescription;
        $slot->date        = $request->datePicker;
        $slot->start_time  = Carbon::createFromFormat('H:i', $from)->format('H:i:s');
        $slot->end_time    = Carbon::createFromFormat('H:i', $to)->format('H:i:s');
        $slot->save();

        return redirect()
            ->route('schedule.exception.index')
            ->with('success', 'Segmento de una exception actualizado exitosamente.');
    }

    /**
     * Show the schedule configuration for the authenticated user.
     */
    public function configuration()
    {
        $user = Auth::guard('web')->user();

        $schedule = Schedule::where('id_user', $user->id)->first();
        if (!$schedule) {
            return redirect()
                ->route('schedule.menu')
                ->with('error', 'Primero debe crear su horario antes de configurar.');
        }

        $configuration = ScheduleConfiguration::where('id_schedule', $schedule->id)->first();
        if ($configuration) {
            return view('schedule.configuration.edit', compact('configuration'));
        }

        return view('schedule.configuration.add');
    }

    /**
     * Show the form for creating a new schedule configuration.
     */
    public function addConfiguration()
    {
        return view('schedule.configuration.add');
    }

    /**
     * Show the form for editing an existing schedule configuration.
     */
    public function editConfiguration(Request $request)
    {
        $id = User::encryptor('decrypt', $request->id);

        $configuration = ScheduleConfiguration::find($id);
        if (!$configuration) {
            return redirect()
                ->route('schedule.menu')
                ->with('error', 'No se encontró la configuración del horario.');
        }

        return view('schedule.configuration.edit', compact('configuration'));
    }

    /**
     * Store a newly created schedule configuration in storage.
     */
    public function storeConfiguration(Request $request)
    {
        $user = Auth::guard('web')->user();

        $schedule = Schedule::where('id_user', $user->id)->first();
        if (!$schedule) {
            abort(404, 'No se encontró el horario para actualizar.');
        }
        switch ($request->min_time_unit) {
            case 'days':
                $request->min_time_from_today = $request->min_time_from_today * 24 * 60;
                break;
            case 'hours':
                $request->min_time_from_today = $request->min_time_from_today * 60;
                break;
            case 'minutes':
                // already in minutes
                break;
        }
        switch ($request->max_time_unit) {
            case 'days':
                $request->max_time_from_today = $request->max_time_from_today * 24 * 60;
                break;
            case 'hours':
                $request->max_time_from_today = $request->max_time_from_today * 60;
                break;
            case 'minutes':
                // already in minutes
                break;
        }

        $configuration = ScheduleConfiguration::create([
            'id_schedule'            => $schedule->id,
            'min_time_from_today'    => $request->min_time_from_today,
            'max_time_from_today'    => $request->max_time_from_today,
            'time_before_appointment' => $request->time_before_appointment,
            'time_after_appointment' => $request->time_after_appointment,
            'procedure_break_time'   => $request->procedure_break_time,
            'daily_appointment_limit' => $request->daily_appointment_limit,
        ]);

        return redirect()
            ->route('schedule.menu')
            ->with('success', 'Configuración del horario creada exitosamente.');
    }

    /**
     * Update an existing schedule configuration in storage.
     */
    public function updateConfiguration(Request $request)
    {
        $id = User::encryptor('decrypt', $request->hideId);

        $configuration = ScheduleConfiguration::find($id);
        if (!$configuration) {
            return redirect()
                ->route('schedule.menu')
                ->with('error', 'No se encontró la configuración del horario.');
        }

        $configuration->min_days_from_today     = $request->min_days_from_today;
        $configuration->max_days_from_today     = $request->max_days_from_today;
        $configuration->time_between_slots      = $request->time_between_slots;
        $configuration->time_before_appointment = $request->time_before_appointment;
        $configuration->time_after_appointment  = $request->time_after_appointment;
        $configuration->procedure_break_time    = $request->procedure_break_time;
        $configuration->daily_appointment_limit = $request->daily_appointment_limit;
        $configuration->save();

        return redirect()
            ->route('schedule.menu')
            ->with('success', 'Configuración del horario actualizada exitosamente.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Specialty;
use App\Appointment;
use App\CancelledAppointment;
use App\WorkDay;

use App\Interfaces\ScheduleServiceInterface;
use App\Http\Requests\StoreAppointment;

use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;


class AppointmentController extends Controller
{

    public function getAvailableIntervals($date, $doctorId)
    {
        $workDay = WorkDay::where('active', true)
            ->where('day', $this->getDayFromDate($date))
            ->where('user_id', $doctorId)
            ->first([
                'morning_start', 'morning_end',
                'afternoon_start', 'afternoon_end'
            ]);

        if ($workDay) {
            $morningIntervals = $this->getIntervals(
                $workDay->morning_start, $workDay->morning_end,
                $date, $doctorId
            );

            $afternoonIntervals = $this->getIntervals(
                $workDay->afternoon_start, $workDay->afternoon_end,
                $date, $doctorId
            );
        } else {
            $morningIntervals = [];
            $afternoonIntervals = [];
        }

        $data = [];
        $data['morning'] = $morningIntervals;
        $data['afternoon'] = $afternoonIntervals;

        return $data;
    }
    public function index()
    {
        $role = auth()->user()->role;

        if ($role == 'admin') {
            $pendingAppointments = Appointment::where('status', 'Reservada')
                ->paginate(10);
            $confirmedAppointments = Appointment::where('status', 'Confirmada')
                ->paginate(10);
            $oldAppointments = Appointment::whereIn('status', ['Atendida', 'Cancelada'])
                ->paginate(10);

        } elseif ($role == 'doctor') {
            $pendingAppointments = Appointment::where('status', 'Reservada')
                ->where('doctor_id', auth()->id())
                ->paginate(10);
            $confirmedAppointments = Appointment::where('status', 'Confirmada')
                ->where('doctor_id', auth()->id())
                ->paginate(10);
            $oldAppointments = Appointment::whereIn('status', ['Atendida', 'Cancelada'])
                ->where('doctor_id', auth()->id())
                ->paginate(10);

        } elseif ($role == 'patient') {
            $pendingAppointments = Appointment::where('status', 'Reservada')
                ->where('patient_id', auth()->id())
                ->paginate(10);
            $confirmedAppointments = Appointment::where('status', 'Confirmada')
                ->where('patient_id', auth()->id())
                ->paginate(10);
            $oldAppointments = Appointment::whereIn('status', ['Atendida', 'Cancelada'])
                ->where('patient_id', auth()->id())
                ->paginate(10);
        }
        return view('appointments.index',
            compact(
                'pendingAppointments', 'confirmedAppointments', 'oldAppointments',
                'role'
            )
        );
    }
    public function show(Appointment $appointment)
    {
        $role = auth()->user()->role;
        // return $appointment->cancellation->cancelled_by->name;
        return view('appointments.show',compact('appointment','role'));
    }
    public function create(ScheduleServiceInterface $scheduleService)
    {
        $specialties = Specialty::all();

        $specialtyId = old('specialty_id');
        if ($specialtyId) {
            $specialty = Specialty::find($specialtyId);
            $doctors = $specialty->users;
        } else {
            $doctors = collect();
        }

        $date = old('scheduled_date');
        $doctorId = old('doctor_id');
        if ($date && $doctorId) {
            $intervals = $scheduleService->getAvailableIntervals($date, $doctorId);
        } else {
            $intervals = null;
        }

        return view('appointments.create', compact('specialties', 'doctors', 'intervals'));
    }
    public function store(StoreAppointment $request)
    {
        $patientId=$request->user()->id();

    	$created= Appointment::createForPatient($request,$patientId);

        if($created){
            return back()->with('success','La cita se ha registrado correctamente.');
        }else{
            $notification='Ocurrio una problema al registrar la cita, profavor intente nuevamente.';
            return back()->withErrors($notification);
        }


    }
    public function postCancel(Appointment $appointment,Request $request)
    {
        if ($request->has('justification')) {
            $cancellation = new CancelledAppointment();
            $cancellation->justification = $request->input('justification');
            $cancellation->cancelled_by_id = auth()->id();
            // $cancellation->appointment_id = ;
            // $cancellation->save();

            $appointment->cancellation()->save($cancellation);
        }

        $appointment->status = 'cancelada';
        $saved = $appointment->save(); // update

        if ($saved)
            return $appointment->patient->sendFCM('Su cita ha sido cancelada.');

        $notification = 'La cita se ha cancelado correctamente.';
        return redirect('/appointments')->with(compact('notification'));
    }
    public function showCancelForm(Appointment $appointment){
        $role = auth()->user()->role;
        if ($appointment->status == 'confirmada' || $role=='admin'||$role=='doctor') {
            return view('appointments.cancel', compact('appointment', 'role'));
        }

        return redirect('/appointments');
    }
    public function postConfirm(Appointment $appointment)
    {
        $appointment->status = 'confirmada';
        $saved = $appointment->save(); // update

        if ($saved){}
            $appointment->patient->sendFCM('Su cita se ha confirmado!');

        $notification = 'La cita se ha confirmado correctamente.';
        return redirect('/appointments')->with(compact('notification'));
    }
}

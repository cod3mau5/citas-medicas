<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreAppointment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Appointment;

// "id": 303,
// "description": "ayuda juaannn!!!",
// "specialty_id": 19,
// "doctor_id": 2,
// "patient_id": 111,
// "scheduled_date": "2023-02-22",
// "type": "Consulta",
// "status": "confirmada",
// "created_at": "2023-02-22T16:27:21.000000Z",
// "updated_at": "2023-02-22T23:25:15.000000Z",
// "scheduled_time_12": "9:00 AM"

class AppointmentController extends Controller
{
    public function index(Request $request){
        $user= $request->user();
        // $user= User::findOrFail($request->user()->id);
        // return $user->asPatientAppointments;
        $appointments= $user->asPatientAppointments()
        ->with(
            [
                'specialty'=>function($q){
                        $q->select('id','name');
                },
                'doctor'=>function($q){
                    $q->select('id','name');
                }
        ])
        ->get([
            "id",
            "description",
            "specialty_id",
            "doctor_id",
            "scheduled_date",
            "scheduled_time",
            "type",
            "created_at",
            "status"
        ]);
        return $appointments;

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
    public function store(StoreAppointment $request){
        $appointment= Appointment::createForPatient($request,auth()->id());

        $appointment ? $success=true : $success=false;

        return compact('success');
    }
}

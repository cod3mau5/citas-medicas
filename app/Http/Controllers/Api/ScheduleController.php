<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\WorkDay;
use App\Appointment;
use App\Interfaces\ScheduleServiceInterface;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function isAvailableInterval($date, $doctorId, Carbon $start) {
        $exists = Appointment::where('doctor_id', $doctorId)
            ->where('scheduled_date', $date)
            ->where('scheduled_time', $start->format('H:i:s'))
            ->exists();

        return !$exists; // available if already none exists
    }
    public function hours(Request $request, ScheduleServiceInterface $shceduleService)
    {
        $rules=[
            'date'=> 'required|date_format:"Y-m-d"',
            'doctor_id'=>'required|exists:users,id'
        ];
        $request->validate($rules);

        $date=$request->input('date');
        $doctorId=$request->input('doctor_id');

        
        return $shceduleService->getAvailableIntervals($date,$doctorId);;
    }

}

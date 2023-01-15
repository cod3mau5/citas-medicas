<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\WorkDay;
use App\Appointment;
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
    public function hours(Request $request)
    {
        $rules=[
            'date'=> 'required|date_format:"Y-m-d"',
            'doctor_id'=>'required|exists:users.id'
        ];
        $date=$request->input('date');
        $dayCarbon= new Carbon($date);
        $day=$dayCarbon->dayOfWeek;
        $doctorId=$request->input('doctor_id');
        $day=($day==0?6:$day-1);
//        dd($day);

        $workDay= WorkDay::where('active',true)
            ->where('day',$day)
            ->where('user_id',$doctorId)->first([
                'morning_start','morning_end',
                'afternoon_start','afternoon_end'
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
    private function getIntervals($start, $end, $date, $doctorId) {
        $start = new Carbon($start);
        $end = new Carbon($end);

        $intervals = [];

        while ($start < $end) {
            $interval = [];

            $interval['start']  = $start->format('g:i A');

            $available = $this->isAvailableInterval($date, $doctorId, $start);

            $start->addMinutes(30);
            $interval['end']  = $start->format('g:i A');

            if ($available) {
                $intervals []= $interval;
            }
        }

        return $intervals;
    }
}

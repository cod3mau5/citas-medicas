<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\WorkDay;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    private $days = [
        'Lunes', 'Martes', 'Miércoles',
        'Jueves', 'Viernes', 'Sábado', 'Domingo'
    ];
    public function edit()
    {
        $workDays = WorkDay::where('user_id', auth()->id())->get();

        if (count($workDays) > 0) {
            $workDays->map(function ($workDay) {
                $workDay->morning_start = (new Carbon($workDay->morning_start))->format('g:i A');
                $workDay->morning_end = (new Carbon($workDay->morning_end))->format('g:i A');
                $workDay->afternoon_start = (new Carbon($workDay->afternoon_start))->format('g:i A');
                $workDay->afternoon_end = (new Carbon($workDay->afternoon_end))->format('g:i A');
                return $workDay;
            });
        } else {
            $workDays = collect();
            for ($i=0; $i<7; ++$i)
                $workDays->push(new WorkDay());
        }


//         dd($workDays->toArray());
        $days = $this->days;
        return view('schedule', compact('workDays', 'days'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $active = $request->input('active') ?: [];
        $morning_start = $request->input('morning_start');
        $morning_end = $request->input('morning_end');
        $afternoon_start = $request->input('afternoon_start');
        $afternoon_end = $request->input('afternoon_end');

        $errors = [];

        for ($i=0; $i<7; ++$i) {
//            dd( Carbon::parse($morning_start[0])->gt(Carbon::parse($morning_end[0])) );

            $isInconsistent=false;
            if(empty($arrayInc))
                $arrayInc=[];

            if (Carbon::parse($morning_start[$i])->gt(Carbon::parse($morning_end[$i]))) {
                $isInconsistent = true;
                $errors [] = 'Las horas de inicio no pueden ser mayores que las horas de fin el dia ' . $this->days[$i] . ' por la mañana.';
                $arrayInc[]= $i;
            }
            if (Carbon::parse($afternoon_start[$i])->gt(Carbon::parse($afternoon_end[$i]))) {
                $isInconsistent = true;
                $errors [] = 'Las horas de inicio no pueden ser mayores que las horas de fin el dia ' . $this->days[$i] . ' por la tarde.';
                $arrayInc[]= $i;
            }

            if (Carbon::parse($morning_start[$i])->eq(Carbon::parse($morning_end[$i]))) {
                $isInconsistent = true;
                $errors [] = 'Las horas son iguales el dia ' . $this->days[$i] . ' por la mañana.';
                $arrayInc[]= $i;
            }
            if (Carbon::parse($afternoon_start[$i])->eq(Carbon::parse($afternoon_end[$i]))) {
                $isInconsistent = true;
                $errors [] = 'Las horas son iguales el dia ' . $this->days[$i] . ' por la tarde.';
                $arrayInc[]= $i;
            }



            WorkDay::updateOrCreate([
                'day' => $i,
                'user_id' => auth()->id()
            ], [
                'active' => (in_array($i, $active) && !$isInconsistent) ? true : false,
                'morning_start' => $morning_start[$i],
                'morning_end' => $morning_end[$i],
                'afternoon_start' => $afternoon_start[$i],
                'afternoon_end' => $afternoon_end[$i]
            ]);
        }

        if (count($errors) > 0)
            return back()->with(compact('errors','arrayInc'));

        $notification = 'Los cambios se han guardado correctamente.';
        return back()->with(compact('notification'));
    }

}

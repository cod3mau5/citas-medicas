<?php

namespace App\Http\Controllers;

use DB;
use App\Appointment;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $hours=8;
        $timeInMinutes = $hours * 60;
        $appointmentsByDay = Cache::remember('appointments_by_day', $timeInMinutes, function () {
            $query=  Appointment::select([
                        DB::raw('DAYOFWEEK(scheduled_date) as day'),
                        DB::raw('COUNT(*) as count')
                    ])->groupBy(DB::raw('DAYOFWEEK(scheduled_date)'))
                    ->where('status',['confirmada','atendida'])
                    ->get('day','count')
                    ->mapWithKeys(function($it){
                        return [$it['day']=>$it['count']];
                    })->toArray();

            $appointments=[];

            for($i=1;$i<7;$i++){
                if(array_key_exists($i,$query))
                    $appointments[]= $query[$i];
                else
                $appointments[]= 0;
            }

            return $appointments;
        });


        // dd($appointmentsByDay);

        return view('home', compact('appointmentsByDay'));
    }
}

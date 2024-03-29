<?php

namespace App\Console\Commands;

use App\Appointment;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fcm:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar mensajes via FCM';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $headers = ['id', 'scheduled_date', 'scheduled_time', 'patient_id'];
        $this->info("Buscando citas medicas confirmadas en las proximas 24 horas.");
        $appointmentsTomorrow= $this->getAppointments24Hours();
        $this->table($headers, $appointmentsTomorrow);
        foreach($appointmentsTomorrow as $appointment){
            // $this->info($appointment->all());
            if(!empty($appointment->patient)){
                $appointment->patient->sendFCM('Tienes una cita mañana a las '.$appointment->scheduled_time.', no olvides asistir.');
                $this->info("Mensaje FCM enviado 24 horas antes al paciente con ID: $appointment->patient_id");
            }else{
                $this->info("Paciente vacio");
            }
        }



        $this->info("Buscando citas medicas confirmadas en la proxima hora.");
        $appointmentsNextHour= $this->getAppointmentsNextHour();
        $this->table($headers, $appointmentsNextHour->toArray());
        foreach($appointmentsNextHour as $appointment){
            // $this->info($appointment->all());
            if(!empty($appointment->patient)){
                $appointment->patient->sendFCM('Tienes una cita en una hora, te esperamos!.');
                $this->info("Mensaje FCM enviado faltando 1 hora al paciente con ID: $appointment->patient_id");
            }else{
                $this->info("Paciente vacio");
            }
        }


    }
    public function getAppointments24Hours(){
        $now=Carbon::now();
       return $appointments=Appointment::where('status','confirmada')
                    ->where('scheduled_date',$now->addDay()->toDateString())
                    ->where('scheduled_time','>=',$now->copy()->subMinutes(60)->toTimeString())
                    ->where('scheduled_time','<',$now->copy()->addMinutes(60)->toTimeString())
                    ->get(['id','scheduled_date','scheduled_time','specialty_id','patient_id']);

    }
    public function getAppointmentsNextHour(){
        $now=Carbon::now();
       return $appointments=Appointment::where('status','confirmada')
                    ->where('scheduled_date',$now->addHour()->toDateString())
                    ->where('scheduled_time','>=',$now->copy()->subMinutes(30)->toTimeString())
                    ->where('scheduled_time','<',$now->copy()->addMinutes(29)->toTimeString())
                    ->get(['id','scheduled_date','scheduled_time','specialty_id','patient_id']);

    }
}

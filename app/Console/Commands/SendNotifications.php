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
        $this->info("Buscando citas medicas confirmadas en las proximas 24 horas.");

        $appointmentsTomorrow= $this->getAppointments24Hours();
        foreach($appointmentsTomorrow as $appointment){
            $appointment->patient->sendFCM('Tienes una cita mañana, no olvides asistir.');
            $this->info("Mensaje FCM enviado 24 horas antes al paciente con ID: $$appointment->patient_id");
        }

        $appointmentsNextHour= $this->getAppointmentsNextHour();
        foreach($appointmentsNextHour as $appointment){
            $appointment->patient->sendFCM('Tienes una cita en una hora, te esperamos!.');
            $this->info("Mensaje FCM enviado faltando 1 hora al paciente con ID: $$appointment->patient_id");
        }
    }
    public function getAppointments24Hours(){
        $today=Carbon::now();
       return $appointments=Appointment::where('status','confirmada')
                    ->where('scheduled_date',$today->addDay()->toDateString())
                    ->where('scheduled_time','>=',$today->copy()->subMinutes(60)->toTimeString())
                    ->where('scheduled_time','<',$today->copy()->addMinutes(60)->toTimeString())
                    ->get(['id','scheduled_date','scheduled_time','specialty_id'])->toArray();

    }
    public function getAppointmentsNextHour(){
        $today=Carbon::now();
       return $appointments=Appointment::where('status','confirmada')
                    ->where('scheduled_date',$today->addHour()->toDateString())
                    ->where('scheduled_time','>=',$today->copy()->subMinutes(3)->toTimeString())
                    ->where('scheduled_time','<',$today->copy()->addMinutes(2)->toTimeString())
                    ->get(['id','scheduled_date','scheduled_time','specialty_id'])->toArray();

    }
}

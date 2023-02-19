<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Appointment;
use App\Model;
use App\User;
use Faker\Generator as Faker;



$factory->define(Appointment::class, function (Faker $faker) {
    $citas = [
      'El paciente solicita una cita con el cardiólogo para evaluar su presión arterial y su ritmo cardíaco.',
      'Este paciente requiere una cita con el oftalmólogo para una revisión de su agudeza visual y una evaluación de posibles problemas de la vista.',
      'El paciente ha solicitado una cita con el dentista para una limpieza dental y una evaluación de sus dientes y encías.',
      'Este paciente necesita una cita con el ginecólogo para una revisión anual y una evaluación de su salud reproductiva.',
      'El paciente ha solicitado una cita con el neurologista para evaluar sus síntomas de dolor de cabeza frecuentes y para buscar un diagnóstico.',
      'El paciente requiere una cita con el reumatólogo para evaluar sus síntomas de artritis y para encontrar un tratamiento adecuado.',
      'Este paciente necesita una cita con el endocrinólogo para evaluar su función tiroidea y para controlar su condición de diabetes.',
      'El paciente ha solicitado una cita con el oncólogo para un seguimiento después de su tratamiento contra el cáncer.',
      'Este paciente requiere una cita con el psiquiatra para evaluar su salud mental y para buscar un tratamiento adecuado para sus síntomas de ansiedad.',
      'El paciente necesita una cita con el gastroenterólogo para evaluar sus síntomas de dolor abdominal y para buscar un diagnóstico.',
      'Este paciente ha solicitado una cita con el urologo para una evaluación de su salud urinaria.',
      'El paciente requiere una cita con el hematólogo para evaluar su salud sanguínea y para buscar un tratamiento adecuado para cualquier condición que pueda tener.',
      'Este paciente necesita una cita con el neumólogo para evaluar sus síntomas de falta de aliento y para buscar un tratamiento adecuado para cualquier condición pulmonar que pueda tener.',
      'El paciente ha solicitado una cita con el dermatólogo para evaluar un problema de piel reciente.',
      'Este paciente requiere una cita con el ortopedista para evaluar sus síntomas de dolor en las articulaciones y para buscar un trato'];
	$doctorIds = User::doctors()->pluck('id');
	$patientIds = User::patients()->pluck('id');

	$date = $faker->dateTimeBetween('-1 years', 'now');
	$scheduled_date = $date->format('Y-m-d');
	$scheduled_time = $date->format('H:i:s');

	$types = ['consulta', 'examen', 'operación'];
	$statuses = ['atendida', 'cancelada']; // 'Reservada', 'Confirmada'

    return [
        'description' => $faker->randomElement($citas),
        'specialty_id' => $faker->numberBetween(1, 3),
        'doctor_id' => $faker->randomElement($doctorIds),
        'patient_id' => $faker->randomElement($patientIds),
        'scheduled_date' => $scheduled_date,
        'scheduled_time' => $scheduled_time,
        'type' => $faker->randomElement($types),
        'status' => $faker->randomElement($statuses)
    ];
});

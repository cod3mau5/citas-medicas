<?php

use Illuminate\Database\Seeder;

use App\Specialty;
use App\User;

class SpecialtiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $specialties = [
            "Anestesiología", "Cardiología", "Dermatología", "Endocrinología", "Gastroenterología", "Geriatría", "Ginecología y Obstetricia", "Hematología", "Infectología", "Neumología", "Neurología", "Oncología", "Oftalmología", "Otorrinolaringología", "Pediatría", "Psiquiatría", "Reumatología", "Urología","Ortopedia"
        ];
        foreach ($specialties as $specialtyName) {
            $specialty = Specialty::create([
                'name' => $specialtyName
            ]);

            $specialty->users()->saveMany(
                factory(User::class, 3)->states('doctor')->make()
            );
        }

        // Médico Test
        User::find(2)->specialties()->save($specialty);
    }
}

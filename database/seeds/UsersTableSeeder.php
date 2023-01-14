<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    //Run the database seeds.

    public function run()
    {
        // 1
        User::create([
            'name' => 'Tomas Maurcio Arana',
            'email' => 'code.bit.mau@gmail.com',
            'email_verified_at' => null,
            'password' => Hash::make('Wifislaxutf-8'), // password
            'remember_token' => null,
            'cedula'=>Str::random(8),
            'address'=> 'Lomas Altas',
            'phone'=>'6241640107',
            'role'=> 'admin',
        ]);

        // 2
        User::create([
            'name' => 'Juan',
            'email' => 'juan@gmail.com',
            'email_verified_at' => null,
            'password' => Hash::make('doctor'),
            'remember_token' => null,
            'cedula'=>Str::random(8),
            'address'=> 'Lomas Altas',
            'phone'=>'6242640804',
            'role'=> 'doctor',
        ]);

        // 3
        User::create([
            'name' => 'Pepe',
            'email' => 'pepe@gmail.com',
            'email_verified_at' => null,
            'password' => Hash::make('patient'),
            'remember_token' => null,
            'cedula'=>Str::random(8),
            'address'=> 'Lomas Altas',
            'phone'=>'6241556455',
            'role'=> 'patient',
        ]);
        factory(User::class, 50)->states('patient')->create();
    }
}

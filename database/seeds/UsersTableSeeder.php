<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    //Run the database seeds.

    public function run()
    {
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
        factory(User::class, 50)->create();
    }
}

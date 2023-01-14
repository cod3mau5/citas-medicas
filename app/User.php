<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'dni', 'address', 'phone', 'role'
    ];

    protected $hidden = [
        'password', 'remember_token', 'pivot',
        'email_verified_at', 'created_at', 'updated_at'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
    ];

    public static function createPatient(array $data)
    {
        return self::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'patient'
        ]);
    }

    // $user->specialties
    public function specialties()
    {
        return $this->belongsToMany(Specialty::class)->withTimestamps();
    }



    protected function scopePatients($query){
        return $query->where('role','patient');
    }
    protected function scopeDoctors($query){
        return $query->where('role','doctor');
    }

}

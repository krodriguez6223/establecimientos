<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class UsuarioSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Agrega usuarios verificados
        DB::table('users')->insert([
            'name' => 'Kelvin',
            'email'=> 'correo1@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password'=>Hash::make('12345678'),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);

        DB::table('users')->insert([
            'name' => 'Jose',
            'email'=> 'correo2@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password'=>Hash::make('12345678'),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);

    }
}
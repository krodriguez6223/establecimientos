<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategoriasSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categorias')->insert([
            'nombre' => 'Restaurant',
            'slug'=> Str::slug('Restaurant'),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('categorias')->insert([
            'nombre' => 'Café',
            'slug'=> Str::slug('Café'),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('categorias')->insert([
            'nombre' => 'Hotel',
            'slug'=> Str::slug('Hotel'),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('categorias')->insert([
            'nombre' => 'Bar',
            'slug'=> Str::slug('Bar'),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('categorias')->insert([
            'nombre' => 'Farmacias',
            'slug'=> Str::slug('Farmacias'),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('categorias')->insert([
            'nombre' => 'Gym',
            'slug'=> Str::slug('Gym'),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('categorias')->insert([
            'nombre' => 'Canchas deportivas',
            'slug'=> Str::slug('Canchas deportivas'),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
    }
}
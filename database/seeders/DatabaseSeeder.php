<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
			$this->call(UnidadeTipoSeeder::class);
            $this->call(DiretoriaSeeder::class);
			$this->call(UnidadeSeeder::class);
			$this->call(UserSeeder::class);       
    }
}

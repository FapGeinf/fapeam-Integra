<?php

namespace Database\Seeders;

use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Str;

class AdministradorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
           User::factory()->create([
                'name' => 'ROOT',
                'email' => 'root@mail.com',
                'cpf' => '00000000000',
                'unidadeIdFK' => '1',
                'usuario_tipo_fk' => 4,
                'password' => Hash::make('fapeam2030hg'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
           ]);
    }
}

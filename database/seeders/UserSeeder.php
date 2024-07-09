<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'Usuario da Comissão',
            'email' => 'comissao@email.com',
            'email_verified_at' => now(),
            'cpf' => '00000000001',
            'unidadeIdFK' => '1',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'remember_token' => Str::random(10),
        ]);
        User::factory()->create([
            'name' => 'Usuario da GEINF',
            'email' => 'geinf@email.com',
            'email_verified_at' => now(),
            'cpf' => '00000000002',
            'unidadeIdFK' => '2',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'remember_token' => Str::random(10),
        ]);
        User::factory()->create([
            'name' => 'Marlúcia Seixas de Almeida',
            'email' => 'malu5577@gmail.com',
            'email_verified_at' => now(),
            'cpf' => '15017770259',
            'unidadeIdFK' => '1',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'remember_token' => Str::random(10),

        ]);
        User::factory()->create([
            'name' => 'Maria Fulgência Costa Lima Bandeira',
            'email' => 'fulgencia@ufam.edu.br',
            'email_verified_at' => now(),
            'cpf' => '23824425220',
            'unidadeIdFK' => '1',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'remember_token' => Str::random(10),

        ]);
        User::factory()->create([
            'name' => 'Simone Eneida Baçal de Oliveira',
            'email' => 'sisioliveira@uol.com.br',
            'email_verified_at' => now(),
            'cpf' => '16037570230',
            'unidadeIdFK' => '1',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'remember_token' => Str::random(10),

        ]);
        User::factory()->create([
            'name' => 'Raica Dameane Bentes',
            'email' => 'raicadameane@hotmail.com',
            'email_verified_at' => now(),
            'cpf' => '86129880200',
            'unidadeIdFK' => '1',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'remember_token' => Str::random(10),

        ]);
    }
}

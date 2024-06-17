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
    }
}

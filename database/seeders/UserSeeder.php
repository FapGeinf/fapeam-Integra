<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User

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
					'name' => 'ROOT USER',
					'email' => 'root_user@email.com',
					'email_verified_at' => now(),
					'unidadeIdFk' => '1',
					'password' => '',
					'remember_token' => Str::random(10),
				]);
    }
}

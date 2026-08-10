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
    $this->call([
      UnidadeTipoSeeder::class,
      DiretoriaSeeder::class,
      UnidadeSeeder::class,
      NovasUnidadesSeeder::class,
      UserSeeder::class,
      PublicoSeeder::class,
      CanalSeeder::class,
      EixoSeeder::class,
      UsuarioTipoSeeder::class,
      MedidaTipoSeeder::class,
      InsercaoNovoUsuarioTipo::class,
      AdministradorSeeder::class,
      AtividadeSeeder::class,
      StatusAtividadeSeeder::class
    ]);
  }
}

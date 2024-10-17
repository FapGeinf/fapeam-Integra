<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Unidade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        try {
            $unidades = Unidade::all();
        } catch (\Exception $e) {
            $unidades = null;
        }
        view()->share('unidades',$unidades);
    }
}

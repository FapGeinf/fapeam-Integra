<?php

namespace App\Providers;

use Exception;
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
        		view()->share('unidades',$unidades);
				} catch (Exception) {
						$unidades = NULL;
						view()->share('unidades', $unidades);
				}

    }
}

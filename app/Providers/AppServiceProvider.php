<?php

namespace App\Providers;

use Dompdf\Dompdf;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Dompdf::class, function () {
            $options = new Options();
            $options->setIsRemoteEnabled(true);

            $dompdf = new Dompdf();
            $dompdf->setOptions($options);

            return $dompdf;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

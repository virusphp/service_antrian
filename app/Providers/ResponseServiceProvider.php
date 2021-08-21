<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Http\ResponseFactory;

class ResponseServiceProvider extends ServiceProvider
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

    public function boot(ResponseFactory $factory)
    {
        $factory->macro('jsonApi', function($code = 200, $message = '', $data = null) use ($factory) {
            $format = [
                'metadata' => [
                    'code' => $code,
                    'message' => $message
                ],
                'response' => $data
            ];

            return $factory->make($format);
        });
        
        
        $factory->macro('jsonSimrs', function($code = 200, $message = '', $data = null) use ($factory) {
            $format = [
                'metaData' => [
                    'kode' => $code,
                    'pesan' => $message
                ],
                'response' => $data
            ];

            return $factory->make($format);
        });


        $factory->macro('jsonApiBpjs', function($code = 200, $message = '', $data = null) use ($factory) {
            $format = [
                'metadata' => [
                    'code' => $code,
                    'message' => $message
                ],
                'response' => $data
            ];

            return $factory->make($format);
        });

        $factory->macro('jsonApiBPD', function($code = 200, $message = '', $data = null) use ($factory) {
            $format = [
                'code' => $code,
                'message' => $message,
                'result' => $data
            ];

            return $factory->make($format);
        });

    }
}

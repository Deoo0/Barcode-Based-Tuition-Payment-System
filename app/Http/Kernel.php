<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's route middleware groups.
     * We register only the named middleware needed for this app here.
     */
    protected $routeMiddleware = [
        'is.admin' => \App\Http\Middleware\IsAdmin::class,
    ];
}

<?php

namespace Modules\Job\Http\Middleware;

use Nwidart\Modules\Laravel\Module;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Modules\Xot\Http\Middleware\XotBaseFilamentMiddleware;

class FilamentMiddleware extends XotBaseFilamentMiddleware
{
    public static string $module = 'Job';
    public static string $context = 'filament';

   
}

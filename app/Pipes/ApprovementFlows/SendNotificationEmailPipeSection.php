<?php

namespace App\Pipes\ApprovementFlows;

use Closure;

class SendNotificationEmailPipeSection
{
    public function handle($request, Closure $next)
    {
        dd($next);
        return $next(['new request']);
    }
}

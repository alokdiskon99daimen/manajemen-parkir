<?php

namespace App\Helpers;

use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

class LogActivityHelper
{
    public static function log(
        string $activity,
        array $before = null,
        array $after = null
    )
    {
        if (request()?->route()?->getController() instanceof \App\Http\Controllers\LogAktivitasController) {
            return;
        }

        $userId    = Auth::check() ? Auth::id() : null;
        $userName  = Auth::check() ? Auth::user()->name : 'SYSTEM';
        $ipAddress = request()?->ip();
        $method    = request()?->route()?->getActionMethod();
        $userAgent = substr(request()?->userAgent() ?? '-', 0, 500);
        $beforeString = $before ? substr(json_encode($before), 0, 1000) : null;
        $afterString  = $after ? substr(json_encode($after), 0, 1000) : null;

        LogAktivitas::create([
            'id_user'    => $userId,
            'method'     => $method,
            'activity'   => $activity,
            'ip'         => $ipAddress,
            'user_agent' => $userAgent,
            'before'     => $beforeString,
            'after'      => $afterString,
            'created_by' => $userName,
        ]);
    }
}

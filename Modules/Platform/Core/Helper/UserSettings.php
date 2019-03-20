<?php

namespace Modules\Platform\Core\Helper;

use Illuminate\Support\Facades\Auth;
use Krucas\Settings\Context;

class UserSettings
{

    public static function get($key, $default = null, $userId = null)
    {

        if(empty($userId)){
            $userId = Auth::id();
        }

        if ($userId != null && $userId > 0) {
            $settingsContext = new Context(['user_id' => $userId]);
        }

        if (!empty($settingsContext)) {
            return \Settings::context($settingsContext)->get($key);
        }

        return \Settings::get($key, $default);

    }

    public static function set($key, $value = null, $userId = null)
    {

        if(empty($userId)){
            $userId = Auth::id();
        }

        if ($userId != null && $userId > 0) {
            $settingsContext = new Context(['user_id' => $userId]);
        }

        if (!empty($settingsContext)) {
            \Settings::context($settingsContext)->set($key, $value);
        }

        return \Settings::set($key, $value);
    }

}
<?php

namespace App\Mixins;

use App\Models\Settings;


/**
 * APP Mixins Bootstrap
 */
class AppMixins
{

    /**
     * Custom class for app bootstrapp
     * Bootstrapp application
     * Get all the basic configuration
     */
    public function application()
    {
        return function(){
            $settings = Settings::get();
            $appConfig = array();
            foreach ($settings as $setting) {
                $appConfig[$setting->name] = $setting->value;
            }
            return $appConfig;
        };
    }

}

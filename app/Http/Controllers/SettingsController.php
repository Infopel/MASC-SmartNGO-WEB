<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use App\Models\Settings;
use Illuminate\Http\Request;
use Symfony\Component\Yaml\Yaml;

class SettingsController extends Controller
{

    /**
     * Display settings views
     */
    public function index()
    {

        $settings = Settings::get();

        $_settings = [];
        foreach ($settings as $setting) {
            try {
                $_array = Yaml::parse($setting->value);
                $_settings[$setting->name] = array();
                foreach ($_array as $key => $module) {
                    $_settings[$setting->name][$module] = $module;
                }
            } catch (\Throwable $th) {
                $_settings[$setting->name] = $setting->value;
                // $_settings[$setting->name][1] = 'is not a valid YAML';
            }
        }

        $data = array(
            'settings' => $_settings
        );

        // return $data;
        return view('settings.index', compact('data'));
    }

    /**
     * Project Settings
     */
    public function project($project_identifier)
    {
        $data = array(

        );

        // return $project_identifier;
        return view('settings.project', ['data' => $data]);
    }
}

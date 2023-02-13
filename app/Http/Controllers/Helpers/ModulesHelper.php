<?php

namespace App\Http\Controllers\Helpers;

use App\Models\EnabledModules;

trait ModulesHelper
{
    /**
     * Default Aplication avalible modules for projects
     */
    protected function aplication_modules()
    {
        return array(
            'budget',
            'issue_tracking',
            'time_tracking',
            'news',
            'documents',
            'wiki',
            // 'repository',
            'boards',
            'calendar',
            'gantt'
        );
    }


    /**
     * Default modules for new Projects
     */
    public function default_modules()
    {
        return array(
            'issue_tracking',
            'time_tracking',
            'documents',
            'calendar',
            'gantt',
            'news',
            'budget',
        );
    }

    /**
     * Retorna os modulos disponível e seu estado em cada projecto selecionado
     */
    public function project_modules($project_enabled_modules)
    {
        $response = [];
        foreach ($this->aplication_modules() as $module) {
            if (in_array($module, array_column($project_enabled_modules, 'name'))) {
                $response[] = array(
                    'name' => $module,
                    'is_enabled' => true,
                    'module' => __('lang.label_module_' . $module)
                );
            } else {
                $response[] = array(
                    'name' => $module,
                    'is_enabled' => false,
                    'module' => __('lang.label_module_' . $module)
                );
            }
        }
        return $response;
    }


    /**
     * Add Default Modules when add new Project / PDE
     */
    public function add_default_modules($project_id)
    {
        foreach ($this->default_modules() as $module) {
            // add default modulos
            $defaultModules = new EnabledModules();
            $defaultModules->project_id = $project_id;
            $defaultModules->name = $module;
            $defaultModules->save(); // Save data into database
        }
    }
}

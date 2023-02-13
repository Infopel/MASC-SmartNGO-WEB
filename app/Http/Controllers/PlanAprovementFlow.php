<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlanAprovementFlow extends Controller
{
    //

    public function index()
    {
    }


    public function plan_aprovement()
    {
        $viewComponentName = "aprovement-plan-flow";
        $componentTitle  = "Percentual de Uso de Sistema";

        return view('aprovement_plan.aprovement_flow', compact('viewComponentName', 'componentTitle'));
    }

}

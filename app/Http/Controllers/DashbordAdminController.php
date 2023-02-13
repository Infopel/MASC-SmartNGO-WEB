<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashbordAdminController extends Controller
{
    //

    public function index()
    {
    }


    public function uso_sistema()
    {
        $viewComponentName = "uso-sistema";
        $componentTitle  = "Percentual de Uso de Sistema";

        return view('admin.dashbord.usoSistema', compact('viewComponentName', 'componentTitle'));
    }

    public function assiduidade()
    {
        $viewComponentName = "assiduidade";
        $componentTitle  = "Assiduidade no Sistema";

        return view('admin.dashbord.assiduidade', compact('viewComponentName', 'componentTitle'));
    }

    public function actividades_reportar()
    {
        $viewComponentName = "reportar";
        $componentTitle  = "Actividades por Reportar";

        return view('admin.dashbord.actividadesReportar', compact('viewComponentName', 'componentTitle'));
    }

    public function dados_em_falta()
    {
        $viewComponentName = "falta";
        $componentTitle  = "Projectos com Dados em Falta";

        return view('admin.dashbord.dadosEmFalta', compact('viewComponentName', 'componentTitle'));
    }
}

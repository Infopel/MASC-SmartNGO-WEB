<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BugsCenterController extends Controller
{
    //

    public function index()
    {
    }


    public function bug_solicitacaoFundos()
    {
        $viewComponentName = "bug-solicitacao-fundos";
        $componentTitle  = "Bug - Modulo Solicitação de Fundos";

        return view('admin.bugs.solicFundos', compact('viewComponentName', 'componentTitle'));
    }
}

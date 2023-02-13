<?php

namespace App\Http\Controllers;

use App\Models\Issues;
use App\Models\Projects;
use App\Models\OrcamentoProjecto;
use App\Models\RubricasOrcamento;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportRubricasOrcamento;
use App\Http\Controllers\Helpers\Orcamento\SolicitacaoDeFundosHelper;

class OrcamentoProjectoController extends Controller
{
    use SolicitacaoDeFundosHelper;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function solicitacao_show(Projects $project_identifier, Issues $issue)
    {
        $project = $project_identifier;
        // return $issue->fluxo_aprovacao_fundos;
        return view('projects.orcamento.solicitacao.show', compact('issue', 'project'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Projects $project_identifier)
    {
        $project = $project_identifier;
        return view('projects.orcamento.index', compact('project'));
    }

    /**
     * Import Rubricas de orcamento de Projecto
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function import_rubricas_orcamento(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xls,xlsx,xlc,csv|max:204800000'
        ], [
            'file' => __('lang.errors.messages.required')
        ], [
            'file' => "ficheiro"
        ]);

        try {
            $import_data = new ImportRubricasOrcamento;
            $import_data->onlySheets('import');
            Excel::import($import_data, request()->file('file'));

            // dd($import_data->getResponse());

            if ($import_data->response['response_with_errors']) {
                return back()->with('import_response', $import_data->response);
            } else {
                return back()->with('success', "Arquivo do Excel 'Dados' importado com sucesso");
            }
        } catch (\Throwable $th) {
            // dd($th);
            // return back()->with('error', $th->getMessage());
            return back()->with('error', 'O nome da planilha solicitada [import] não foi encontrado<br/><h/>ErrorDetails: '. $th->getMessage());
        }
    }
}

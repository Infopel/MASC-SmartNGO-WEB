<?php

namespace App\Imports;

use App\Models\Projects;
use App\Models\RubricasOrcamento;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithConditionalSheets;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class ImportRubricasOrcamento implements ToCollection, WithHeadingRow, WithCalculatedFormulas, WithMultipleSheets
{
    use WithConditionalSheets;

    public function conditionalSheets(): array
    {
        return [
            'import' => $this
        ];
    }

    public $response;

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        // dd($collection);
        $errors = [];
        $response_with_errors = false;
        $success_response = 0;
        foreach($collection as $row){

            $checker = !$row->has('name') && !$row->has('rubrica');

            if ($checker) {
                dd('Erro Fatal: Não encontrou colunas certas para validar a dados a importar! Please check your file');
            }

            $novo_orcamento = new RubricasOrcamento();
            try {
                $project = Projects::where('identifier', $row['project_id'])->firstOrFail();
                try {
                    if (!RubricasOrcamento::where('rubrica', $row['rubrica'])
                        ->where('name', $row['name'])
                        ->where('project_id', $project['id'])
                        ->where('year', $row['ano'])
                        ->first()) {

                        $rubrica_parent = RubricasOrcamento::where('rubrica', $row['rubrica_parent'])
                            ->where('project_id', $project['id'])
                            ->first();

                        $novo_orcamento->rubrica = $row['rubrica'] ?? null;
                        $novo_orcamento->name = $row['name'] ?? null;
                        $novo_orcamento->project_id = $project['id'] ?? null;
                        $novo_orcamento->orcamento = $row['orcamento'] ?? 0;
                        $novo_orcamento->year = $row['ano'] ?? date('year');
                        $novo_orcamento->parent_rubrica_id = $rubrica_parent['id'] ?? null;
                        $novo_orcamento->parent_rubrica = $rubrica_parent['rubrica'] ?? null;
                        $novo_orcamento->author_id = auth()->user()->id;
                        $novo_orcamento->created_on = now();
                        $novo_orcamento->updated_on = now();

                        $novo_orcamento->save(); // Save data into database

                        $success_response += 1;
                    }

                } catch (\Throwable $th) {
                    $response_with_errors = true;
                    $errors[] = array(
                        'error' => $th->getMessage(),
                        'rubrica' => $row['name'] ?? "Coluna 'name' nao foi encontrada. verifique as colunas do ficheiro",
                        'project_id' => $row['project_id'],
                        'project_is_found' => true,
                    );
                }
            } catch (\Throwable $th) {
                $response_with_errors = true;
                $errors[] = array(
                    'error' => $th->getMessage(),
                    'rubrica' => $row['name'],
                    'project_id' => $row['project_id'],
                    'project_is_found' => false,
                );
            }
        }
        $this->response = array(
            'response_with_success' => $success_response,
            'response_with_errors' => $response_with_errors,
            'response_errors_count' => sizeof($errors),
            'errors' => $errors
        );
    }

    public function getResponse()
    {
        return $this->response;
    }
}

@extends('layouts.main', ['title' => __('Orçamento do Projecto')])
@section('content')

    @include('errors.any')

    @if (session('import_response'))
        <div class="p-2">
            @if (session('import_response')['response_with_success'] == 0 && session('import_response')['response_errors_count'] == 0 )
                <div class="ml-0 p-2 alert alert-danger">
                    <i class="icon-warning2"></i>
                    Essas rubricas ja foram cadastradas para esse projecto.
                </div>
            @endif

            @if (session('import_response')['response_with_errors'] && session('import_response')['response_errors_count'] > 0 )
                <div class="ml-0 p-2 alert alert-success">
                    <i class="icon-checkmark"></i>
                    ({{ session('import_response')['response_with_success'] }}) Rubrica Cadastradas com sucesso.
                </div>
                <div class="ml-0 p-2 alert alert-warning">
                    <i class="icon-warning2"></i>
                    Algumas rubricas nao foram cadastradas.
                    <h5 class="fw-600">
                        Rubricas Com erros: ({{ session('import_response')['response_errors_count'] }})
                    </h5>
                </div>

                <div class="table-responsive">
                    <table class="table table-sm table-hover table-striped table-bordered" style="font-size: 90%">
                        <thead class="table-active">
                            <th class="fw-600">Rubrica</th>
                            <th class="fw-600">Project ID</th>
                            <th class="fw-600">Erro</th>
                            <th class="fw-600">Project Status</th>
                        </thead>
                        <tbody>
                            @foreach (session('import_response')['errors'] as $item)
                                <tr>
                                    <td class="p-0 pl-2 pr-2">
                                        {{ $item['rubrica'] }}
                                    </td>
                                    <td class="p-0 pl-2 pr-2 text-nowrap">
                                        {{ $item['project_id'] }}
                                    </td>
                                    <td class="p-0 pl-2 pr-2 text-danger text-nowrap">
                                        {{ $item['error'] }}
                                    </td>
                                    <td class="p-0 pl-2 pr-2 text-nowrap">
                                        @if ($item['project_is_found'])
                                            Project not found.
                                        @else
                                            Project not found.
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    @endif

    @livewire('rubricas-orcamento', $project)
@endsection

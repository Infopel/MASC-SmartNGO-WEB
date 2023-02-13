@extends('layouts.main', ['title' => __('lang.label_program_plural')])
@section('content')
<div class="row m-0">
    <div class="col-md-12 p-0 mb-4">
        <div class="row m-0">
            <div class="col-md-12 pt-2 mt-2 bg-white">
                <div class="d-flex mb-2">
                    <div class="flex-grow-1">
                        <h4>{{ __('lang.label_program_plural') }}</h4>
                        {{-- <div class="col-md-8 p-0">
                            <span class="text-black-50">
                                Breve descrição da funcionalidade da linha estratégica e sua relavancia.
                            </span>
                        </div> --}}
                    </div>

                    @can('gerir_linhas_estrategicas', App\Models\User::class)
                        <div class="d-md-flex">
                            <div class="mr-2">
                                <form action="?" accept-charset="UTF-8" method="get"><input name="utf8" type="hidden" value="✓">
                                    <label for="closed">
                                    @if ($_GET['closed'] ?? false)
                                        <input type="checkbox" checked id="closed" onchange="this.form.submit();">
                                    @else
                                        <input type="checkbox" name="closed" id="closed" value="1" onchange="this.form.submit();">
                                    @endif
                                    Visualizar linhas estratégicas fechadas
                                    </label>
                                </form>
                            </div>
                        </div>
                    @endcan

                </div>

                <div class="col-md-12">
                    <div class="w-100">
                        @if (session('isRemoveTrue'))
                            <div class="alert alert-warning">
                                {{ session('isRemoveTrue')['msg'] }}
                                <div>
                                    <h6>{{ __('lang.button_delete').' '.__('lang.label_program') }}: <b>{{ session('isRemoveTrue')['program_name'] }}</b><h6>
                                    <form method="POST" action='{{ route('programs.remove', ['program'=> session('isRemoveTrue')['program_identifier'] ]) }}'>
                                        @csrf
                                        <div class="text-left">
                                            <button type="submit" class="btn btn-danger">SIM TENHO</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                {{-- sessions alerts --}}
                @include('errors.any')
                {{-- sessions alerts --}}

                <div class="row">
                    <div class="col-md-12">
                        <hr class="m-2">
                        <div class="pt-2">
                            <div class="table-responsive">
                                <table class="table border table-sm table-stripeed table-hover" style="font-size: 95%">
                                    <thead class="table-active">
                                        <th>
                                            <i class="icon-books"></i>{{ __('lang.label_program_plural') }}
                                        </th>
                                        <th class="text-center">#Projectos Associados</th>
                                        <th class="text-center">Criado a</th>
                                        @can('gerir_linhas_estrategicas', App\Models\User::class)
                                        <th></th>
                                        @endcan
                                    </thead>
                                    <tbody>
                                        @foreach ($programs as $program)

                                        <tr class="p-2 pl-2 pr-2">
                                            <td >
                                                <a href="{{ route('programs.show', ['program' => $program->identifier])}}">{{ $program->name}}</a>
                                            </td>
                                            <td class="text-center">{{ $program->childs->count()}}</td>
                                            <td class="text-center">{{ \Carbon\Carbon::parse($program->created_on)->diffForHumans() }}</td>

                                            <td class="text-right text-nowrap">
                                                @can('editar_linhas_estrategicas', [\App\Models\Projects::class, $program])
                                                    <a href="{{ route('programs.edit', ['program' => $program->identifier]) }}" class="ml-2 text-success-700 fw-400 mr-2">
                                                        <i class="icon-pencil5"></i>
                                                        <span>{{ __('lang.button_edit') }}</span>
                                                    </a>
                                                    |
                                                @endcan
                                                @can('excluir_linhas_estrategicas', [\App\Models\Projects::class, $program])
                                                    <a href="{{ route('programs.delete-request', ['program' => $program->identifier]) }}" class="ml-2 text-danger-400 fw-400">
                                                        <i class="icon-trash"></i>
                                                        <span>{{ __('lang.button_delete') }}</span>
                                                    </a>
                                                @endcan
                                            </td>
                                        </tr>
                                        @endforeach
                                        @if ($programs->count() < 1)
                                            <tr>
                                                <td colspan=4>
                                                    <div class="alert-warning rounded p-1 text-center border text-black-50">
                                                        {{ __('lang.label_no_data') }}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="pt-2">
                                {{ $programs->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

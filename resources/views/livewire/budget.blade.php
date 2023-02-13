<div>
    <div class="row m-0 p-2">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-9 p-0">
                    <div class="bg-white p-3">
                        @if ($budget_to['is_aproved'])
                            <div class="mt-1 mb-2">
                                <div class="ml-0 p-2 alert alert-warning small">
                                    <i class="icon-warning2"></i>
                                    {{ 'Não pode editar orçamento desta tarefa. Fluxo de solicitação ou tarefa aprovada!' }}
                                </div>
                            </div>
                        @endif
                        <div class="d-flex mb-2">
                            <div class="flex-grow-1">
                                <h5 class="m-0">
                                    <i class="icon-coins"></i>
                                    <span>{{ __('lang.label_finance') }}</span>
                                </h5>
                                <small>
                                    <i class="icon-history text-black-50"></i>
                                    <span class="text-black-50">Ultima Actualização:</span> <span>{{ \Carbon\Carbon::parse($budget_to['created_on'])->diffForHumans() }}</span>
                                </small>
                            </div>

                            <div class="text-lowercase mb-2">
                                @if (!$budget_to['is_aproved'])
                                    <a href="{{ $url_new_budget['url_new_budget'] }}" class="text-success btn btn-light btn-sm border shadow-sm">
                                        <i class="icon-plus2"></i>
                                        <span>{{ __('Novo Orçamento') }}</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <h5 class="text-wrap">
                                    <a href="#">{{ $budget_to['name'] }}</a>
                                </h5>
                            </div>
                            {{-- <div class="order-md-2 mb-2">
                                <select name="" id="" class="my_input p-1">
                                    <option value="mzn">MZ Metical</option>
                                    <option value="mzn">US Dollar</option>
                                </select>
                            </div> --}}
                        </div>

                        <hr class="m-0">
                        <div class="p-3" style="background:#ffffdd; font-size: 94%;">
                            <div class="table-responsive bg-white">
                                <table class=" finances table table-hover border">
                                    <thead class='table-active'>
                                        <th class="p-1 fw-600"> - Despesa</th>
                                        <th class="text-center p-1 fw-600">Provincia</th>
                                        {{-- <th class="text-right p-1">Quantidade</th> --}}
                                        <th class="text-center p-1 fw-600">Valor</th>
                                        {{-- <th class="text-right p-1">Sub Total</th> --}}
                                        <th class="text-center p-1" style="width:80px !important"></th>
                                    </thead>

                                    <tbody>
                                        @foreach ($issues_budgets as $budgets)
                                            <tr>
                                                <th class="fw-600 text-nowrap" colspan='3'>
                                                    <a href="#" onclick="return false;">
                                                        {{ $budgets['created_on'] }} - {{ \Carbon\Carbon::parse($budgets['updated_on'])->diffForHumans() }}
                                                    </a>
                                                    {{-- <a href="#" onclick="return false;" wire:click="getBudget({{ $budgets['id'] }})" wire:ignore.self>
                                                        {{ $budgets['created_on'] }} - {{ \Carbon\Carbon::parse($budgets['updated_on'])->diffForHumans() }}
                                                    </a> --}}
                                                    <span class="ml-4">
                                                        <span class="fw-400">Parceiro:</span>  {{ $budgets['partner'] ? $budgets['partner']['name'] : null}}
                                                    </span>
                                                </th>
                                                <th class="text-right text-nowrap">
                                                    @if (!$budget_to['is_aproved'] ?? false)
                                                        @can('edit_orcamento', [ App\Models\Issues::class, $budget_to['project_id'], App\Models\Issues::where('id', $budget_to['id'])->first()])
                                                            <a href="{{ route('issues.budget.edit', ['issue' => $budget_to['id'], 'budget' => $budgets['id']]) }}" class="text-primary">
                                                                <i class="icon-pencil5"></i>
                                                                Edit Despesas
                                                            </a>
                                                        @endcan
                                                    @endif
                                                </th>
                                            </tr>
                                            @foreach ($budgets->budget_values as $b_key => $item)
                                                <tr class="td-int-1 child" wire:transition.slide.down>
                                                    <td class="text-right">
                                                        {{ $item->rubrica['rubrica'] }}. {{ $item->rubrica['name'] }}
                                                    </td>
                                                    <td class="text-right text-nowrap">{{ $item->valor_variavel }}</td>
                                                    <td class="text-right fw-600 text-nowrap">
                                                        @if (in_array($item->id, $enable_edit_on))
                                                            <span class="form-inline text-center">
                                                                <input type="text" size="10" class="border form-control form-control-sm mr-2" value="{{ $item->issued_value }}" wire:model="issued_value">
                                                                <button class="btn btn-sm btn-primary border-top-success-800 shadow-sm" wire:click="edit_budget_value({{ $item->id }}, {{ true }})">Atualizar</button>
                                                                <button class="btn btn-sm btn-light border ml-2 shadow-sm" wire:click="cancel_action()">Cancelar</button>
                                                            </span>
                                                        @elseif (in_array($item->id, $enable_delete_on))
                                                            <span class="text-danger">
                                                                {{ __('lang.text_are_you_sure') }}
                                                            </span>
                                                            <button class="btn btn-sm btn-danger ml-1 border-top-success-800 shadow-sm" wire:click="remove_budget_value({{ $item->id }}, {{ true }})">Delete</button>

                                                            <button class="btn btn-sm btn-light border ml-1 shadow-sm" wire:click="cancel_action()">Cancelar</button>
                                                        @else
                                                            {{ number_format(($item->issued_value),2) }}<span> MZN</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-right text-nowrap" style="width:80px !important">
                                                        @if (!$budget_to['is_aproved'] ?? false)
                                                            @can('edit_orcamento', [ App\Models\Issues::class, $budget_to['project_id'], App\Models\Issues::where('id', $budget_to['id'])->first()])
                                                                <a href="#" onclick="return false;" wire:click="edit_budget_value({{ $item->id }})" title="Editar Valor">
                                                                    <i class="icon-pencil5"></i>
                                                                </a>
                                                                <a href="#" onclick="return false;" wire:click="remove_budget_value({{ $item->id }})" class="text-danger" title="Remover">
                                                                    <i class="icon-trash"></i>
                                                                </a>
                                                            @endcan
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                        <tr class="text-nowrap">
                                            <th colspan="2" class="fw-600">Resultado do Orçamento</th>
                                            <td class="_profit text-right _profit_top" colspan="1">
                                                @if ($budgets['budget_values'] ?? false)
                                                   {{ number_format(($budgets->budget_values->sum(function($var){
                                                    return $var['issued_value'];
                                                }) ?? 0),2) }} <span>MZN</span>
                                                @endif
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="mt-2 p-2">
                            <h5>Notas</h5>
                            @forelse ($issues_budgets as $item)
                                <span>{!! $item->notes !!}</span>
                                @break
                            @empty
                                <small>{{ "Nenhuma nota adicionada." }}</small>
                            @endforelse
                        </div>
                        <div class="p-2">
                            <div class="border-top mb-4 pt-2">
                                <div class="mt-2">
                                    <h6 class="m-0 fw-600 text-muted alert-warning border p-2">Documentos de suporte do Orçamento Solicitado</h6>
                                    <div class="table-responsive nowrap">
                                        <table class="table table-sm table-hover border" style="font-size: 92%">
                                            <thead class="table-active border">
                                                <th>{{ __('lang.label_attachment') }}</th>
                                                <th>{{ __('lang.field_filesize') }}</th>
                                                <th>{{ __('lang.field_downloads') }}</th>
                                                <th>{{ __('lang.label_added_by') }}</th>
                                                <th>{{ __('lang.field_created_on') }}</th>
                                            </thead>

                                            <tbody>
                                                @forelse ($issue->budget_suport_attachments as $attachment)
                                                    <tr>
                                                        <td>
                                                            <a href="{{ route('attachments.getDocument', ['attachment' => $attachment->id, 'filename' => $attachment->filename]) }}">{{ $attachment->filename }}</a>
                                                        </td>
                                                        <td>{{ $attachment->filesize }} kb</td>
                                                        <td>{{ $attachment->downloads }}</td>
                                                        <td>{{ $attachment->user->full_name }}</td>
                                                        <td>{{ $attachment->created_on }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center bg-light">
                                                            {{ 'Nenhum arquivo adicionado' }}
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    @if ($selected_budget)
                    {{-- {{ dd($selected_budget->author->full_name) }} --}}
                        <hr class="m-3">
                        <div class="bg-white p-3" id="details-budget" style="min-height:300px">
                            @if (!$selected_budget['is_aproved'])
                                <div class="ml-0 pt-1 pb-1 pl-3 pr-3 alert alert-danger">
                                    <i class="icon-warning2"></i>
                                    Orçamento com aprovação pendente
                                </div>
                            @else
                                <div class="ml-0 pt-1 pb-1 pl-3 pr-3 alert alert-success">
                                    <i class="icon-checkmark"></i>
                                    Orçamento Aprovado
                                </div>
                            @endif
                            <div class="mt-2">
                                {{-- <h5 class="m-0">{{ $selected_budget->budget_tracker->name }}</h5> --}}
                                <span style="font-size: 90%" class="text-black-50">Requerido a:
                                    <b>{{ \Carbon\Carbon::parse($selected_budget->created_on)->diffForHumans() }}</b>
                                </span>

                                @if ($selected_budget['is_aproved'])
                                    <br>
                                    <span style="font-size: 90%" class="text-black-50">Aprovado:
                                        <b>{{ \Carbon\Carbon::parse($selected_budget->aproved_on)->diffForHumans() }}</b>
                                    </span>
                                @endif
                            </div>

                            <div class="mt-2 table-responsive border-top pt-3">
                                <table class="table table-borderless table-inbox text-nowrap table-sm" style="font-size: 90%">
                                    <tbody>
                                        <tr>
                                            <td colspan="3" class="p-0 pl-2 pr-2"></td>
                                            <td class="p-0 pl-2 pr-2"><b>Orçamento N:</b></td>
                                            <td class="p-0 pl-2 pr-2">#{{ $selected_budget->id }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="p-0 pl-2 pr-2"></td>
                                            <td class="p-0 pl-2 pr-2 align-top"><b>Data:</b></td>
                                            <td class="p-0 pl-2 pr-2 text-wrap">{{ $selected_budget->created_on }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="p-0 pl-2 pr-2 align-bottom">
                                                {{-- Gestor do Projecto: <b>Edilson Mucanze</b> --}}
                                            </td>
                                            <td class="p-0 pl-2 pr-2 align-top"><b>Orçamento de:</b></td>
                                            <td class="p-0 pl-2 pr-2 text-wrap align-top"><u>{{ $budget_to['name'] }}</u></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="p-0 pl-2 pr-2 align-top">
                                                {{-- Gestor Finaceiro: <b>Edilson Mucanze</b> --}}
                                            </td>
                                            <td class="p-0 pl-2 pr-2 align-top"><b>Requerido por:</b></td>
                                            <td class="p-0 pl-2 pr-2 text-wrap align-top">{{ $selected_budget->author->full_name }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="table-responsive mt-3 p-1">
                                <table class="table border table-sm table-hover table-inbox table-bordered" style="font-size: 90%">
                                    <thead class="table-active">
                                        <th colspan="3">
                                            <b>Tipo de Despesa</b>
                                        </th>
                                        <th class="text-center"><b>Quantidate <b></th>
                                        <th class="text-center"><b>Valor base</b></th>
                                        <th class="text-center"><b>Valor</b></th>
                                        <th class="text-center"><b>Aprovar</b></th>
                                    </thead>
                                    <tbody>
                                        @foreach ($selected_budget->budget_values as $item)
                                        <tr>
                                            <td colspan="3" class="p-1 pl-2 pr-2">
                                                {{ $item->rubrica['rubrica'] }}.{{ $item->rubrica['name'] }}
                                            </td>
                                            <td class="p-1 pl-2 pr-2 text-center align-top">
                                                {{ $item->quantidade }}
                                            </td>
                                            <td class="p-1 pl-2 pr-2 text-center align-top text-nowrap">
                                                {{ number_format(($item->valor_base),2) }} MZN
                                            </td>
                                            <td class="p-1 pl-2 pr-2 text-center align-top text-nowrap">
                                                {{ number_format(($item->issued_value ),2) }} MZN
                                            </td>
                                            <td class="p-1 pl-2 pr-2 align-top">
                                                <input type="checkbox" wire:model="despesas.aprovar.{{ $item->id }}" name="orcamento[aprovar]" value="{{ $item->id}}" {{ $item->is_aproved ? 'checked="checked"' : null }}>

                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="mt-3">
                                    <span>Notas</span>
                                    <br>
                                    <div class="p-3 mt-2 bg-light border-top border-bottom">

                                        @foreach ($selected_budget->budget_details()->orderBy('created_on', 'asc')->get() as $budget_details)
                                            <p>
                                                {{ $budget_details->note }}
                                            </p>
                                        @endforeach
                                    </div>
                                </div>

                                @if ($selected_budget->is_aproved)
                                    <table class="mt-2 border-0 table table-sm table-borderless table-inbox" style="font-size: 90%">
                                        <tbody>
                                            <tr>
                                                <td colspan="3" class="text-left p-0 pl-2 pr-2">
                                                    Data de Aprovacao: <b>{{ $selected_budget->aproved_on }}</b>
                                                </td>
                                                <td colspan="1"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="text-left p-0 pl-2 pr-2">
                                                    Aprovado por:<b>{{ $selected_budget->aprovado_por->full_name ?? null }}</b>
                                                </td>
                                                <td colspan="1"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                @endif
                            </div>

                            <div class="bg-light rounded border p-2 mt-3">
                                @if (!$selected_budget['is_aproved'])
                                    <div class="w-100">
                                        <label for="">Nota</label>
                                        <textarea wire:model="note" class="w-100"name="orcamento[note]" id="" rows="6"></textarea>
                                    </div>
                                 @endif
                                <div class="text-right">
                                    <a href="#" onclick="return false;" wire:click="close_details_budget()" class="pl-3 pr-3 rounded btn btn-light btn-sm">
                                        <span>Fechar</span>
                                    </a>
                                    @if (!$selected_budget['is_aproved'])
                                        <a href="#" onclick="return false;" wire:click="aprovar_budget()" class="pl-3 pr-3 rounded btn btn-secondary btn-sm border my-shadow">
                                            <span>Aprovar Orçamento</span>
                                        </a>
                                        <a href="#" onclick="return false;" class="pl-3 pr-3 rounded btn btn-danger btn-sm border my-shadow">
                                            <span>Reprovar Orçamento</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
                <div class="col-md-3 p-3 aside-panel">
                    <h5>Modulo de Orçamento</h5>
                    <div class="mt-2">
                        <span class="" style="font-size: 90%">
                            Orçamento pendente ou a espera de uma aprovação relacionado a esta <b>tarefa / projecto</b> sera apresentado aqui. Selecione ver mais detalhes da requisição de aprovação.
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div wire:loading id="loading-indicator">
        <i class="icon-spinner spinner"></i>
        <span>Carregando...</span>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener("livewire:load", function(event) {
        window.livewire.hook('beforeDomUpdate', () => {
        });
        window.livewire.hook('afterDomUpdate', () => {
            let interval = setInterval(() => {
            }, 100);
            clearInterval(interval);
            var element = document.getElementById("details-budget");
            // console.log(element)
            if(element !== null){
                element.scrollIntoView({block: "center", behavior: "smooth"});
            }
        });
    });
</script>
@endsection

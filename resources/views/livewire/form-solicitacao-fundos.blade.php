<div class="form-solicitacao-fundos">
    <div class="main-content">
        <main class="row m-0 flex-grow-1 pt-4">

            <div class="steps-content p-2 flex-grow-1" x-data="app()" x-cloak>

            @if (!$isEdit)
                <form action="{{ route('orcamento.projecto.form_solicitacao_fundos', ['project_identifier' => $project['identifier']]) }}"
                    method="POST" enctype="multipart/form-data">
            @else
                <form action="{{ route('orcamento.projecto.form_edit_solicitacao_fundos', [
                        'project_identifier' => $project['identifier'],
                        'requestNum' => $requestNum
                    ]) }}"
                method="POST" enctype="multipart/form-data">
            @endif
                    @csrf

                    <div class="d-none setp-container step-info-content d-flex justify-content-center w-100">
                        <div class="col-md-9 p-0 mb-2 mt-2">

                            {{-- session rows --}}
                            @include('errors.any')
                            {{-- /session rows --}}
                            <div class="">
                                <div class="small text-uppercase fw-700 text-muted">
                                    4 Passos
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <div x-show.transition.in="step === 1">
                                        <div class="fw-700 text-slate-800">Formulário de Solicitação de Fundos</div>
                                    </div>
                                </div>
                                <div class="d-none col-md-4 p-0">
                                   <div class="progress">
                                        <div class="progress-bar" role="progressbar" x-bind:style="'width: '+ parseInt(step / 4 * 100) +'%'" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" x-text="parseInt(step / 4 * 100) +'%'"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div sx-show.transition.in="step === 1">
                        <div class="mb-3 setp-container step-info-content d-flex justify-content-center w-100">
                            <div class="col-md-9 p-0">
                                <div class="border col-12 p-3 bg-white my-shadow">
                                    <div class="p-1 border-bottom mb-3">
                                        <h5>Informações Base</h5>
                                    </div>

                                    <div class="form-group mb-2">
                                        <label for="exampleInputEmail1" class="mb-0">Tipo de Solicitacao de Fundos</label>
                                        <small class="form-text text-muted mt-0 mb-1">Selecione o Tipo de Solicitacao de Fundos que Pretende Efectuar.</small>
                                        <div class="form-inline">
                                            <select class="form-control w-75" name="requestFundos[TypeSolicitacao]" wire:model="selected_typeSolicitacao_id" required>
                                                <option value="null">Selecione o Tipo de Solicitacao</option>
                                                @foreach ($search_TypeSolicitacoRequest_result as $TypeSolicitacao)
                                                    <option value="{{ $TypeSolicitacao->tagCode }}">{{ $TypeSolicitacao->title }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>


                                    <div class="form-group mb-2">
                                        <label>
                                            Requisição:
                                        </label>
                                        <input type="text" value="auto" wire:model="requestNum" disabled class="my_input">
                                    </div>


                                    <div class="form-group mb-2">
                                        <label class="mb-0">Requisitante</label>
                                        <small class="form-text text-muted mt-0 mb-1">Nome do requisitante é automaitcamente dectado pela secção e será apresentado no relatório final</small>
                                        <input type="text" class="form-control" name="requestFundos[author]" disabled value='{{ $requisitante }}'>
                                    </div>

                                    <div class="form-group mb-2">
                                        <label for="exampleInputEmail1" class="mb-0">Valor Estimado</label>
                                        <small class="form-text text-muted mt-0 mb-1">Indique o valor estimado para a sua solicitação de fundos</small>
                                        <input type="text" class="my_input" placeholder="0.00" name="requestFundos[valor]" wire:model="valor_estimado" input_type="float"> <span>MZN</span>
                                    </div>

                                    <div class="form-group mb-2">
                                        <label for="exampleInputEmail1" class="mb-0">Objectivo</label>
                                        <small class="form-text text-muted mt-0 mb-1">Descrição do objectivo da solicitação de fundos. Nota: A sua descrição podera ser usada para associar a tarefa no projecto ou com titulo da tarefa a realiazar.</small>
                                        <textarea name="requestFundos[objectivo]" id="" rows="5" class="my_input w-100" wire:model.lazy="objectivo">{{ $objectivo }}</textarea>
                                    </div>

                                    @if ($project->has_shared_budget)
                                        <div class="d-flex col-md-12 p-0 mb-2">
                                            <div class="input-group w-auto col-md-12 p-0">
                                                <div class="">
                                                    <label for="_project" class="mb-0">{{ __('lang.label_project') }}</label>
                                                    <small class="form-text text-muted mt-0 mb-1">Selecione um projecto para usar as rubricas no modelo de  orçamento compartilhado por projectos.</small>
                                                </div>

                                                <div class="input-group input-group-sm mr-sm-0">
                                                    <div class="input-group-prepend bg-white">
                                                        <div class="input-group-text bg-white rounded-0 border-right-0">
                                                            <i wire:loading.class="d-none" wire:target="search_project" class="icon-search4 mr-0" style="font-size: 96%"></i>
                                                            <i wire:loading wire:target="search_project" class="icon-spinner2 spinner mr-0" style="font-size: 96%"></i>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" value="" wire:model="selected_project_id" name="project_id" class="border w-100" autocomplete="off">
                                                    <input type="search" name="search[rubrica]" wire:model.debounce.500ms="search_project" class="form-control form-control-sm border-left-0 rounded-0" placeholder="Pesquisar e selecionar Projecto" autocomplete="off">
                                                </div>

                                                <em class="info">Você pode pesquisar e selecionar o projecto nessa caixa de texto</em>

                                                @if ($isSearch)
                                                    <div class="position-fixed" style="top:0; left:0; right:0; bottom:0" wire:click="reset_search"></div>
                                                    <div class="border w-100 p-2 pb-0 search-result col-md-12" style="max-width: inherit;">
                                                        <ul class="list-unstyled pb-0 mb-1 mt-0">
                                                            <span class="dropdown-header pl-2 mt-0 text-capitalize">
                                                                Resultados da pesquisa por: <span class="text-uppercase text-success">{{ $search_project }}</span>
                                                            </span>
                                                            @forelse ($projects as $key => $project)
                                                                <li class="dropdown-item cursor-pointer pl-2"
                                                                    wire:click="select_project('{{ $project['id'] }}', '{{ $project['identifier'] }}')">
                                                                    #{{ $project['id'] }} - {{ $project['name'] }}
                                                                </li>
                                                            @empty
                                                                <li class="cursor-pointer pl-2">Ups! Nenhum resultado encontrado...</li>
                                                            @endforelse
                                                        </ul>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif

                                    <div class="form-group mb-2">
                                        <label for="exampleInputEmail1" class="mb-0">Rubricas</label>
                                        <small class="form-text text-muted mt-0 mb-1">Selecione as Rubricas referentes ao orçamento a solicitar (Selecione no maximo 3)</small>
                                        <div class="form-inline">
                                            <select class="form-control w-75" wire:model="selected_rubrica_id" >
                                                <option value="null">Selecione a rubrica</option>
                                                @foreach ($rubricas as $rubrica)
                                                    <option value="{{ $rubrica->id }}">{{ $rubrica->rubrica}}. {{ $rubrica->name }}</option>
                                                @endforeach
                                            </select>


                                            <div class="form-group ml-sm-2 mr-sm-0 mb-0 ">
                                                <select name="search[ano]" wire:model="filterYear" class="form-control">
                                                    <option value="all-years">Todos Anos</option>
                                                    @foreach ($years as $item)
                                                        <option value="{{ $item['year'] }}">{{ $item['year'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button type="button" class="btn btn-primary ml-2" wire:click="addRubrica()">Adicionar</button>
                                        </div>



                                        <div class="border-top mt-2 p-2">
                                            <div class="fw-700">Rubricas selciondas</div>
                                            @forelse ($select_rubricas as $index => $item)
                                                <li class="list-unstyled">
                                                    <a class="ml-2 mr-2" wire:click="removeRubrica({{ $index }})" title="Remover Rubrica">
                                                        <i class="icon-trash-alt text-danger-600"></i>
                                                    <a>
                                                        {{ $item['name'] }}
                                                    <input type="hidden" name="requestFundos[rubricas][{{ $item['project_id'] }}]" value="{{ $item['id'] }}">
                                                    <input type="hidden" name="requestFundos[rubrica][]" value="{{ $item['id']  }}">
                                                </li>

                                            @empty
                                                <input type="hidden" name="requestFundos[rubricas]" value={{ null }}>
                                                <small class="text-muted">Nenhuma rubrica selecionada</small>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div sx-show.transition.in="step === 2">
                        <div class="mb-3 setp-container step-info-content d-flex justify-content-center w-100">
                            <div class="col-md-9 p-0">
                                <div class="border col-12 p-3 bg-white my-shadow">
                                    <div class="p-1 border-bottom mb-3">
                                        <h5 class="mb-1">Area, Actividade e Necessidades</h5>
                                        <small class="form-text text-muted mt-0 mb-1 w-75">
                                            Caso adicione uma nova area, necessidade e ou actividade, apenas será salva no momento da submissão e Verificação do formulário de solicitação de fundos.</small>
                                    </div>

                                    <div class="form-group mb-2">
                                        <label for="exampleInputEmail1" class="mb-0">Area</label>
                                        <small class="form-text text-muted mt-0 mb-1">Indique a area ou adicione uma nova em função da necessidade. So pode adicionar apenas uma area nova por requisição.</small>

                                        <div class="form-inline">
                                            <select class="form-control w-75 p-1" wire:model="selected_area">
                                                <option value="null">Selecione a area</option>
                                                @foreach ($areas as $area)
                                                    <option value="{{ $area->id }}"
                                                        wire:click="getChilds({{ $area->id }}, '{{ $area->type }}')">
                                                        {{ $area->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button type="button" class="btn btn-primary ml-2" wire:click="addOption('area')">Adicionar</button>
                                        </div>

                                        <div class="border-top mt-2 p-2">
                                            <div class="fw-700">Areas selciondas</div>
                                            @forelse ($selected_areas as $index => $item)
                                                <li class="list-unstyled">

                                                    @if (in_array($item['id'], $enable_delete_area_on))
                                                        <span class="text-muted ml-2">{{ __('lang.text_are_you_sure') }}</span>
                                                        <button class="btn btn-sm border btn-danger shadow-sm" type="button"
                                                            wire:click="removeOption('area', {{ $index }}, 1)">Deletar</button>

                                                        <button class="btn btn-sm btn-light border mr-1 shadow-sm" type="button"
                                                            wire:click="cancel_delete_option('area')">
                                                            Cancelar
                                                        </button>
                                                    @else
                                                        <a class="ml-2 mr-2" wire:click="removeOption('area', {{ $index }})" title="Remover Rubrica">
                                                            <i class="icon-trash-alt text-danger-600"></i>
                                                        <a>
                                                    @endif

                                                    {{ $item['name'] }}
                                                    <input type="hidden" name="requestFundos[areas][]" value="{{ $item['id'] }}">
                                                </li>
                                            @empty
                                                <input type="hidden" name="requestFundos[areas]" value={{ null }}>
                                                <small class="text-muted">Nenhuma Area selecionada</small>
                                            @endforelse
                                        </div>
                                    </div>

                                    <div class="form-group mb-2">
                                        <label for="exampleInputEmail1" class="mb-0">Actividade</label>
                                        <small class="form-text text-muted mt-0 mb-1">Indique ou adicione uma nova actividade. So pode adicionar apenas uma por requisição.</small>

                                        <div class="form-inline">
                                            <select class="form-control w-75 p-1" wire:model="selected_actividade">
                                                <option value="null">Selecione a actividade</option>
                                                @foreach ($actividades as $actividade)
                                                    <option value="{{ $actividade->id }}"
                                                        wire:click="getChilds({{ $actividade->id }}, '{{ $actividade->type }}')">
                                                        {{ $actividade->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <button type="button" class="btn btn-primary ml-2" wire:click="addOption('actividade')">Adicionar</button>
                                        </div>

                                        <div class="border-top mt-2 p-2">
                                            <div class="fw-700">Actividades selciondas</div>
                                            @forelse ($selected_actividades as $index => $item)
                                                <li class="list-unstyled">

                                                    @if (in_array($item['id'], $enable_delete_actividade_on))
                                                        <span class="text-muted ml-2">{{ __('lang.text_are_you_sure') }}</span>
                                                        <button class="btn btn-sm border btn-danger shadow-sm" type="button"
                                                            wire:click="removeOption('actividade', {{ $index }}, 1)">Deletar</button>

                                                        <button class="btn btn-sm btn-light border mr-1 shadow-sm" type="button"
                                                            wire:click="cancel_delete_option('actividade')">
                                                            Cancelar
                                                        </button>
                                                    @else
                                                        <a class="ml-2 mr-2" wire:click="removeOption('actividade', {{ $index }})" title="Remover Rubrica">
                                                            <i class="icon-trash-alt text-danger-600"></i>
                                                        <a>
                                                    @endif

                                                    {{ $item['name'] }}
                                                    <input type="hidden" name="requestFundos[actividades][]" value="{{ $item['id'] }}">
                                                </li>
                                            @empty
                                                <input type="hidden" name="requestFundos[actividades]" value={{ null }}>
                                                <small class="text-muted">Nenhuma Actividade selecionada</small>
                                            @endforelse
                                        </div>
                                    </div>

                                    <div class="form-group mb-2">
                                        <label for="exampleInputEmail1" class="mb-0">Necessidades</label>
                                        <small class="form-text text-muted mt-0 mb-1">Indique ou adicione uma nova necessidade. So pode adicionar apenas uma por requisição.</small>

                                        <div class="form-inline">
                                            <select class="form-control w-75 p-1" wire:model="selected_necessidade">
                                                <option value="null">Selecione a necessidade</option>
                                                @foreach ($necessidades as $necessidade)
                                                    <option value="{{ $necessidade->id }}"
                                                        wire:click="getChilds()">
                                                        {{ $necessidade->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <button type="button" class="btn btn-primary ml-2" wire:click="addOption('necessidade')">Adicionar</button>
                                        </div>


                                        <div class="border-top mt-2 p-2">
                                            <div class="fw-700">Necessidades selciondas</div>
                                            @forelse ($selected_necessidades as $index => $item)
                                                <li class="list-unstyled mb-1 cursor-default">
                                                    @if (in_array($item['id'], $enable_delete_necessidade_on))
                                                        <span class="text-muted ml-2">{{ __('lang.text_are_you_sure') }}</span>
                                                        <button class="btn btn-sm border btn-danger shadow-sm" type="button"
                                                            wire:click="removeOption('necessidade', {{ $index }}, 1)">Deletar</button>

                                                        <button class="btn btn-sm btn-light border mr-1 shadow-sm" type="button"
                                                            wire:click="cancel_delete_option('necessidade')">
                                                            Cancelar
                                                        </button>
                                                    @else
                                                        <a class="ml-2 mr-2" wire:click="removeOption('necessidade', {{ $index }})" title="Remover Rubrica">
                                                            <i class="icon-trash-alt text-danger-600"></i>
                                                        <a>
                                                    @endif
                                                    {{ $item['name'] }}
                                                    <input type="hidden" name="requestFundos[necessidades][]" value="{{ $item['id'] }}">
                                                </li>
                                            @empty
                                                <input type="hidden" name="requestFundos[necessidades]" value={{ null }}>
                                                <small class="text-muted">Nenhuma Actividade selecionada</small>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div sx-show.transition.in="step === 3">
                        <div class="mb-3 setp-container step-info-content d-flex justify-content-center w-100">
                            <div class="col-md-9 p-0">
                                <div class="border col-12 p-3 bg-white my-shadow">
                                    <div class="p-1 border-bottom mb-3">
                                        <h5>Pilar, Projecto & Actividade Associada </h5>
                                    </div>

                                    <div class="form-group mb-2">
                                        <label for="exampleInputEmail1" class="mb-0">Pilar</label>
                                        <small class="form-text text-muted mt-0 mb-1">Selecione o Pilar - os projectos seram carregados de seguida.</small>
                                        <select name="requestFundos[pilar]" class="form-control w-75" >
                                            <option value="{{ $project->parent->id }}">{{ $project->parent->name }}</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-2">
                                        <label for="exampleInputEmail1" class="mb-0">Projecto</label>
                                        <small class="form-text text-muted mt-0 mb-1">Selecione o projeto</small>
                                        <select name="requestFundos[project]" class="form-control w-75">
                                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-2">
                                        <label for="searchIssue" class="mb-0">Associar Activiade</label>
                                        <small class="form-text text-muted mt-0 mb-1">Pesquise e selecione a activiade que pretende associar o orçamento solicitado.</small>
                                        <div class="input-group w-auto">
                                            <input name="requestFundos[issueID]" type="hidden" class="my_input w-100 pl-2 pr-2" wire:model="selected_issue_id" autocomplete="off"/>
                                            <input
                                                type="search"
                                                placeholder="Pesquisar e selecionar Actividade"
                                                class="my_input pl-2 pr-2 w-75"
                                                wire:model="searchIssue"
                                                autocomplete="off"
                                            />
                                            @if ($isSearchIssue)
                                                <div class="position-fixed" style="top:0; left:0; right:0; bottom:0" wire:click="reset_search"></div>
                                                <div class="bg-white border shadow-sm w-75 search-result p-1" style="max-width: 100% !important" wire:transition.slide.down>
                                                    <ul class="list-unstyled m-0" style="max-height: 300px; overflow-y:auto; font-size: 94%">
                                                        @if ($search_IssueRequest_result->count() > 0)
                                                        @foreach ($search_IssueRequest_result as $issue)
                                                            <li class="dropdown-item cursor-pointer pl-3 rounded text-truncate" wire:click="selectIssue({{ $issue->id }}, '{{  $issue->subject }}')">
                                                                <span class="link-option">{{ $issue->id }}</span> - {{ $issue->subject }}
                                                            </li>
                                                        @endforeach
                                                        @else
                                                            <h6 class="dropdown-header pl-2 m-0">{{ __('lang.label_no_data') }}</h6>
                                                        @endif
                                                    </ul>
                                                    <div class="align-content-center bg-light border-top d-flex justify-content-end pb-1 pl-2 pr-2 pt-1">
                                                        <small class>({{ $search_IssueRequest_result->count() }}) - Resultados encontrados</small>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        @if ($selectedIssue['id'])
                                            <div class="pl-4 mt-2 mb-2 row row-cols-1 mr-3 w-75" wire:transition.slide.down>
                                                <span class="link-option">
                                                    <span class="text-grey-800 font-weight-normal">
                                                        Actividade:
                                                    </span>
                                                    <span>
                                                    {{ $selectedIssue['subject'] }}
                                                    </span>
                                                </span>
                                                <span>
                                                    <small>Descrição: {{ $selectedIssue['description'] }}</small>
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group mb-2">
                                        <label for="exampleInputEmail1" class="mb-0">Local</label>
                                        <small class="form-text text-muted mt-0 mb-1">Indique o Local onde o pretende realizar a terefa</small>
                                        <input type="text" class="form-control w-75" placeholder="ex: Maputo" name="requestFundos[local]" wire:model="local">
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="exampleInputEmail1" class="mb-0">Data</label>
                                        <small class="form-text text-muted mt-0 mb-1">Indique a data de realização do objectivo da solicitação dos fundos</small>
                                        <input type="date" class="my_input" name="requestFundos[data]" wire:model="data">
                                    </div>
                                    <div class="form-row mt-4">
                                        <div class="form-group m-2">
                                            <label for="exampleInputEmail1" class="mb-0">Numero de Participantes</label>
                                            <small class="form-text text-muted mt-0 mb-0"></small>
                                            <input type="number" class="my_input" value="1" min="0" name="requestFundos[num_participantes]" wire:model="num_participantes">
                                        </div>

                                        <div class="form-group m-2">
                                            <label for="exampleInputEmail1" class="mb-0">Dias</label>
                                            <small class="form-text text-muted mt-0 mb-0"></small>
                                            <input type="number" class="my_input" value="1" min="0" name="requestFundos[num_dais]" wire:model="num_dias">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div sx-show.transition.in="step === 4">
                        <div class="mb-3 setp-container step-info-content d-flex justify-content-center w-100">
                            <div class="col-md-9 p-0">
                                <div class="border col-12 p-3 bg-white my-shadow">
                                    <div class="p-1 border-bottom mb-3">
                                        <h5>Detalhes da Requição</h5>
                                    </div>

                                    <div class="form-group mb-2">
                                        <label for="exampleInputEmail1" class="mb-0">OSC's Convidadas</label>
                                        <small class="form-text text-muted mt-0 mb-1">Indique as OSC's convidadas separadas por virgula (,).</small>
                                        <textarea name="requestFundos[ocs]" id="" rows="5" class="my_input w-100" wire:model.lazy="ocs">{{ $ocs }}</textarea>
                                    </div>

                                    <div class="mt-3">
                                        <div class="small text-bold text-capitalize text-black-50">
                                            <i class="icon-file-empty2" style="font-size:95%"></i>
                                            Documentos De Suporte  <i>(Tamanho máximo: 15 MB)</i>
                                        </div>
                                        <p class="mt-2 mb-2 border-top pt-2">
                                            <label class="float-left mr-3">Termos de referência:</label>
                                            <span class="attachments_form">
                                                <span class="attachments_fields">
                                                </span>
                                                <span class="add_attachment" style="">
                                                    <input type="file" name="requestFundos[attachments][TermosReferencia][]" class="file_selector filedrop" multiple="multiple" onchange="addInputFiles(this);" data-max-file-size="204800000" data-max-file-size-message="Este ficheiro não pode ser carregado pois excede o tamanho máximo permitido por ficheiro (15 MB)" data-max-concurrent-uploads="2" data-upload-path="/uploads.js" data-param="attachments" data-description="true" data-description-placeholder="Descrição opcional">
                                                </span>
                                            </span>
                                        </p>
                                        <p class="mt-2 mb-2 border-top pt-2">
                                            <label class="float-left mr-3">Plano de treinamento:</label>
                                            <span class="attachments_form">
                                                <span class="attachments_fields">
                                                </span>
                                                <span class="add_attachment" style="">
                                                    <input type="file" name="requestFundos[attachments][PlanoTreinamento][]" class="file_selector filedrop" multiple="multiple" onchange="addInputFiles(this);" data-max-file-size="204800000" data-max-file-size-message="Este ficheiro não pode ser carregado pois excede o tamanho máximo permitido por ficheiro (15 MB)" data-max-concurrent-uploads="2" data-upload-path="/uploads.js" data-param="attachments" data-description="true" data-description-placeholder="Descrição opcional">
                                                </span>
                                            </span>
                                        </p>
                                        <p class="mt-2 mb-2 border-top pt-2">
                                            <label class="float-left mr-3">Contracto:</label>
                                            <span class="attachments_form">
                                                <span class="attachments_fields">
                                                </span>
                                                <span class="add_attachment" style="">
                                                    <input type="file" name="requestFundos[attachments][Contracto][]" class="file_selector filedrop" multiple="multiple" onchange="addInputFiles(this);" data-max-file-size="204800000" data-max-file-size-message="Este ficheiro não pode ser carregado pois excede o tamanho máximo permitido por ficheiro (15 MB)" data-max-concurrent-uploads="2" data-upload-path="/uploads.js" data-param="attachments" data-description="true" data-description-placeholder="Descrição opcional">
                                                </span>
                                            </span>
                                        </p>
                                        <p class="mt-2 mb-2 border-top pt-2">
                                            <label class="float-left mr-3">Email:</label>
                                            <span class="attachments_form">
                                                <span class="attachments_fields">
                                                </span>
                                                <span class="add_attachment" style="">
                                                    <input type="file" name="requestFundos[attachments][Email][]" class="file_selector filedrop" multiple="multiple" onchange="addInputFiles(this);" data-max-file-size="204800000" data-max-file-size-message="Este ficheiro não pode ser carregado pois excede o tamanho máximo permitido por ficheiro (15 MB)" data-max-concurrent-uploads="2" data-upload-path="/uploads.js" data-param="attachments" data-description="true" data-description-placeholder="Descrição opcional">
                                                </span>
                                            </span>
                                        </p>
                                        <p class="mt-2 mb-2 border-top pt-2">
                                            <label class="float-left mr-3">Orcamento específico:</label>
                                            <span class="attachments_form">
                                                <span class="attachments_fields">
                                                </span>
                                                <span class="add_attachment" style="">
                                                    <input type="file" name="requestFundos[attachments][Orcamento][]" class="file_selector filedrop" multiple="multiple" onchange="addInputFiles(this);" data-max-file-size="204800000" data-max-file-size-message="Este ficheiro não pode ser carregado pois excede o tamanho máximo permitido por ficheiro (15 MB)" data-max-concurrent-uploads="2" data-upload-path="/uploads.js" data-param="attachments" data-description="true" data-description-placeholder="Descrição opcional">
                                                </span>
                                            </span>
                                        </p>
                                        <p class="mt-2 mb-2 border-top pt-2">
                                            <label class="float-left mr-3">Procurement:</label>
                                            <span class="attachments_form">
                                                <span class="attachments_fields">
                                                </span>
                                                <span class="add_attachment" style="">
                                                    <input type="file" name="requestFundos[attachments][Procurement][]" class="file_selector filedrop" multiple="multiple" onchanPge="addInputFiles(this);" data-max-file-size="204800000" data-max-file-size-message="Este ficheiro não pode ser carregado pois excede o tamanho máximo permitido por ficheiro (15 MB)" data-max-concurrent-uploads="2" data-upload-path="/uploads.js" data-param="attachments" data-description="true" data-description-placeholder="Descrição opcional">
                                                </span>
                                            </span>
                                        </p>

                                        <p class="mt-2 mb-2 border-top pt-2">
                                            <label class="float-left mr-3">Outro:</label>
                                            <span class="attachments_form">
                                                <span class="attachments_fields">
                                                </span>
                                                <span class="add_attachment" style="">
                                                    <input type="file" name="requestFundos[attachments][Outro][]" class="file_selector filedrop" multiple="multiple" onchange="addInputFiles(this);" data-max-file-size="204800000" data-max-file-size-message="Este ficheiro não pode ser carregado pois excede o tamanho máximo permitido por ficheiro (15 MB)" data-max-concurrent-uploads="2" data-upload-path="/uploads.js" data-param="attachments" data-description="true" data-description-placeholder="Descrição opcional">
                                                </span>
                                            </span>
                                        </p>
                                    </div>
                                </div>

                                @if (!$isEdit && sizeof($usersToApprove) > 1)
                                    <div class="mt-4">
                                        <h6 class="fw-600">
                                            <span class="text-muted">Fase de aprovação:</span>
                                            <span>{{ $nivel_description }}</span>
                                        </h6>

                                        <fieldset class="box bg-light p-2 mt-2 text-capitalize border mb-2">
                                            <legend class="text-capitalize w-auto pt-0 pb-0 pl-1 pr-2 mb-0"><span class="text-muted">Categoria: </span> {{ $role_need }}</legend>
                                            <div class="roles-selection pl-2 pr-2">
                                                @foreach ($usersToApprove as $user)
                                                    <label class="floating">
                                                        <input type="radio" name="usersToApprove" value="{{ $user['id'] }}" wire:model="userTo" required>
                                                        {{ $user['firstname'] }} {{ $user['lastname'] }}
                                                    </label>
                                                @endforeach
                                            </div>
                                        </fieldset>

                                        <div class="alert alert-danger p-2" style="font-size: 92%">
                                            Encontramos 2 (ou mais) usuários que ocupam o mesmo papel <b>({{ $role_need }})</b> necessário para aprovação nesse projecto. Para prosseguir por favor selecione para que usuário deve se notificar a próxima aprovação.
                                        </div>

                                        <div class="mt-2 mb-2">
                                            @include('errors.any')
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>


                    <div class="setp-container step-info-content d-flex justify-content-center w-100">
                        <div class="col-md-9 p-0">
                            <div class="mt-3 mb-3">
                                {{-- <button
                                    type="button"
                                    class="btn btn-light border rounded-2 fw-600 text-black-50"
                                    x-show="step > 1"
                                    x-on:click="step--">
                                    Anterior
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-primary border rounded-2 my-shadow fw-600"
                                    x-show="step < 4"
                                    x-on:click="step++">
                                    Proximo Passo
                                </button> --}}
                                <button
                                    type="submit"
                                    class="btn btn-success border rounded-2 my-shadow fw-600">
                                    {{ $btnActionName }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </main>
        {{-- <div class="helper border-left shadow-sm">
            <aside title="Painel de Ajuda e Dicas">
                <span>
                    <button class="btn btn-sm">
                        <i class="icon-help" style="color: #545b64"></i>
                    </button>
                </span>
            </aside>
        </div>

       <div wire:loading id="loading-indicato" wire:target="showModal, store_rubrica, filterYear, selected_rubrica_id" wire:key="id">
            <i class="icon-spinner spinner"></i>
            <span>Carregando...</span>
        </div>--}}
    </div>

@section('scripts')
    <script>
        function app(){
           return{
                step: 1,
           }
        }
    </script>
@endsection
</div>

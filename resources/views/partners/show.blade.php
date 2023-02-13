@extends('layouts.main', ['title' => __('lang.label_partner_plural').' - '.$partner->name])
@section('content')
    <div class="row m-0 p-2">
        <div class="col-lg-9 col-md-8 admin-container">
            <div class="h-100">
                <div class="row h-100 rounded">
                    <div class="card-block p-3 rounded">
                        {{-- session rows --}}
                        <div class="w-100">
                            @if (session('status'))
                                <div class="ml-0 pt-1 pb-1 pl-3 pr-3 alert alert-success">
                                    <i class="icon-checkmark"></i>
                                    {{ session('status') }}
                                </div>
                            @elseif(session('erros'))
                                <div class="ml-0 p-2 alert alert-danger">
                                    <i class="icon-warning2"></i>
                                    {{ session('erros') }}
                                </div>
                            @endif
                        </div>
                        {{-- /session rows --}}
                        @include('errors.any')
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <h5>
                                    <a href="{{ route('partners.index') }}">{{ __('lang.label_partner_plural') }}
                                    </a> » {{ $partner->name }}
                                </h5>
                            </div>
                            <div class="">
                                <a href="">
                                    <i class="icon-history"></i>
                                    Histórico de alterações
                                </a>
                            </div>
                        </div>

                        <div class="">
                            <nav>
                                <div class="nav nav-tabs mb-2" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link link-option active" id="overview" data-toggle="tab" href="#tab-overview" role="tab" aria-controls="tab-overview" aria-selected="true">{{ __('lang.label_overview') }}</a>

                                    <a class="nav-item nav-link link-option" id="avaliacaoParceiro" data-toggle="tab" href="#tab-archivoParceiro" role="tab" aria-controls="tab-archivoParceiro" aria-selected="true">{{ __('Documentos do Parceiro') }}</a>

                                    <a class="nav-item nav-link link-option" id="avaliacaoParceiro" data-toggle="tab" href="#tab-avaliacaoParceiro" role="tab" aria-controls="tab-avaliacaoParceiro" aria-selected="true">{{ __('Avaliação do Parceiro') }}</a>

                                </div>
                            </nav>

                            <div class="tab-content table-responsive row" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="tab-overview" role="tabpanel" aria-labelledby="overview">
                                    <div class="">
                                        <form action="{{ route('partners.update', ['partner' => $partner->id]) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row m-0">
                                                @include('partners._form', ['custom_fields' => $custom_fields, 'is_desabled' => false])
                                                <div class="w-100 pl-3 pr-2 ">
                                                    <span class="text-black-50 small">
                                                    Nota: As alterações nos dados do parceiro serão todas registradas no histórico de alterações. Diferentemente do histórico de atividades, que apresentará as realizações do parceiro.
                                                </span>
                                                </div>
                                                <div class="w-100 pl-3 pr-2">
                                                    <button type="submit" class="p-2 mr-2" style="line-height: 0.5 !important;">
                                                        {{ __('lang.button_update') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="tab-avaliacaoParceiro" role="tabpanel" aria-labelledby="avaliacaoParceiro">
                                    <div class="pl-3">
                                        @livewire('partner-assessment-component', $partner)
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="tab-archivoParceiro" role="tabpanel" aria-labelledby="archivoParceiro">
                                    <div class="p-3 pt-1">
                                        <div class="d-flex">
                                            <p class="mb-1 flex-grow-1">
                                                <strong>{{ __('Documentos do Parceiro') }}</strong>
                                            </p>
                                        </div>
                                        <div class="table-responsive nowrap">
                                            <table class="table table-sm table-hover" style="font-size: 90%">
                                                <thead class="bg-light">
                                                    <th>{{ __('lang.field_filename') }}</th>
                                                    <th>{{ __('lang.field_filesize') }}</th>
                                                    <th>{{ __('lang.field_downloads') }}</th>
                                                    <th>{{ __('lang.label_added_by') }}</th>
                                                    <th>{{ __('lang.field_created_on') }}</th>
                                                </thead>

                                                <tbody>
                                                    @forelse ($partner->attachments as $key => $attachment)
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
                                                            <td colspan="5" class="text-center">{{ "Nunhum documento de suporte adicionado." }}</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4">
            @include('admin._menu')
        </div>
    </div>
@endsection

@extends('layouts.main', ['title' => __('lang.label_partner_plural').' - '.$partner->name])
@section('content')
    <div class="row m-0 p-2">
        <div class="col-lg-9 col-md-8 admin-container">
            <div class="h-100">
                <div class="row h-100 rounded">
                    <div class="card-block p-3 rounded">
                        <div class="d-flex border-bottom">
                            <div class="flex-grow-1">
                                <h5>
                                    <a href="{{ route('partners.index') }}">{{ __('lang.label_partner_plural') }}
                                    </a> » {{ $partner->name }} » Avaliação » {{ $partnerAssessment->assessment->description }}
                                </h5>
                            </div>
                            <div class="">
                                <a href="">
                                    <i class="icon-history"></i>
                                    Histórico de alterações
                                </a>
                            </div>
                        </div>

                        <div class="assessment">
                            @livewire('evaluation-survey-component', $partner, $partnerAssessment)
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

@extends('layouts.main')
@section('content')
    <div class="mb-4">
        <div class="col-md-12 mb-4">
            <div class="row py-4" style="min-height:80vh">
                <div class="col-md-12">
                    <div class="d-flex">
                        @include('layouts._menu_reports')

                        <div class="flex-grow-1">
                            <report-orcamento-project
                                :projects="{{ $projects }}">
                            </report-orcamento-project>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

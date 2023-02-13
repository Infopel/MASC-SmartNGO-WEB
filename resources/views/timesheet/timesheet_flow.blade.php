@extends('layouts.main')
@section('content')
    <div class="col-md-6">
        <div class="card-block w-100 border-left aside-panel p-3">
            <div class="">
                <div class="text-black-50 small m-0 mb-1 p-0 text-left" style="background: none">
                    <h5 class="text-semibold">
                        <i class="icon-history position-left" style="background: #e7eaec; z-index: 1;"></i>
                        FLUXO DE TIMESHEET
                    </h5>
                </div>
            </div>
        </div>
        <div class="row-md-12 d-flex mb-2">
            <div class="">

            </div>
            <div class="float-right ml-2">
                <a href="{{ route('timesheets.activity.index') }}" class="btn btn-primary form-control">
                    <i class="icon-plus-circle2 icon-sm " style="font-size:90%"></i>
                    <span>{{ __('Actividades A Timesheet') }}</span>
                </a>
            </div>
        

            <div class="float-right ml-2">
                <a href="{{ route('timesheets.new') }}" class="btn btn-success form-control">
                    <i class="icon-plus-circle2 icon-sm" style="font-size:90%"></i>
                    <span>{{ __('Adicionar Timesheet') }}</span>
                </a>
            </div>
            
 
        </div>


       

        @foreach ($members as $member)
       






            @if ($member->user_id == auth()->user()->id)
                @foreach ($members_roles as $member_role)
                    @if ($member_role->member_id == $member->id)
  





                        @foreach ($actividades as $actividade)

                            @foreach ($approvement_flow as $item)
                        



                                @if ($item->role_id == $member_role->role_id)
                                 
                                    @if ($item->trigger == 'initial_flow')
                                        <div class="md-form">
                                            <form action="{{ route('app.flow_approvement') }}" method="POST">
                                                @csrf
                                                {{-- <h6 class="text-black-50">{{ $item->description }}</h6> --}}
                                                <label for="form7">Comentário</label>
                                                <div class="md-form">
                                                    <i class="fas fa-pencil-alt prefix"></i>
                                                    <input type="hidden" value="new" name="timesheet[new]"
                                                        id="timesheet[new]">
                                                        <input type="hidden" value="{{ $item->id }}" name="timesheet[id]"
                                                        id="timesheet[id]">
                                                    <input type="hidden" value="{{ $item->approved_goto }}"
                                                        name="timesheet[approved_goto]" id="timesheet[approved_goto]">
                                                    <input type="hidden" value="{{ $item->role_id }}"
                                                        name="timesheet[role_id]" id="timesheet[role_id]">
                                                    <input type="hidden" value="{{ $actividades[0]->id }}"
                                                        name="timesheet[activite_id]" id="timesheet[activite_id]">
                                                    <input type="hidden" value="{{ $actividades[0]->tag_code_ts }}"
                                                        name="timesheet[tag_code]" id="timesheet[tag_code]">
                                                    <input type="hidden" value="{{ $actividades[0]->project_id }}"
                                                        name="timesheet[project_id]" id="timesheet[project_id]">
                                                    <input type="hidden" value="{{ $item->is_flow_end }}"
                                                        name="timesheet[is_end]" id="timesheet[is_end]">
                                                    <textarea name="timesheet[comments]" id="flow_comments" class="md-textarea form-control" rows="3"></textarea>
                                                </div>
                                                <button type="submit"
                                                    class="btn btn-s btn-success border-success fw-600 border pt-1 pb-1 shadow-sm"
                                                    value="submeter">Submeter</button>
                                            </form>
                                        </div>
                                    @elseif($item->trigger == 'output_flow')
                                        <div class="md-form">
                                            <form action="{{ route('app.flow_approvement') }}" method="POST">
                                                @csrf
                                                <h6 class="text-black-50">{{ $item->description }}</h6>
                                                <label for="form7">Comentário</label>
                                                <div class="md-form">
                                                    <i class="fas fa-pencil-alt prefix"></i>
                                                    <input type="hidden" value="end" name="timesheet[new]"
                                                        id="timesheet[new]">
                                                    <input type="hidden" value="{{ $item->id }}" name="timesheet[id]"
                                                        id="timesheet[id]">
                                                    <input type="hidden" value="{{ $item->approved_goto }}"
                                                        name="timesheet[approved_goto]" id="timesheet[approved_goto]">
                                                    <input type="hidden" value="{{ $item->role_id }}"
                                                        name="timesheet[role_id]" id="timesheet[role_id]">
                                                    <input type="hidden" value="{{ $actividades[0]->id }}"
                                                        name="timesheet[activite_id]" id="timesheet[activite_id]">
                                                    <input type="hidden" value="{{ $actividades[0]->tag_code_ts }}"
                                                        name="timesheet[tag_code]" id="timesheet[tag_code]">
                                                    <input type="hidden" value="{{ $actividades[0]->project_id }}"
                                                        name="timesheet[project_id]" id="timesheet[project_id]">
                                                    <input type="hidden" value="{{ $item->is_flow_end }}"
                                                        name="timesheet[is_end]" id="timesheet[is_end]">
                                                    <textarea name="timesheet[comments]" id="flow_comments" class="md-textarea form-control" rows="3"></textarea>
                                                </div>
                                                <button type="submit"
                                                    class="btn btn-s btn-success border-success fw-600 border pt-1 pb-1 shadow-sm"
                                                    value="submeter">Submeter</button>
                                            </form>
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        @endforeach
                    @endif
                @endforeach ($members_roles )
            @endif
        @endforeach

        {{-- {{ $actividades[0]->project_id }} --}}

    </div>
@endsection

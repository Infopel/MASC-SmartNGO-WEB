{{-- Tipo de tarefas --}}
<div class="row mb-3">
    <div class="col-md-12">
        <div class="">
            <div class="box tabular" id="permissions" style="font-size:90%">
                <fieldset class="border pl-3 pr-3 pt-2 bg-light rounded border tabular">
                    <legend class="pl-2 pr-2 p-0 m-0 w-auto text-capitalize">Campos Personalizados</legend>
                    <div class="col-md-8 pb-3 ">
                        {{-- Campos personalizados --}}
                        @include('layouts.custom_fields_inputs', ['custom_fields' => $custom_fields])
                        {{-- / Campos personalizados --}}
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
</div>
{{-- / Tipo de Tarefas --}}

<div class="row mb-3">
    <div class="col-md-12">
        <div class="box tabular" id="permissions" style="font-size:90%">
            <fieldset class="bg-light rounded border border pl-3 pr-3 pt-2">
                <legend class="text-capitalize m-0 w-auto p-0 pl-2 pr-2">Formulario</legend>

                <p class="col-md-4">
                    <label for="project_parent_id" class="float-left">
                        Projecto: <span class="text-danger">*</span>
                    </label>
                    <select name="tsactivity[project_id]" required class="select-searchs p-1"
                        oninvalid="this.setCustomValidity('Selecione um Projecto Valido')"
                        oninput="setCustomValidity('')" style="with:60%" {{-- $is_desabled ? $is_desabled ? 'disabled="true"' : '' : null --}}>
                        <option value="">Selecione o Projecto</option>
                        @foreach ($projects as $key => $item)
                            <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                        @endforeach
                    </select>
                </p>

                <p class="form-group col-md-4">
                    <label for="timesheet" class="float-left">
                        TimeSheet: <span class="text-danger">*</span>
                    </label>
                    <select name="tsactivity[timesheet]" required class="select-searchs p-1" style="with:60%"
                        oninvalid="this.setCustomValidity('Selecione uma Timesheet Valida')"
                        oninput="setCustomValidity('')" {{-- $is_desabled ? $is_desabled ? 'disabled="true"' : '' : null --}}>
                        <option value="">Selecione a Timesheet</option>
                        @foreach ($timesheets as $key => $timesheet)
                            <option value="{{ $timesheet['tag_code'] }}">{{ $timesheet['descrition'] }}</option>
                        @endforeach
                    </select>

                </p>

                <p class="col-md-7">
                    <label for="descrition" class="float-left">Descricao<span class="text-danger"> *</span></label>
                    <input size="60" type="text" v-model="tsactivity_title" value=""
                        name="tsactivity[descrition]" id="tsactivity_descrition" class="border" required
                        oninvalid="this.setCustomValidity('Preecnha a Descrição')" oninput="setCustomValidity('')" />
                </p>
                <p>
                    <label for="tsactivity_data" class="float-left">Data<span class="text-danger"> *</span></label>
                    <input size="60" type="date" v-bind:value="tsactivity ? tsactivity.data : null"
                        name="tsactivity[data]" id="tsactivity_data" class="border" required
                        oninvalid="this.setCustomValidity('Selecione uma Data Valida')"
                        oninput="setCustomValidity('')" />
                </p>
                <p class="col-md-7">
                    <label for="nr_horas" class="float-left">Nr de Horas<span class="text-danger"> *</span></label>
                    <input size="60" type="text" v-model="tsactivity_nr_horas" value=""
                        name="tsactivity[nr_horas]" id="tsactivity_nr_horas" class="border" required
                        oninvalid="this.setCustomValidity('Preencha o Número de Horas')"
                        oninput="setCustomValidity('')" />
                </p>
                <p class="col-md-10 mt-2">
                    <label for="project_name" class="float-left">Resultado<span class="text-danger"> *</span></label>

                    <textarea class="text_cf mt-2 border" rows="7" name="tsactivity[resultado]" placeholder="{{-- $field --}}"
                        value="" required id="tsactivity[resultado]" oninvalid="this.setCustomValidity('Preencha o Resultado')"
                        oninput="setCustomValidity('')" {{-- $is_desabled ? $is_desabled ? 'disabled="true"' : '' : null --}}>{{-- $custom_field[0] ? $custom_field[0]['value'] : null --}}
                    </textarea>
                </p>
                <p class="col-md-10 mt-2">
                    <label for="project_name" class="float-left">Execucao<span class="text-danger"> *</span></label>
                    <textarea class="text_cf mt-2 border" rows="7" name="tsactivity[execucao]" placeholder="{{-- $field --}}"
                        value="" required id="tsactivity[execucao]" oninvalid="this.setCustomValidity('Preencha a Execução')"
                        oninput="setCustomValidity('')" {{-- $is_desabled ? $is_desabled ? 'disabled="true"' : '' : null --}}>{{-- $custom_field[0] ? $custom_field[0]['value'] : null --}}
                    </textarea>
                </p>
                <p class="col-md-10 mt-2">
                    <label for="project_name" class="float-left">Constragimentos<span class="text-danger">
                            *</span></label>

                    <textarea class="text_cf mt-2 border" rows="7" name="tsactivity[constragimentos]"
                        placeholder="{{-- $field --}}" value="" required id="tsactivity[constragimentos]"
                        oninvalid="this.setCustomValidity('Preencha os Contragimentos')" oninput="setCustomValidity('')"
                        {{-- $is_desabled ? $is_desabled ? 'disabled="true"' : '' : null --}}>{{-- $custom_field[0] ? $custom_field[0]['value'] : null --}}
                    </textarea>
                </p>



            </fieldset>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-12">
        <div class="box tabular" id="permissions" style="font-size:90%">
            <fieldset class="border pl-3 pr-3 pt-2 bg-light rounded border">
                <legend class="pl-2 pr-2 p-0 m-0 w-auto text-capitalize">Formulario</legend>

                <p  class="col-md-7">
                    <label for="name" class="float-left"
                        >Descricao<span class="required"> *</span></label
                    >
                    <input
                        size="60"
                        type="text"
                        v-model="timesheet_title"
                        value=""
                        name="timesheet[descrition]"
                        id="timesheet_name"
                        class="border"
                    />
                </p>
                <p>
                    <label for="timesheet_start_date" class="float-left"
                        >{{ __("lang.field_start_date")
                        }}<span class="required"> *</span></label
                    >
                    <input
                        size="60"
                        type="date"
                        v-bind:value="timesheet ? timesheet.start_date : null"
                        name="timesheet[start_date]"
                        id="timesheet_start_date"
                        class="border"
                    />
                </p>
                <p>
                    <label for="timesheet_due_date" class="float-left"
                        >{{ __("lang.field_due_date")}}<span class="required"> *</span>
                    </label>
                    <input
                        size="60"
                        type="date"
                        v-bind:value="timesheet ? timesheet.due_date : null"
                        name="timesheet[due_date]"
                        id="timesheet_due_date"
                        class="border"
                    />
                </p>

                
            </fieldset>
        </div>
    </div>
</div>
<div class="col-md-12">
    <fieldset class="mb-2 tabular bg-light border p-2 pt-0">
        <legend class="pl-2 pr-1 p-0 m-0 w-auto text-capitalize">{{ __('lang.label_information_plural') }}</legend>

        <div class="col-md-10 form_grupos">

            <p class="">
                <label for="my_input" class="float-left">{{ __('lang.label_partner_name') }}<span class="text-danger"> *</span></label>
                <input size="25" class="my_input @error('partner.name') is-invalid @enderror" type="text" name="partner[name]" placeholder="{{ __('lang.label_partner_name') }}" value="{{ $partner ? $partner['name'] : '' }}">
                <br>
                @error('partner.name')
                    <span class="text-danger-600 fw-300" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </p>
            <p class="">
                <label for="my_input" class="float-left">{{ __('lang.field_type') }}<span class="text-danger"> *</span></label>
                <select name="partner[type]" class="border p-1">
                    <option value=""></option>
                    @foreach ($partners_type as $type)
                        <option value="{{ $type->id }}"
                            {{ $partner ? $partner->type == $type->id ? 'selected="selected"' : null : null}}>
                            {{ $type->name}}
                        </option>
                    @endforeach
                </select>
            </p>

            <p class="">
                <label for="my_input" class="float-left">{{ __("Natureza de OSC's") }}<span class="text-danger"> *</span></label>
                <select name="partner[natureza]" class="border p-1">
                   
                    <option value="{{ $partner ? $partner['natureza'] : '' }}">{{ $partner ? $partner['natureza'] : '' }}</option>
                    <option value="Plataforma" >Plataforma</option>
                    <option value="Forum">Forum</option>
                    <option value="Associacoes">Associacoes</option>
                    <option value="OSCs">OSCs</option>
                    <option value="Movimentos">Movimentos</option>
                    <option value="Comites">Comites</option>
                </select>
            </p>
        
            <p class="">
                <label for="my_input" class="float-left">{{ __('lang.label_partner_address') }}<span class="text-danger"> *</span></label>
                <input size="25" class="my_input @error('partner.address') is-invalid @enderror" type="text" name="partner[address]" placeholder="{{ __('lang.label_partner_address') }}" value="{{ $partner ? $partner['address'] : '' }}">
                <br>
                @error('partner.address')
                    <span class="text-danger-600 fw-300" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </p>
            <p class="">
                <label for="my_input" class="float-left">{{ __('lang.field_mail') }}<span class="text-danger"> *</span></label>
                <input size="35" class="border p-1 pl-2 @error('partner.email_address') is-invalid @enderror" type="text" name="partner[email_address]" placeholder="{{ __('lang.field_mail') }}" value="{{ $partner ? $partner['email_address'] : '' }}">
                <br>
                @error('partner.email_address')
                    <span class="text-danger-600 fw-300" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </p>
            <p class="">
                <label for="my_input" class="float-left">{{ __('lang.field_start_date') }}</label>
                <input size="35" class="border p-1 pl-2" type="date" name="partner[start_date]" placeholder="{{ __('lang.field_start_date') }}" value="{{ $partner ? $partner['start_date'] : '' }}">
            </p>
            <p class="">
                <label for="my_input" class="float-left">{{ __('Data de Fim do Contrato') }}</label>
                <input size="35" class="border p-1 pl-2" type="date" name="partner[end_date]" placeholder="{{ __('lang.field_start_date') }}" value="{{ $partner ? $partner['end_date'] : '' }}">
            </p>
            <p class="">
                <label for="my_input" class="float-left">{{ __("Tipo de fundo") }}<span class="text-danger"> *</span></label>
                <select name="partner[type_fund]" class="border p-1">
                   
                    <option value="{{ $partner ? $partner['type_fund'] : '' }}">{{ $partner ? $partner['type_fund'] : '' }}</option>
                    <option value="Pequeno" >Pequeno</option>
                    <option value="Medio">Medio</option>
                    <option value="Grande">Grande</option>
                </select>
            </p>
            {{-- Campos personalizados --}}
            <div class="form_grupos">
                @include('layouts.custom_fields_inputs', ['custom_fields' => $custom_fields])
            </div>
            {{-- / Campos personalizados --}}
        </div>
    </fieldset>
</div>

<div>
    <table>
        <tbody style="font-size: 93%">
            <tr>
                <td class="p-0 pr-1 pl-1">
                    <label for="available_list_columns" class="m-0">{{ __('lang.description_available_columns') }}</label>
                    <br>
                    <select name="available_columns[]" id="available_list_columns" wire:model="available_columns" multiple="multiple" class="p-0" size="10" style="width:160px">
                        @foreach ($available_list_columns as $key => $available_column)
                            <option value="{{ $available_column }}" class="m-0" style="border-radius:0px; padding:2px">{{ __('lang.field_'.$available_column) }}</option>
                        @endforeach
                    </select>
                </td>

                <td class="buttons p-0 pr-1 pl-1">
                    <input type="button" value="→" wire:click="moveOptions('add')"><br>
                    <input type="button" value="←" wire:click="moveOptions('remove')">
                </td>

                <td class="p-0 pr-1 pl-1">
                    <label for="default_selected_columns" class="m-0">{{ __('lang.description_selected_columns') }}</label>
                    <br>
                    <select name="settings[issue_list_default_columns][]" wire:model="issue_list_default_columns" id="default_selected_columns" class="p-0" multiple="multiple" size="10" style="width:150px" wire:click="moveOptions();">
                        @foreach ($default_selected_columns as $key => $column)
                            <option value="{{ $column }}" class="m-0" style="border-radius:0px; padding:2px">{{ __('lang.field_'.$column) }}</option>
                        @endforeach
                    </select>
                </td>
                <td class="buttons">
                    <input type="button" value="⇈" wire:click="moveElementTop()"><br>
                    <input type="button" value="↑" wire:click="moveElementUp()"><br>
                    <input type="button" value="↓" wire:click="moveElementDown()"><br>
                    <input type="button" value="⇊" wire:click="moveElementBottom()">
                </td>
            </tr>
        </tbody>
    </table>
</div>

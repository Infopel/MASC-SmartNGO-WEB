<div class="tab-pane fade" id="nav-activites" role="tabpanel" aria-labelledby="nav-activites-project">
    <div class="table-responsive">
        <table class="table table-sm border table-striped">
            <thead class="table-active">
                <th class="p-1 pr-2 pl-2">Nome</th>
                <th class="p-1 pr-2 pl-2 text-center">Situação padrão</th>
                <th class="p-1 pr-2 pl-2 text-center">Aciviade do Sistema</th>
                <th class="p-1 pr-2 pl-2 text-center">Activo</th>
            </thead>
            <tbody>
                @foreach ($time_entry_activity as $item)
                    <tr>
                        <td class="p-0 pr-2 pl-2">{{ $item->name }}</td>
                        <td class="p-0 pr-2 pl-2 text-center">
                            @if ($item->is_default)
                                <i class="icon-checkmark-circle text-success"></i>
                            @endif
                        </td>
                        <td class="p-0 pr-2 pl-2 text-center">
                            <i class="icon-checkmark-circle text-success"></i>
                        </td>
                        <td class="p-0 pr-2 pl-2 text-center">
                            <input type="checkbox" value="1" {{ $item->active ? 'checked="checked"' : null }} name="enumerations[9][active]" id="enumerations_9_active">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if (sizeof($time_entry_activity) < 0)
        <div class="alert-warning p-1 text-center border">
            {{ __('lang.label_no_data') }}
        </div>
    @endif

</div>

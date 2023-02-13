@foreach ($childs as $child)
    <tr>
        <td class="p-0 pl-2 pr-2 text-nowrap">
            {{ $child['rubrica'] }}
        </td>
        <td class="text-nowrap p-0 pl-2 pr-2">
            {{ $child['name'] }}
        </td>
        <td class="p-0 pl-2 pr-2 text-nowrap">
            {{ number_format(($child['orcamento']),2) }}
        </td>
        <td class="p-0 pl-2 pr-2 text-nowrap">
            0.00
        </td>
        <td class="p-0 pl-2 pr-2 text-nowrap">
            {{ $rubrica->valor_gasto_tarefas('1', '2020') }}
        </td>
        <td class="p-0 pl-2 pr-2 text-nowrap">
            {{ $rubrica->valor_gasto_tarefas('2', '2020') }}
        </td>
        <td class="p-0 pl-2 pr-2 text-nowrap">
            {{ $rubrica->valor_gasto_tarefas('3', '2020') }}
        </td>
        <td class="p-0 pl-2 pr-2 text-nowrap">
            {{ $rubrica->valor_gasto_tarefas('4', '2020') }}
        </td>
        <td class="p-0 pl-2 pr-2 text-nowrap">
            {{ $rubrica->valor_gasto_tarefas('5', '2020') }}
        </td>
        <td class="p-0 pl-2 pr-2 text-nowrap">
            {{ $rubrica->valor_gasto_tarefas('6', '2020') }}
        </td>
        <td class="p-0 pl-2 pr-2 text-nowrap">
            {{ $rubrica->valor_gasto_tarefas('7', '2020') }}
        </td>
        <td class="p-0 pl-2 pr-2 text-nowrap">
            {{ $rubrica->valor_gasto_tarefas('8', '2020') }}
        </td>
        <td class="p-0 pl-2 pr-2 text-nowrap">
            {{ $rubrica->valor_gasto_tarefas('9', '2020') }}
        </td>
        <td class="p-0 pl-2 pr-2 text-nowrap">
            {{ $rubrica->valor_gasto_tarefas('10', '2020') }}
        </td>
        <td class="p-0 pl-2 pr-2 text-nowrap">
            {{ $rubrica->valor_gasto_tarefas('11', '2020') }}
        </td>
        <td class="p-0 pl-2 pr-2 text-nowrap">
            {{ $rubrica->valor_gasto_tarefas('12', '2020') }}
        </td>
        <td class="p-0 pl-2 pr-2 text-nowrap">
            {{ number_format(($child['orcamento']),2) }}
        </td>
        <td class="text-center fw-600 p-0 pl-2 pr-2 text-nowrap">0%</td>
    </tr>

    @isset($child['child'])
        @include('projects.orcamento._child_rubricas_resumo', ['childs' => $child['child']])
    @endisset
@endforeach

@foreach ($childs as $child)
    <tr wire:transition.slide.down>
        <td class="p-0 pl-2 pr-2" style="width:80px">
            {{ $child['rubrica'] }}
        </td>
        <td class="p-0 pl-2 pr-2">
            <a href="#" onclick="return false" wire:click="select_rubrica({{ $child['id'] }})">
                {{ $child['name'] }}
            </a>
        </td>
        <td class="p-0 pl-2 pr-2 text-nowrap">
            {{ number_format(($child['orcamento']),2) }}
        </td>
        <td class="p-0 pl-2 pr-2 text-nowrap">
            {{ $child['created_on'] }}
        </td>
        <td class="p-0 pl-2 pr-2 text-nowrap">
            {{ $child['author']['firstname'] }}
        </td>
        <td class="p-0 pl-2 pr-2 text-center text-nowrap">
            <a href="#" onclick="return;" title="Editar" wire:click="editRubrica('{{ $child['id'] }}')">
                <i class="icon-pencil5"></i>
            </a>
            <a href="#" onclick="return;" class="text-danger ml-2" wire:click="removeRubrica('{{ $child['id'] }}', 0)" title="Remover">
                <i class="icon-trash"></i>
            </a>
        </td>
    </tr>
    @isset($child['child'])
        @include('livewire.child_rubricas', ['childs' => $child['child']])
    @endisset
@endforeach

<table style="border-collapse: collapse;">
    <thead>
        <tr>
            <td colspan="6" style="text-align: center; font-weight: bold;">
                <h3 style="color:#27343a; margin-top: -8px; padding:8px; margin-bottom:-5px; font-size: 18px">
                    {{ $application['app_client_short_name'] }}
                </h3>
            </td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: center; font-weight: bold;">
                <h3 style="color:#27343a; margin-top: -8px; padding:4px; margin-bottom:-5px; font-size: 18px">
                    {{ $application['app_client_name'] }}
                </h3>
            </td>
        </tr>
        <tr>
            <td colspan="6" style="padding: 8px"></td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: center; font-weight: bold;">
                <h4 style="color:#27343a; margin-top: -8px; margin-bottom:-5px;">
                    {{ $title }}
                </h4>
            </td>
        </tr>
        <tr>
            <td colspan="6" style="padding: 8px"></td>
        </tr>
        <tr>
            <td colspan="6" style="padding: 8px"></td>
        </tr>
        <tr>
            <td>
                Projecto:
            </td>
            <td colspan="5" style="font-weight: bold; overflow-wrap:break-word">
                {{ $project->name }}
            </td>
        </tr>
        <tr>
            <td>
                Duração:
            </td>
            <td colspan="3" style="font-weight: bold; overflow-wrap:break-word">
                {{ $start_date }} - {{ $end_date }}
            </td>
        </tr>
        <tr>
            <td colspan="6" style="padding: 8px"></td>
        </tr>
        <tr>
            <td>
                Relatorio Requisitado em:
            </td>
            <td colspan="3">
                {{ now() }}
            </td>
        </tr>
        <tr>
            <td>
                Relatorio Requisitado por:
            </td>
            <td colspan="3">
               {{ auth()->user()->full_name }}
            </td>
        </tr>
        <tr>
            <td style="padding: 8px"></td>
        </tr>
        <tr>
            <td style="padding: 8px"></td>
        </tr>
        <tr style="background-color: #f4f4f4">
            <th style="font-weight: bold; border:1px solid #383838;">
                Tarefa
            </th>
            <th style="font-weight: bold; border:1px solid #383838;">
                Província
            </th>
            <th style="font-weight: bold; border:1px solid #383838;">
                Orçamento
            </th>
            <th style="font-weight: bold; border:1px solid #383838;">
                Solicitado por
            </th>
            <th style="font-weight: bold; border:1px solid #383838;">
                Data de solicitação
            </th>
            <th style="font-weight: bold; border:1px solid #383838;">
                Data de aprovação
            </th>
        </tr>
    </thead>

    <tbody>
        @forelse ($data as $item)
            <tr>
                <td style="border:1px solid #383838;">
                    {{ $item->issue->subject }}
                </td>
                <td style="border:1px solid #383838;">
                    {{ $item->issue->provincia }}
                </td>
                <td style="border:1px solid #383838;">
                    {{ $item->issue->valor_solicitado }}
                </td>
                <td style="border:1px solid #383838;">
                    {{ $item->requestBy->full_name }}
                </td>
                <td style="border:1px solid #383838;">
                    {{ $item->issue->created_on }}
                </td>
                <td style="border:1px solid #383838;">
                    {{ $item->approved_on }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">
                    {{ __('lang.label_no_data') }}
                </td>
            </tr>
        @endforelse

        <tr>
            <td style="padding: 8px"></td>
        </tr>

        <tr>
            <td colspan="2" style="font-weight: bold; padding: 8px; text-align: center">
                Elaborado Por
            </td>
            <td colspan="2" style="font-weight: bold; padding: 8px; text-align: center">
                Verificado Por
            </td>
            <td colspan="2" style="font-weight: bold; padding: 8px; text-align: center">
                Validado
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding: 8px; text-align: center">
                _________________________
            </td>
            <td colspan="2" style="padding: 8px; text-align: center">
                _________________________
            </td>
            <td colspan="2" style="padding: 8px; text-align: center">
                _________________________
            </td>
        </tr>

        <tr>
            <td colspan="2" style="padding: 8px; text-align: center">
                Data: ____/____/_______
            </td>
            <td colspan="2" style="padding: 8px; text-align: center">
                Data: ____/____/_______
            </td>
            <td colspan="2" style="padding: 8px; text-align: center">
                Data: ____/____/_______
            </td>
        </tr>

        <tr>
            <td style="padding: 8px"></td>
        </tr>
        <tr>
            <td style="padding: 8px"></td>
        </tr>

        <tr>
            <td colspan="6">
                {{ date('Y') }} - Gerado por computador - CESC - GESPRO
            </td>
        </tr>
    </tbody>
</table>

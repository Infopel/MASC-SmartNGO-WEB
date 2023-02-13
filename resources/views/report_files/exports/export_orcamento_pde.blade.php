<table style="border-collapse: collapse;">
    <thead>
        <tr>
            <td colspan="4" style="text-align: center; font-weight: bold;">
                <h3 style="color:#27343a; margin-top: -8px; margin-bottom:-5px; font-size: 18px">
                    {{ $application['app_client_short_name'] }}
                </h3>
            </td>
        </tr>
        <tr>
            <td colspan="4" style="text-align: center; font-weight: bold;">
                <h3 style="color:#27343a; margin-top: -8px; margin-bottom:-5px; font-size: 18px">
                    {{ $application['app_client_name'] }}
                </h3>
            </td>
        </tr>
        <tr>
            <td colspan="4" style="padding: 8px"></td>
        </tr>
        <tr>
            <td colspan="4" style="text-align: center; font-weight: bold;">
                <h4 style="color:#27343a; margin-top: -8px; margin-bottom:-5px;">
                    {{ $title }}
                </h4>
            </td>
        </tr>
        <tr>
            <td colspan="4" style="padding: 8px"></td>
        </tr>
        <tr>
            <td>
                Dados por:
            </td>
            <td colspan="2">
                {{ $dataType }}
            </td>
        </tr>
        <tr>
            <td>
                Relatorio Requisitado em:
            </td>
            <td colspan="2">
                {{ now() }}
            </td>
        </tr>
        <tr>
            <td>
                Relatorio Requisitado por:
            </td>
            <td colspan="2">
               {{ auth()->user()->full_name }}
            </td>
        </tr>
        <tr>
            <td colspan="4" style="padding: 8px"></td>
        </tr>
        <tr>
            <td colspan="4" style="padding: 8px"></td>
        </tr>
        <tr>
            <th style="font-weight: bold; border:1px solid #383838;">
                Linha Estratégica
            </th>
            <th style="font-weight: bold; border:1px solid #383838;">
                Orçamento
            </th>
            <th style="font-weight: bold; border:1px solid #383838;">
                Orçamento de Projectos
            </th>
            <th style="font-weight: bold; border:1px solid #383838;">
                Valor Gasto de Projectos
            </th>
        </tr>
    </thead>

    <tbody>
        @foreach ($reportData as $item)
            <tr>
                <td style="border:1px solid #383838;">
                    {{ $item['Projeto'] }}
                </td>
                <td style="border:1px solid #383838;">
                    {{ $item['Orçamento LE'] }}
                </td>
                <td style="border:1px solid #383838;">
                    {{ $item['Orçamento de Projectos'] }}
                </td>
                <td style="border:1px solid #383838;">
                    {{ $item['Orçamento de Gasto de Projectos'] }}
                </td>
            </tr>
        @endforeach

        <tr>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td colspan="4">
                {{ date('Y') }} - Gerado por computador - CESC - GESPRO
            </td>
        </tr>
    </tbody>
</table>

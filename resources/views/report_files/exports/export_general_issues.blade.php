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

        <tr class='bg-slate-700'>
            <th class="text-nowrap" rowspan="2">Nº Ordem</th>
            <th rowspan="2">Resultado (Output)</th>
            <th class="text-nowrap" rowspan="2">Actividade (Grande Actividade)</th>
            <th rowspan="2">Indicador</th>
            <th class="text-nowrap" rowspan="2">Meta Anual</th>
            <th class="text-nowrap" colspan="4">Meta Trimestral</th>
            <th rowspan="2">Meta Realizada</th>
            <th rowspan="2">Grau de Realização (%)</th>
            <th rowspan="2">Local de realização</th>
            <th class="text-nowrap" colspan="3">Benificiário</th>
            <th rowspan="2">Orçamento (MT)</th>
            <th rowspan="2">Orçamento Executado (MT)</th>

            <th rowspan="2">Projecto Responsável</th>
        </tr>
        <tr>
            <th>I</th>
            <th>II</th>
            <th>III</th>
            <th>IV</th>
            <th>H</th>
            <th>M</th>
            <th>Total</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($reportData as $item)
            <tr>
                <td style="border:1px solid #383838;">
                    {{ $item['num_ordem'] }}
                </td>
                <td style="border:1px solid #383838;">
                    {{ $item['result']['subject'] }}
                </td>
                <td style="border:1px solid #383838;">
                    {{ $item['issue']['subject'] }}
                </td>
                <td style="border:1px solid #383838;">
                    @foreach ( $item['indicadores'] as $ind)
                        {{ $ind['indicator_field']['name'] }}
                    @endforeach
                </td>
                <td style="border:1px solid #383838;">
                    @foreach ( $item['indicadores'] as $ind)
                        {{ $ind['indicator_field']['indicator_issue_values']['meta'] }}
                    @endforeach
                </td>
                <td style="border:1px solid #383838;">
                    @foreach ( $item['indicadores'] as $ind)
                        {{ $ind['indicator_field']['indicator_issue_values']['m_trim_01'] }}
                    @endforeach
                </td>
                <td style="border:1px solid #383838;">
                    @foreach ( $item['indicadores'] as $ind)
                        {{ $ind['indicator_field']['indicator_issue_values']['m_trim_02'] }}
                    @endforeach
                </td>
                <td style="border:1px solid #383838;">
                    @foreach ( $item['indicadores'] as $ind)
                        {{ $ind['indicator_field']['indicator_issue_values']['m_trim_03'] }}
                    @endforeach
                </td>
                <td style="border:1px solid #383838;">
                    @foreach ( $item['indicadores'] as $ind)
                        {{ $ind['indicator_field']['indicator_issue_values']['m_trim_04'] }}
                    @endforeach
                </td>
                <td style="border:1px solid #383838;">
                    {{ $item['meta_realizada'] }}
                </td>
                <td style="border:1px solid #383838;">
                    {{ $item['grao_realizacao'] }}
                </td>
                <td style="border:1px solid #383838;">
                    {{ $item['local_realizacao'] }}
                </td>
                <td style="border:1px solid #383838;">
                    {{ $item['beneficiarios']['_homens']['meta'] }}
                </td>
                <td style="border:1px solid #383838;">
                    {{ $item['beneficiarios']['_mulheres']['meta'] }}
                </td>
                <td style="border:1px solid #383838;">
                    {{ $item['beneficiarios']['_total']['meta'] }}
                </td>
                <td style="border:1px solid #383838;">
                    {{ $item['orcamento'] }}
                </td>
                <td style="border:1px solid #383838;">
                    {{ $item['orcamento_exec'] }}
                </td>
                <td style="border:1px solid #383838;">
                    {{ $item['project']['name'] }}
                </td>

            </tr>
        @endforeach

        <tr>
            <td colspan="8"></td>
        </tr>
        <tr>
            <td colspan="8"></td>
        </tr>
        <tr>
            <td colspan="8">
                {{ date('Y') }} - Gerado por computador - CESC - GESPRO
            </td>
        </tr>
    </tbody>
</table>

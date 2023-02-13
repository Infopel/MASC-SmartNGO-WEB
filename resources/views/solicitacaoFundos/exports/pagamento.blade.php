
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MODELO DE REQUISIÇÃO DE PAGAMENTO</title>
</head>
<body>

    <center>
        <h5 style="margin: 4px; font-size: 95%">{{ $data['settings']['app_client_short_name'] }}</h5>
        <h5 style="margin: 4px; font-size: 95%">{{ $data['settings']['app_client_name'] }}</h5>
        <h5 style="margin: 4px; font-size: 95%; font-weight: 400;">{{ $data['settings']['app_title'] }}</h5>
        <h5 style="margin: 4px; font-size: 95%; font-weight: 400;">REQUISIÇÃO DE PAGAMENTO</h5>
    </center>
    <table style="border-collapse: collapse; table-layout: fixed; padding: 4px; font-size:75%; width: 100%; border-color: black; margin: auto" border="1" class="m-auto">
        <tbody>
            <tr>
                <td  style="padding: 4px; background-color: #e6e6e6; font-weight: bold">Nº</td>
                <td colspan="4" style="padding-left: 8px">
                    {{ $data['solicitacao']->num_requisicao ?? null }}
                </td>
            </tr>
            <tr>
                <td  style="padding: 4px; background-color: #e6e6e6; font-weight: bold">DATA</td>
                <td colspan="4" style="padding-left: 8px">
                    {{ $data['solicitacao']->created_on ?? null }}
                </td>
            </tr>
            <tr>
                <td  style="padding: 4px; background-color: #e6e6e6; font-weight: bold">DOADOR</td>
                <td colspan="4" style="padding-left: 8px">
                    {{ $data['solicitacao']->processoPagamento->doador_name ?? null }}
                </td>
            </tr>
            <tr>
                <td  style="padding: 4px; background-color: #e6e6e6; font-weight: bold">PROJECTO</td>
                <td colspan="4" style="padding-left: 8px">
                    {{ $data['solicitacao']->project->name ?? null }}
                </td>
            </tr>
            <tr>
                <td  style="padding: 4px; background-color: #e6e6e6; font-weight: bold">PILAR</td>
                <td colspan="4" style="padding-left: 8px">
                    {{ $data['solicitacao']->pilar->name ?? null }}
                </td>
            </tr>
            <tr>
                <td  style="padding: 4px; background-color: #e6e6e6; font-weight: bold">RUBRICA</td>
                <td colspan="4" style="padding-left: 8px">
                    @foreach ($data['solicitacao']->rubricas as $item)
                        <li style="margin-left: 24px;">
                            {{ $item->rubrica->rubrica }}.{{ $item->rubrica->name }}
                        </li>
                    @endforeach
                </td>
            </tr>
            <tr>
                <td  style="padding: 4px; background-color: #e6e6e6; font-weight: bold">BENEFICIÁRIO</td>
                <td colspan="4" style="padding-left: 8px">
                </td>
            </tr>
            <tr>
                <td  style="padding: 4px; background-color: #e6e6e6; font-weight: bold">DESCRIÇÃO</td>
                <td colspan="4" style="padding-left: 8px">
                    {{ $data['solicitacao']->objectivo ?? null }}
                </td>
            </tr>
            <tr>
                <td  style="padding: 4px; background-color: #e6e6e6; font-weight: bold">CHEQUE Nº</td>
                <td colspan="1" style="width: 40px !important">
                    @if ($data['solicitacao']->processoPagamento == null ? false : $data['solicitacao']->processoPagamento->paymentType == 'cheque')
                        <input type="checkbox" disabled checked style="padding: 0px; font-size: 16px; margin-left: 45px; margin-right: auto">
                    @endif
                </td>
                <td colspan="3">
                    @if ($data['solicitacao']->processoPagamento == null ? false : $data['solicitacao']->processoPagamento->paymentType == 'cheque')
                        {{ $data['solicitacao']->processoPagamento->check_trans_number ?? null }}
                    @endif
                </td>
            </tr>
            <tr>
                <td  style="padding: 4px; background-color: #e6e6e6; font-weight: bold">TRANSFERÊNCIA</td>
                <td colspan="1" style="width: 40px !important">
                    @if ($data['solicitacao']->processoPagamento == null ? false : $data['solicitacao']->processoPagamento->paymentType == 'transferencia')
                        <input type="checkbox" disabled checked style="padding: 0px; font-size: 16px; margin-left: 45px; margin-right: auto">
                    @endif
                </td>
                <td colspan="3">
                    @if ($data['solicitacao']->processoPagamento == null ? false : $data['solicitacao']->processoPagamento->paymentType == 'transferencia')
                        {{ $data['solicitacao']->processoPagamento->check_trans_number ?? null }}
                    @endif
                </td>
            </tr>
        </tbody>
    </table>

    <table style="border-collapse: collapse; table-layout: fixed; padding: 4px; font-size:75%; width: 100%; margin-top: 18px; border-color: black;" border="1">
        <tbody>
            <tr>
                <td style="padding: 4px; background-color: #e6e6e6; font-weight: bold">NOME DO BANCO</td>
                <td colspan="4" style="padding-left: 8px">
                    {{ $data['solicitacao']->processoPagamento->nome_banco ?? null }}
                </td>
            </tr>
            <tr>
                <td style="padding: 4px; background-color: #e6e6e6; font-weight: bold">Nº CONTA</td>
                <td colspan="4" style="padding-left: 8px">
                    {{ $data['solicitacao']->processoPagamento->num_banco ?? null }}
                </td>
            </tr>
            <tr>
                <td  style="padding: 4px; background-color: #e6e6e6; font-weight: bold">NIB</td>
                <td colspan="4" style="padding-left: 8px">
                    {{ $data['solicitacao']->processoPagamento->nib_banco ?? null }}
                </td>
            </tr>
            <tr>
                <td style="padding: 4px; background-color: #e6e6e6; font-weight: bold">TOTAL </td>
                <td colspan="4" style="padding-left: 8px">
                    {{ number_format(($data['solicitacao']->processoPagamento->valor ?? 0), 2).' MZN' }}
                </td>
            </tr>
            <tr>
                <td colspan="5" style="padding: 4px; font-weight: bold; border-bottom: 0px;">NOTAS:</td>
            </tr>
            <tr>
                <td colspan="5" style="padding: 4px; border-top: 0px;"></td>
            </tr>
        </tbody>
    </table>

    <table style="border-collapse: collapse; border-color: black; table-layout: fixed; margin-top: 18px; font-size:75%; width: 100%;" border="1">
        <tbody>
            <tr>
                <td style="padding: 4px; background-color: #e6e6e6; font-weight: bold">PREPARADO POR</td>
                <td colspan="" style="padding-left: 8px">
                    {{ $data['approvations']['_contabilidade']->approvedBy->full_name ?? '----' }}
                </td>
                <td style="padding: 4px; background-color: #e6e6e6; font-weight: bold">Data</td>
                <td colspan="" style="padding-left: 8px">
                    {{ $data['approvations']['_contabilidade']->approved_on ?? '----' }}
                </td>
            </tr>
            <tr>
                <td style="padding: 4px; background-color: #e6e6e6; font-weight: bold">APROVADO POR</td>
                <td colspan="" style="padding-left: 8px">
                    {{ $data['approvations']['_lliderDaf']->approvedBy->full_name ?? '----' }}
                </td>
                <td style="padding: 4px; background-color: #e6e6e6; font-weight: bold">Data</td>
                <td colspan="" style="padding-left: 8px">
                    {{ $data['approvations']['_lliderDaf']->approved_on ?? '----' }}
                </td>
            </tr>
            <tr>
                <td style="padding: 4px; background-color: #e6e6e6; font-weight: bold">AUTORIZADO POR</td>
                <td colspan="" style="padding-left: 8px">
                    {{ $data['approvations']['_dirExec']->approvedBy->full_name ?? '----' }}
                </td>
                <td style="padding: 4px; background-color: #e6e6e6; font-weight: bold">Data</td>
                <td colspan="" style="padding-left: 8px">
                    {{ $data['approvations']['_dirExec']->approved_on ?? '----' }}
                </td>
            </tr>
        </tbody>
    </table>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumo de Solicitação de Fundos</title>
</head>
<body>
    <table style="border-collapse: collapse; border: 1px solid; table-layout: fixed; width: 100%;" class="m-auto">
        <tr>
            <td colspan="2">
                <center>
                    <h5 style="margin: 4px; font-size: 95%">{{ $data['settings']['app_client_name'] }}</h5>
                    <h5 style="margin: 4px; font-size: 95%; font-weight: 400;">{{ $data['settings']['app_title'] }}</h5>
                    <h5 style="margin: 4px; font-size: 95%; font-weight: 400;">Resumo de Solicitação de Fundos</h5>
                </center>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding: 8px">
               <table style="font-size: 75%; width: 100%;">
                    <tbody>
                        <tr>
                            <td colspan="2" style="height: 8px;"></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;" class="text-nowrap">Numérico de Requisição</td>
                            <td style="border:1px solid #383838; padding: 0px 8px; font-weight: bold">
                                {{ $data['solicitacao']->num_requisicao }}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; margin-top: 24px">Requisitante</td>
                            <td colspan="1" style="border:1px solid #383838; padding: 0px 8px;">
                                {{ $data['solicitacao']->requestBy->full_name }}
                            </td>
                        </tr>

                        <tr>
                            <td style="font-weight: bold;">Valor Estimado</td>
                            <td style="border:1px solid #383838; padding: 0px 8px; font-weight: bold">
                                {{ number_format(($data['solicitacao']->valor_estimado),2) }}
                            </td>
                            <td style="align-items: center; justify-content: center; text-align: center">MZN</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="height: 14px;"></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; margin-top: 24px">Linhas Orçamentais</td>
                            <td>
                            </td>
                        </tr>
                        @forelse ($data['solicitacao']->rubricas as $item)
                            <tr>
                                <td></td>
                                <td style="border:1px solid #383838; padding: 0px 8px;">
                                    {{ $item->rubrica->rubrica }}.{{ $item->rubrica->name }}
                                </td>
                            </tr>
                            @empty
                            <td></td>
                            <td style="border:1px solid #383838; padding: 0px 8px;">
                                Sem rubricas definidas
                            </td>
                        @endforelse
                    </tbody>
                </table>
            </td>
        </tr>
        <tbody>
            <tr>
                <td style="padding-right: 8px; padding: 8px;">
                    <table style="font-size: 75%">
                        <tbody>
                            <tr>
                                <td style="height: 14px;"></td>
                            </tr>
                            <tr>
                                <td style="color: red; font-weight: bold;">Areas</td>
                            </tr>
                            @foreach ($areas as $item)
                                <tr>
                                    <td style="white-space: nowrap !important; padding: 0px; padding-right: 16px;">{{ $item->name }}</td>

                                    <td style="border:1px solid #383838; width: 100px; align-items: center; justify-content: center; padding: 0px;">
                                        @if (in_array($item->id, $data['selected_areas']))
                                            <input type="checkbox" disabled checked style="padding: 0px; margin-top: -5px; font-size: 16px; margin-left: 45px; margin-right: auto">
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="2" style="height: 14px;"></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="color: red; font-weight: bold; margin-top: 24px">Actividades</td>
                            </tr>
                            @foreach ($actividades as $item)
                                <tr>
                                    <td style="white-space: nowrap !important;">{{ $item->name }}</td>
                                    <td style="border:1px solid #383838; width: 100px; align-items: center; justify-content: center; padding: 0px;">
                                        @if (in_array($item->id, $data['selected_actividades']))
                                            <input type="checkbox" disabled checked style="padding: 0px; margin-top: -5px; font-size: 16px; margin-left: 45px; margin-right: auto">
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="2" style="height: 14px;"></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="color: red; font-weight: bold;">Necessidades</td>
                            </tr>
                            @foreach ($necessidades as $item)
                                <tr>
                                    <td style="white-space: nowrap !important;">{{ $item->name }}</td>
                                    <td style="border:1px solid #383838; width: 100px; align-items: center; justify-content: center; padding: 0px;">
                                       @if (in_array($item->id, $data['selected_necessidades']))
                                            <input type="checkbox" disabled checked style="padding: 0px; margin-top: -5px; font-size: 16px; margin-left: 45px; margin-right: auto">
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
                <td style="padding: 8px">
                    <table style="font-size: 75%">
                        <tbody>
                            <tr>
                                <td style="color: red; font-weight: bold;">Pilar</td>
                                <td colspan="2" >
                                    {{ $data['solicitacao']->pilar->name }}
                                </td>
                            </tr>
                            <tr>
                                <td style="color: red; font-weight: bold; padding-right: 24px; padding-top: 8px;">Projecto</td>
                                <td colspan="2" style="margin-left: 16px; width: 100%; padding-top: 8px;">
                                    {{ $data['solicitacao']->project->name }}
                                </td>
                            </tr>

                            <tr>
                                <td style="height: 8px;"></td>
                            </tr>
                            <tr>
                                <td style="color: red; font-weight: bold;">Informação Adicional</td>
                            </tr>
                            <tr>
                                <td style="height: 8px;"></td>
                            </tr>
                            <tr>
                                <td>Data</td>
                                <td style="border:1px solid #383838; width: 100px; align-items: center; justify-content: center; margin-left: 16px; padding: 0px; color: red; font-weight: bold; padding-left: 8px; white-space: nowrap !important;">
                                    {{ $data['solicitacao']->data }}
                                </td>
                            </tr>
                            <tr>
                                <td>Local</td>
                                <td style="border:1px solid #383838; width: 100px; align-items: center; justify-content: center; margin-left: 16px; padding: 0px; color: red; font-weight: bold; padding-left: 8px; white-space: nowrap !important;">
                                    {{ $data['solicitacao']->local }}
                                </td>
                            </tr>
                            <tr>
                                <td>Num. Participantes</td>
                                <td style="border:1px solid #383838; width: 100px; align-items: center; justify-content: center; margin-left: 16px; padding: 0px; padding-left: 8px">
                                    {{ $data['solicitacao']->num_participantes }}
                                </td>
                            </tr>
                            <tr>
                                <td>Num. Dais</td>
                                <td style="border:1px solid #383838; width: 100px; align-items: center; justify-content: center; margin-left: 16px; padding: 0px; padding-left: 8px;">
                                    {{ $data['solicitacao']->num_dias }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="1" style="height: 8px;"></td>
                            </tr>
                            <tr>
                                <td>OSC's Convidadas</td>
                            </tr>
                            <tr>
                                <td colspan="3" style="padding: 2px">
                                    <div style="width: 100%; min-height: 65px; border: 1px solid #383838; padding: 8px">
                                       {{ $data['solicitacao']->_osc ?? null }}
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="height: 8px;"></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="color: red; font-weight: bold;">Anexos Obrigatórios</td>
                            </tr>
                            <tr>
                                <td>Termos de Referencia</td>
                                <td style="border:1px solid #383838; width: 100px; align-items: center; justify-content: center; padding: 0px;">
                                    <input type="checkbox" disabled checked style="padding: 0px; margin-top: -5px; font-size: 16px; margin-left: 45px; margin-right: auto">
                                </td>
                            </tr>
                            <tr>
                                <td>Plano de Treinamento</td>
                                <td style="border:1px solid #383838; width: 100px; align-items: center; justify-content: center; padding: 0px;">
                                    <input type="checkbox" disabled checked style="padding: 0px; margin-top: -5px; font-size: 16px; margin-left: 45px; margin-right: auto">
                                </td>
                            </tr>
                            <tr>
                                <td>Contracto</td>
                                <td style="border:1px solid #383838; width: 100px; align-items: center; justify-content: center; padding: 0px;">
                                    <input type="checkbox" disabled checked style="padding: 0px; margin-top: -5px; font-size: 16px; margin-left: 45px; margin-right: auto">
                                </td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td style="border:1px solid #383838; width: 100px; align-items: center; justify-content: center; padding: 0px;">
                                    <input type="checkbox" disabled checked style="padding: 0px; margin-top: -5px; font-size: 16px; margin-left: 45px; margin-right: auto">
                                </td>
                            </tr>
                            <tr>
                                <td>Orçamento Especifico</td>
                                <td style="border:1px solid #383838; width: 100px; align-items: center; justify-content: center; padding: 0px;">
                                    <input type="checkbox" disabled checked style="padding: 0px; margin-top: -5px; font-size: 16px; margin-left: 45px; margin-right: auto">
                                </td>
                            </tr>
                            <tr>
                                <td>Procurement</td>
                                <td style="border:1px solid #383838; width: 100px; align-items: center; justify-content: center; padding: 0px;">
                                    <input type="checkbox" disabled checked style="padding: 0px; margin-top: -5px; font-size: 16px; margin-left: 45px; margin-right: auto">
                                </td>
                            </tr>
                            <tr>
                                <td style="height: 8px;"></td>
                            </tr>
                            <tr>
                                <td style="color: red; font-weight: bold;">Objectivo</td>
                            </tr>
                            <tr>
                                <td colspan="3" style="padding: 2px">
                                    <div style="border: 1px solid #383838; padding: 8px">
                                        {{ $data['solicitacao']->objectivo }}
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>

            <tr>
                <td colspan="2" style="padding: 8px">
                    <table style="font-size: 75%; width: 100%;">
                        <tbody>
                            <tr>
                                <td style="font-weight: bold; margin-top: 24px"></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; margin-top: 24px">Requisitante</td>
                                <td style="border:1px solid #383838; padding: 0px 8px;">
                                    {{ $data['solicitacao']->requestBy->full_name ?? '----' }}
                                </td>
                                <td style="align-items: center; justify-content: center; text-align: center">Data</td>
                                <td style="border:1px solid #383838; align-items: center; justify-content: center;margin-left: 16px;  padding: 0px 8px;">
                                    {{ $data['solicitacao']->created_on ?? '----' }}
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; margin-top: 24px">Area Programatica</td>
                                <td style="border:1px solid #383838; padding: 0px 8px;">
                                    {{ $data['approvations']['_programtica']->approvedBy->full_name ?? $data['solicitacao']->project->manager }}
                                </td>
                                <td style="align-items: center; justify-content: center; text-align: center">Data</td>
                                <td style="border:1px solid #383838; align-items: center; justify-content: center; margin-left: 16px;  padding: 0px 8px;">
                                    {{ $data['approvations']['_programtica']->approved_on ?? '----' }}
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; margin-top: 24px">Area Financeira</td>
                                <td style="border:1px solid #383838; padding: 0px 8px;">
                                    {{ $data['approvations']['_financeira']->approvedBy->full_name ?? '----' }}
                                </td>
                                <td style="align-items: center; justify-content: center; text-align: center">Data</td>
                                <td style="border:1px solid #383838; align-items: center; justify-content: center; margin-left: 16px;  padding: 0px 8px;">
                                    {{ $data['approvations']['_financeira']->approved_on ?? '----' }}
                                </td>
                            </tr>
                            <!--
                            <tr>
                                <td style="font-weight: bold; margin-top: 24px">Directora Executiva</td>
                                <td style="border:1px solid #383838; padding: 0px 8px;">
                                    { $data['approvations']['_dirExec']->approvedBy->full_name ?? '----' }}
                                </td>
                                <td style="align-items: center; justify-content: center; text-align: center">Data</td>
                                <td style="border:1px solid #383838; align-items: center; justify-content: center; margin-left: 16px;  padding: 0px 8px;">
                                    {$data['approvations']['_dirExec']->created_on ?? '----' }}
                                </td>
                            </tr>-->
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>


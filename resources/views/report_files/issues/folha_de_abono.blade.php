@extends('report_files.index', ['title' => 'Folha de abono de prestação de contas'])
@section('content')

    <center>
        <h5 class="border p-2" style="with:auto">FOLHA DE ABONO DE PRESTAÇÃO DE CONTAS</h5>
    </center>
    <div class="p-2" style="padding-top:0px; margin-top: -14px;">
        <table border="0" cellspacing="0" style="font-size: 90%">
            <tbody>
                <tr>
                    <th style="padding-right: 10px;">De:</th>
                    <td>{{ $issue['author']->full_name }}</td>
                </tr>
                <tr>
                    <th style="padding-right: 10px;">Duração:</th>
                    <td>
                       {{ $issue['due_date'] ? \Carbon\Carbon::parse($issue['due_date'])->format('d/m/Y') : 'dd-mm-yyyy -- Date Undefined' }}
                    </td>
                </tr>
                <tr>
                    <th style="padding-right: 10px;">Projecto:</th>
                    <td>
                        <b>{{ $issue['project']['name'] }}</b>
                    </td>
                </tr>
                <tr>
                    <th style="padding-right: 10px;">Motivo / Tarefa:</th>
                    <td>{{ $issue['subject'] }}</td>
                </tr>
                <tr>
                    <th style="padding-right: 10px;">Destino / Provincia:</th>
                    <td>{{ $issue->custom_field_values()->where('custom_field_id', 30)->first() }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="" style="width:100%;">
        <table border="1" class="table" style="width:100%; font-size: 90%">
            <thead>
                <tr>
                    <th style="padding-left: 4px; width:1%;">Rubrica</th>
                    <th style="padding-left: 4px;">Descrição</th>
                    <th style="padding-left: 4px; width:120px;">Valor (MZN)</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($issue['orcamento'] as $index => $orcamento)
                    <tr>
                        <td style="padding-left: 4px;" class="text-right">
                            {{ $orcamento->rubrica->rubrica }}
                        </td>
                        <td style="padding-left: 4px;">
                            {{ $orcamento->rubrica->name }}
                        </td>
                        <td class="text-right" style="padding-right: 8px;">
                            {{ number_format(($orcamento->issued_value),2) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">
                            {{ __('lang.label_no_data') }}
                        </td>
                    </tr>
                @endforelse
                <tr>
                    <td colspan="2">Total</td>
                    <td class="text-right" style="padding-right: 8px;">
                        <b>{{ number_format(($issue['orcamento']->sum('issued_value')),2) }}</b>
                    </td>
                </tr>
            </tbody>
        </table>

        <p style="font-size: 85%; margin-top: 4px; ">
            Declaro que me comprometo a entregar ao DAF, os comprovativos respeitantes a todas as despesas efetuadas
            (com exceção do valor para alimentação) acompanhados de bilhete de passagem, talão,
            relatório de viagem, no prazo de 5 dias uteis apos o meu regresso.
        </p>
    </div>

    <center class="p-2" style="width:100%;">
        <table style="font-size: 90%; margin:auto">
            <thead>
                <tr>
                    <th class="text-center">Elaborado Por</th>
                    <th class="text-center">Verificado Por</th>
                    <th class="text-center">Validado</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="p-2">
                        _________________________
                    </td>
                    <td class="p-2">
                        _________________________
                    </td>
                    <td class="p-2">
                        _________________________
                    </td>
                </tr>
                <tr>
                    <td class="text-center">
                        Data ____/____/______
                    </td>
                    <td class="text-center">
                        Data ____/____/______
                    </td>
                    <td class="text-center">
                        Data ____/____/______
                    </td>
                </tr>
            </tbody>
        </table>
    </center>
    <footer style="color:#121517">
        <small>{{ date('Y') }} - Gerado pelo {{ $application['app_client_short_name'] }} - SGMP - <b>Desenvolvido Por INFOPEL</b></small>
    </footer>
    <div class="page_break"></div>
     <footer style="color:#121517">
        <small>{{ date('Y') }} - Gerado pelo {{ $application['app_client_short_name'] }} - SGMP - <b>Desenvolvido Por INFOPEL</b></small>
    </footer>
    <div style="width: 100%;">
        <center>
        <h5 class="border p-2" style="with:auto">Logs de Aprovações</h5>
        </center>
        <div class="p-2" style="padding-top:0px; margin-top: -14px;">
            <table border="0" cellspacing="0" style="font-size: 90%">
                <tbody>
                    <tr>
                        <th style="padding-right: 10px;">Autor:</th>
                        <td>{{ $issue['author']->full_name }}</td>
                    </tr>
                    <tr>
                        <th style="padding-right: 10px;">Projecto:</th>
                        <td>
                            <b>{{ $issue['project']['name'] }}</b>
                        </td>
                    </tr>
                    <tr>
                        <th style="padding-right: 10px;">Tarefa:</th>
                        <td>{{ $issue['subject'] }}</td>
                    </tr>
                    <tr>
                        <th style="padding-right: 10px;">Destino / Provincia:</th>
                        <td>{{ $issue->custom_field_values()->where('custom_field_id', 30)->first() }}</td>
                    </tr>
                    <tr>
                        <th style="padding-right: 10px;">Orçamento Total Solicitado:</th>
                        <td>
                            <b>{{ number_format(($issue['orcamento']->sum('issued_value')),2) }} MZN</b>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <table border="1" cellspacing="0" cellpadding="1" style="width: 100%; font-size: 90%">
            <thead>
                <tr>
                    <th style="padding-left: 4px; text:text-nowrap">Descrição da Aprovação</th>
                    <th style="padding-left: 4px; text:text-nowrap">Aprovado por</th>
                    <th style="padding-left: 4px;">Categoria</th>
                    <th style="padding-left: 4px;">Data</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($issue->issue_approvement_requests as $item)
                    @if ($item->is_approved)
                        <tr>
                            <td style="padding-left: 4px; text:text-nowrap">{{ $item->approvement_flow->description }}</td>
                            <td style="padding-left: 4px; text:text-nowrap">{{ $item->approvedBy->full_name }}</td>
                            <td style="padding-left: 4px;">{{ $item->role->name }}</td>
                            <td style="padding-left: 4px;">{{ $item->approved_on }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

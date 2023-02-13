<?php

namespace App\CommandConcerns\Email;

use App\Models\AprovacaoFundos;
use App\Models\AprovacaoTarefas;
use Illuminate\Console\Command;
use App\Events\IssuesNotificationEvent;

class LembreteTarefas extends Command
{
    public $tarefas_aprovar = [];
    /**
     * Retornar Tarefas
     *
     * @return Issues $issues
     */
    public function get_issues($days = 2)
    {
        // Retornar tarefas com solicitação de aprovação não reportada a mais de X dias X = $days
        return AprovacaoFundos::where('is_aproved', false)
            ->where('created_on', \Carbon\Carbon::now()->subDays($days))
            ->get()
            ->groupBy('nivel');
    }



    public function processar_tarefas_por_aprovar($days = 2)
    {
        $tarefas_aprovar =  AprovacaoFundos::where('is_aproved', false)
            ->where('created_on', \Carbon\Carbon::now()->subDays($days))
            ->get()
            ->groupBy('nivel');
        if($tarefas_aprovar->count() == 0){
            $this->info('Nehuma Tarefa pendente por reportar aprovação, criada a mais de '. $days . " dias\n");
            \Log::info('Nehuma Tarefa pendente por reportar aprovação, criada a mais de '. $days . " dias\n");
        }
        $task_list = "";
        foreach ($tarefas_aprovar as $nivel => $tarefas){
            foreach ($tarefas_aprovar[$nivel] as $approce_request){
                if($approce_request->issue != null){

                    $task_list .= "<li><b>Tarefa: </b>". $approce_request->issue->subject."</li>";
                    $task_list .= "<li><b>Projecto: </b>". $approce_request->issue->project->name."</li>";
                    $task_list .= "<li><b>Link:</b> <a href='" . route('orcamento.projecto.solicitacao-fundos.show', [
                        'project_identifier' => $approce_request->issue->project['identifier'],
                        'issue' => $approce_request->issue->id]). "'> Acesse nesse Link</a></li>";

                    $title = "Aprovação pendente: ".$tarefas_aprovar[$nivel][0]->description;
                    $this->send_email_notification($approce_request->issue, $nivel, $days, $task_list, $title);
                    $this->info("\nEmail enviado com sucesso!\n");
                    $this->progress_bar->advance();
                }
                $task_list = "";
            }
        }
    }

    /**
     * Mandr email de lembrete para os user validarem as tarefas
     */
    protected function send_email_notification($issue, $nivel, $days, $task_list, $title)
    {
        switch ($nivel) {
            case 1:
                $content = "O Sistema de Monitoria de Projecto e do Plano Estratégico – CESC encontrou uma tarefa com atraso de " . $days . " que precisa da seu report(aprovação/reprovação) de: (<b>" . $title . "</b>) para que possa passar para próxima fase. <p>Por favor click no link da tarefa para ver e validar ou selecione o projecto (<b>". $issue->project->name."</b>) e de seguida a aba de 'Solicitação de fundos' para ver essa e mais tarefas com solicitação de aprovação pendente.</p><p>Abaixo listamos a tarefa com aprovação pendente:</p><ul>" . $task_list . "</ul>";

                \Log::info($title . "\n" . $content);
                event(new IssuesNotificationEvent($issue, auth()->user(), $content, $title, ['aprovar_despesas']));
                break;
            case 2:
                $content = "O Sistema de Monitoria de Projecto e do Plano Estratégico – CESC encontrou uma tarefa com atraso de " . $days . " que precisa da seu report(aprovação/reprovação) de: (<b>" . $title . "</b>) para que possa passar para próxima fase. <p>Por favor click no link da tarefa para ver e validar ou selecione o projecto (<b>" . $issue->project->name . "</b>) e de seguida a aba de 'Solicitação de fundos' para ver essa e mais tarefas com solicitação de aprovação pendente.</p><p>Abaixo listamos a tarefa com aprovação pendente:</p><ul>" . $task_list . "</ul>";

                \Log::info($title . "\n" . $content);
                event(new IssuesNotificationEvent($issue, auth()->user(), $content, $title, ['aprovar_plano']));
                break;
            case 3:
                $content = "O Sistema de Monitoria de Projecto e do Plano Estratégico – CESC encontrou uma tarefa com atraso de " . $days . " que precisa da seu report(aprovação/reprovação) de: (<b>" . $title . "</b>) para que possa passar para próxima fase. <p>Por favor click no link da tarefa para ver e validar ou selecione o projecto (<b>". $issue->project->name."</b>) e de seguida a aba de 'Solicitação de fundos' para ver essa e mais tarefas com solicitação de aprovação pendente.</p><p>Abaixo listamos a tarefa com aprovação pendente:</p><ul>" . $task_list . "</ul>";

                \Log::info($title . "\n" . $content);
                event(new IssuesNotificationEvent($issue, auth()->user(), $content, $title, ['conferir_plano']));
                break;
            case 4:
                $content = "O Sistema de Monitoria de Projecto e do Plano Estratégico – CESC encontrou uma tarefa com atraso de " . $days . " que precisa da seu report(aprovação/reprovação) de: (<b>" . $title . "</b>) para que possa passar para próxima fase. <p>Por favor click no link da tarefa para ver e validar ou selecione o projecto (<b>". $issue->project->name."</b>) e de seguida a aba de 'Solicitação de fundos' para ver essa e mais tarefas com solicitação de aprovação pendente.</p><p>Abaixo listamos a tarefa com aprovação pendente:</p><ul>" . $task_list . "</ul>";

                \Log::info($title . "\n" . $content);
                event(new IssuesNotificationEvent($issue, auth()->user(), $content, $title, ['auth_pagamento']));
                break;
            case 5:
                $content = "O Sistema de Monitoria de Projecto e do Plano Estratégico – CESC encontrou uma tarefa com atraso de " . $days . " que precisa da seu report(aprovação/reprovação) de: (<b>" . $title . "</b>) para que possa passar para próxima fase. <p>Por favor click no link da tarefa para ver e validar ou selecione o projecto (<b>". $issue->project->name."</b>) e de seguida a aba de 'Solicitação de fundos' para ver essa e mais tarefas com solicitação de aprovação pendente.</p><p>Abaixo listamos a tarefa com aprovação pendente:</p><ul>" . $task_list . "</ul>";

                \Log::info($title . "\n" . $content);
                event(new IssuesNotificationEvent($issue, auth()->user(), $content, $title, ['processar_pagamento']));
                break;
            case 6:
                $content = "O Sistema de Monitoria de Projecto e do Plano Estratégico – CESC encontrou uma tarefa com atraso de " . $days . " que precisa da seu report(aprovação/reprovação) de: (<b>" . $title . "</b>) para que possa passar para próxima fase. <p>Por favor click no link da tarefa para ver e validar ou selecione o projecto (<b>". $issue->project->name."</b>) e de seguida a aba de 'Solicitação de fundos' para ver essa e mais tarefas com solicitação de aprovação pendente.</p><p>Abaixo listamos a tarefa com aprovação pendente:</p><ul>" . $task_list . "</ul>";

                \Log::info($title . "\n" . $content);
                event(new IssuesNotificationEvent($issue, auth()->user(), $content, $title, ['validar_pagamento']));
                break;
            case 7:
                $content = "O Sistema de Monitoria de Projecto e do Plano Estratégico – CESC encontrou uma tarefa com atraso de " . $days . " que precisa da seu report(aprovação/reprovação) de: (<b>" . $title . "</b>) para que possa passar para próxima fase. <p>Por favor click no link da tarefa para ver e validar ou selecione o projecto (<b>". $issue->project->name."</b>) e de seguida a aba de 'Solicitação de fundos' para ver essa e mais tarefas com solicitação de aprovação pendente.</p><p>Abaixo listamos a tarefa com aprovação pendente:</p><ul>" . $task_list . "</ul>";

                \Log::info($title . "\n" . $content);
                event(new IssuesNotificationEvent($issue, auth()->user(), $content, $title, ['aprovar_pagamento']));
                break;
            case 8:
                $content = "O Sistema de Monitoria de Projecto e do Plano Estratégico – CESC encontrou uma tarefa com atraso de " . $days . " que precisa da seu report(aprovação/reprovação) de: (<b>" . $title . "</b>) para que possa passar para próxima fase. <p>Por favor click no link da tarefa para ver e validar ou selecione o projecto (<b>". $issue->project->name."</b>) e de seguida a aba de 'Solicitação de fundos' para ver essa e mais tarefas com solicitação de aprovação pendente.</p><p>Abaixo listamos a tarefa com aprovação pendente:</p><ul>" . $task_list . "</ul>";

                \Log::info($title . "\n" . $content);
                event(new IssuesNotificationEvent($issue, auth()->user(), $content, $title, ['desembolsar_fundos']));
                break;
            case 9:
                $content = "O Sistema de Monitoria de Projecto e do Plano Estratégico – CESC encontrou uma tarefa com atraso de " . $days . " que precisa da seu report(aprovação/reprovação) de: (<b>" . $title . "</b>) para que possa passar para próxima fase. <p>Por favor click no link da tarefa para ver e validar ou selecione o projecto (<b>". $issue->project->name."</b>) e de seguida a aba de 'Solicitação de fundos' para ver essa e mais tarefas com solicitação de aprovação pendente.</p><p>Abaixo listamos a tarefa com aprovação pendente:</p><ul>" . $task_list . "</ul>";

                \Log::info($title . "\n" . $content);
                event(new IssuesNotificationEvent($issue, auth()->user(), $content, $title, ['receber_fundos']));
                break;

            default:
                # code...
                break;
        }
    }


    /**
     * Processar tarefas por validar report do realizado
     */
    protected function processar_tarefas_por_validar($days)
    {
        $tarefas_aprovar =  AprovacaoTarefas::where('is_approved', false)
            ->where('created_on', \Carbon\Carbon::now()->subDays($days))
            ->get()
            ->groupBy('nivel');
        if ($tarefas_aprovar->count() == 0) {
            $this->info('Nehuma Tarefa pendente por reportar realizado de Indicadores e Orçamento Gasto, criada a mais de ' . $days . " dias\n");
            \Log::info('Nehuma Tarefa pendente por reportar realizado de Indicadores e Orçamento Gasto, criada a mais de ' . $days . " dias\n");
        }
        $task_list = "";
        foreach ($tarefas_aprovar as $nivel => $tarefas) {
            foreach ($tarefas_aprovar[$nivel] as $approce_request) {
                if ($approce_request->issue != null) {

                    $task_list .= "<li><b>Tarefa: </b>" . $approce_request->issue->subject . "</li>";
                    $task_list .= "<li><b>Projecto: </b>" . $approce_request->issue->project->name . "</li>";
                    $task_list .= "<li><b>Link:</b> <a href='" . route('orcamento.projecto.solicitacao-fundos.show', [
                        'project_identifier' => $approce_request->issue->project['identifier'],
                        'issue' => $approce_request->issue->id
                    ]) . "'> Acesse nesse Link</a></li>";

                    $title = "Aprovação pendente: " . $tarefas_aprovar[$nivel][0]->description;
                    $this->send_email_notification_tarefa_por_validar($approce_request->issue, $nivel, $days, $task_list, $title);
                    $this->info("\nEmail enviado com sucesso!\n");
                    $this->progress_bar->advance();
                }
                $task_list = "";
            }
        }
    }

    protected function send_email_notification_tarefa_por_validar($issue, $nivel, $days, $task_list, $title)
    {
        switch ($nivel) {
            case '1':
                $content = "O Sistema de Monitoria de Projecto e do Plano Estratégico – CESC encontrou uma tarefa com atraso de " . $days . " que precisa da seu report(aprovação/reprovação) de: (<b>" . $title . "</b>) - alcançado de Indicadores e Orçamento Gasto. <p>Por favor click no link da tarefa para ver e validar ou selecione o projecto (<b>" . $issue->project->name . "</b>) e de seguida a aba de 'Solicitação de fundos' para ver essa e mais tarefas com solicitação de aprovação pendente.</p><p>Abaixo listamos a tarefa com aprovação pendente:</p><ul>" . $task_list . "</ul>";

                \Log::info($title . "\n" . $content);
                // event(new IssuesNotificationEvent($issue, auth()->user(), $content, $title, ['aprovar_despesas']));
                break;

            default:
                # code...
                break;
        }
    }
}

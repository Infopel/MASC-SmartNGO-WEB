<?php

namespace App\Console\Commands;

use App\CommandConcerns\Email\LembreteTarefas;


class EnviarEmailLembreteAprovacao extends LembreteTarefas
{
    protected $signature = 'email:lembrete {action}';

    protected $description = 'Enviar Lembretes de aprovação de tarefas aos usuarios membros de projectos';

    public $progress_bar;

    public function __construct()
    {
        parent::__construct();
    }

    protected function avalible_action()
    {
        return array(
            'aprovacao',
            'validar',
            'report'
        );
    }

    /**
     * Definir dias para mandar um email ao user com
     * lembrete de aprovação
     */
    protected function periodos_de_notificacao()
    {
        return array(
            'warning_1' => 2,
            'warning_2' => 4,
            'warning_3' => 5,
            'fatal_warning' => 10,
        );
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if(in_array($this->argument('action'), $this->avalible_action())){
            $this->info("Verificação de tarefas com aprovação pendente iniciada🤙\n");
            $this->tarefas_aprovar = $this->get_issues();
            $this->line('Processando dados...'."");
            $this->progress_bar = $this->output->createProgressBar(count($this->tarefas_aprovar));


            switch ($this->argument('action')) {
                case 'aprovacao':
                    foreach ($this->periodos_de_notificacao() as $periodo){
                        $this->processar_tarefas_por_aprovar($periodo);
                    }
                    return;
                    break;
                case 'validar':
                    $this->info('Tarefas por validar');
                    break;
                case 'report':
                    foreach ($this->periodos_de_notificacao() as $periodo) {
                        $this->processar_tarefas_por_validar($periodo);
                    }
                    break;
                default:
                    # code...
                    break;
            }

            return;
        }else{
            return $this->info('action not found');
        }
    }


    public function processar_dados()
    {
        $this->tarefas_aprovar = $this->get_issues();
        $this->progress_bar->start();
        $this->line("\n<options=bold,reverse;>Encontramos " . count($this->tarefas_aprovar) . " Categorias com aprovação pendente!</>🤙\n");

        foreach ($this->periodos_de_notificacao() as $periodo) {
            $this->tarefas_aprovar = $this->get_issues($periodo);
            foreach ($this->tarefas_aprovar as $category => $por_aprovar) {
                $this->info("\n" . 'Encontramos ' . count($this->tarefas_aprovar[$category]) . ' tarefas com aprovação: ' . $category . ' - pendente a ' . $periodo . ' dias!');

                // Enviar email com solicitacao de aprovação da tarefa ao(s) user(s)
                // $this->line("<options=bold;>Email enviado para os usuarios a aprovar... </>🤙\n");
                $this->progress_bar->advance();
            }
        }

        $this->progress_bar->finish();
    }
}

<template>
  <div class="row m-1 ml-lg-5 mr-lg-5">
    <div class="col-12 containers mt-1 p-1">
      <div class="row">
        <div class="col-md-8 col-lg-9">
          <!-- row 1 -->
          <div class="row mb-3 text-center">
            <div class="col-md-3 mb-2 mb-lg-0">
              <div class="bg-white border rounded shadow-sm">
                <div class="mt-4 mb-4">
                  <h3 class="text-semibold no-margin">
                    {{ my_tasks }}
                  </h3>
                  <span class="text-muted">Minhas Actividades</span>
                </div>
              </div>
            </div>
            <div class="col-md-3 mb-2 mb-lg-0">
              <div class="bg-white border rounded shadow-sm">
                <div class="mt-4 mb-4">
                  <h3 class="text-semibold no-margin">
                    {{ assigned_tasks }}
                  </h3>
                  <span class="text-muted">Actividades por reportar</span>
                </div>
              </div>
            </div>
            <div class="col-md-3 mb-2 mb-lg-0">
              <div class="bg-white border rounded shadow-sm">
                <div class="mt-4 mb-4">
                  <h3 class="text-semibold no-margin">
                    {{ issuesToApprove.length }}
                  </h3>
                  <span class="text-muted">Fundos por Aprovar</span>
                </div>
              </div>
            </div>
            <div class="col-md-3 mb-2 mb-lg-0">
              <div class="bg-white border rounded shadow-sm">
                <div class="mt-4 mb-4">
                  <h3 class="text-semibold no-margin">
                    {{ 0 }}
                  </h3>
                  <span class="text-muted">Act. Por Validar o report</span>
                </div>
              </div>
            </div>
          </div>
          <!-- /row 1 -->

          <!-- row 2 -->

          <div class="row">
            <!-- Column 1 -->
            <div class="col-md-12 mb-3">
              <div class="card-block shadow-sm border bg-white p-3" style="min-height: 380px;">
                <div class="title-card bg-light p-2 mb-1 rounded">
                  <div class="">
                    <h6 class="mb-0">
                      <a href="#BudgetRequest" class="text-slate-800">
                        <i class="icon-stack3 text-slate-400"></i>
                        <span class="text-slate-800">Solicitação de Fundos</span>
                      </a>
                    </h6>
                  </div>
                </div>

                <nav>
                  <div class="nav nav-tabs pb-0 mb-1" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link link-option active" id="nav-Solic-Aprovadas" data-toggle="tab" href="#nav-Aprovadas" role="tab" aria-controls="nav-Aprovadas" aria-selected="true">Por Aprovar</a>

                     <a class="nav-item nav-link link-option" id="nav-Solic-Reporvadas" data-toggle="tab" href="#nav-Reporvadas" role="tab" aria-controls="nav-Reporvadas" aria-selected="true">Minhas solicitações</a>
                  </div>
                </nav>

                <div class="tab-content" id="nav-tabContent">
                  <div class="tab-pane fade show active" id="nav-Aprovadas" role="tabpanel" aria-labelledby="nav-Solic-Aprovadas">
                    <div class="table-responsive">
                      <div class="table-responsive">
                        <table class="table table-sm" style="font-size: 93%">
                          <thead class="bg-red-500 bg-slate-800">
                            <th class="text-center text-nowrap" title="Solicitado em/(a)">
                              <i class="icon-calendar2"></i>Data
                            </th>
                            <th class="text-center text-nowrap"><i class="icon-user"></i>Solic. Por</th>
                            <th>Objectivo</th>
                            <th>Cat. Aprovação</th>
                          </thead>
                          <tbody>
                            <template v-if="issuesToApprove">
                              <tr v-for="(issue, key) in issuesToApprove" :key="key">
                                <td  title="Solicitado em/(a)" class="text-nowrap">
                                  {{ issue._time }}
                                </td>
                                <td class="text-nowrap">
                                  {{ `${issue.request_by.firstname} ${issue.request_by.lastname}` }}
                                </td>
                                <td>
                                  <a v-bind:href="`${issue.solicitacao.project.route}/orcamento/new/solicitacao-fundos/requisicao/${issue.num_requisicao}`">
                                    {{ issue.solicitacao.objectivo }}
                                  </a>
                                </td>
                                <td class="text-nowrap">
                                  {{ issue.flow_description }}
                                </td>
                              </tr>
                            </template>
                            <tr v-if="issuesToApprove.length === 0">
                              <td class="p-1 text-center bg-light" colspan="5">
                                {{ __("lang.label_no_data") }}
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>

                  <div class="tab-pane fade" id="nav-Reporvadas" role="tabpanel" aria-labelledby="nav-Solic-Reporvadas">
                    <div class="table-responsive">

                      <table class="table table-sm" style="font-size: 93%">
                        <thead class="bg-slate-700">
                          <th>Estado</th>
                          <th>#Ref Requisição</th>
                          <th>Projecto</th>
                          <th class="text-nowrap">Data de requisição</th>
                          <th>Objectivo</th>
                          <th class="text-nowrap">Fase aprovação actual</th>
                          <th class="text-nowrap">User p/ validar</th>
                        </thead>

                        <template v-if="myBudgetRequestProcesses">
                            <tr v-for="(request, key) in myBudgetRequestProcesses" :key="key">
                              <td  title="Solicitado em/(a)">
                                <span v-if="!request.is_approved && !request.is_rejected" class="badge rounded-0 p-1 bg-warning border-0 text-black-50">Pendente</span>
                                <span v-if="!request.is_approved && request.is_rejected" class="badge rounded-0 p-1 badge-danger">Reprovado</span>
                                <span v-if="request.is_approved && !request.is_rejected" class="badge rounded-0 p-1 badge-success">Aprovado</span>
                              </td>
                              <td  title="Referencia da requisição" class="text-nowrap">
                                <a
                                v-bind:href="`${request.route}`">
                                  {{ request.num_requisicao}}
                                </a>

                              </td>
                              <td  title="Projecto" class="text-nowrap">
                                <a v-bind:href="`${request.solicitacao.project.route}`">
                                  {{ request.solicitacao.project.name }}
                                </a>
                              </td>
                              <td  title="Data de requisição">
                                {{ request.created_on }}
                              </td>
                              <td  title="Objectivo" class="text-wrap text-truncate width-400">
                              {{ request.solicitacao.objectivo }}
                              </td>
                              <td  title="Fase actual de aprovação">
                                {{ request.flow_description }}
                              </td>
                              <td  title="Categoria do usuario a aprovar" class="link-option">
                                {{ request.validator_category }}
                              </td>
                            </tr>
                          </template>
                          <tr v-if="myBudgetRequestProcesses.length === 0">
                            <td class="p-1 text-center bg-light" colspan="7">
                              {{ __("lang.label_no_data") || 'Nenhuma informação disponível' }}
                            </td>
                          </tr>
                      </table>
                    </div>
                  </div>
                </div>

              </div>
            </div>
            <!-- /Column 1 -->
          </div>
          <!-- row 3 -->

          <!-- row 2 -->
          
          <!-- /row 2 -->
        </div>

        <div class="col-md-4 col-lg-3 mb-3 pl-2 pr-0">
          <div class="card-block shadow-sm p-3 h-auto">
            <div class="title-card border-bottom">
              <h6>
                <a href="#" class="text-slate-800">
                  <span>Visão geral de tarefas</span>
                </a>
              </h6>
            </div>
            <div class="">
              <vue-c3 :handler="handler"></vue-c3>
            </div>

            <div class="d-flex" v-if="taskOverview">
              <div class="flex-grow-1 text-center p-2">
                <div
                  class="m-2 w-25 mr-auto ml-auto"
                  style="border-top: 3px solid #2d96ff"
                ></div>
                <h3 class="mb-0">{{ taskOverview.opened }}</h3>
                <div class="c3-legend-item text-black-50 fw-500">
                  Planificadas
                </div>
              </div>
              <div class="flex-grow-1 text-center p-2">
                <div
                  class="m-2 w-25 mr-auto ml-auto"
                  style="border-top: 3px solid #f3e144"
                ></div>
                <h3 class="mb-0">{{ taskOverview.in_progress }}</h3>
                <div class="c3-legend-item text-black-50 fw-500">
                  Em Curso
                </div>
              </div>
              <div class="flex-grow-1 text-center p-2">
                <div
                  class="m-2 w-25 mr-auto ml-auto"
                  style="border-top: 3px solid #00cb96"
                ></div>
                <h3 class="mb-0">{{ taskOverview.closed }}</h3>
                <div class="c3-legend-item text-black-50 fw-500">
                  Concluídas
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Folege --> 

        <div class="row mb-4">
          <!-- column My Tasks -->
          <div class="mb-2 ml-3 text-black-50">
            <h4>Aprovação do Plano de Actividades</h4>

          </div>
          <div class="col-md-12 mb-3">
            <div class="card-block shadow-sm p-3" style="min-height: 380px;">
              <div class="title-card bg-light p-2 mb-1 rounded">
                <div class="">
                  <h6 class="mb-0">
                    <a href="#ReportIssues" class="text-slate-800">
                      <i class="icon-stack3 text-slate-400"></i>
                      <span>Actividades por validar </span>
                    </a>
                  </h6>
                </div>
              </div>
               
              <div class="table-responsive">
                
                <table class="table table-sm table-hover table-striped border datatable-show-all">
                  <thead class="bg-slate-700">
                    <th class="text-center">-</th>
                    <th>Projecto</th>
                    <th >Actividade</th>
                    <th >Alocado Por</th>
                    <th >Data de cadastro</th>
                    <th >Deadline</th>
                    <!--<th class="text-right">Data de reporte</th>--> 
                  </thead>
                  <tbody>
                    <template v-if="tasksToReport.length > 0">
                      <tr v-for="(report, key) in tasksToReport" :key="key">
                          <td class="justify-content-center align-content-center d-flex">
                            <a :href="report.issue.route" class="btn btn-sm m-0 btn-light my_shadow border link-option">Aprovar</a>
                          </td>
                          <td  style="max-width: 220px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" :title="report.time_entrie">
                            {{ report.issue.project.name}}
                          </td>
                          <td style="max-width: 220px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ report.issue.subject }}
                          </td>
                          <td>
                            {{ report.request_by.full_name }}
                          </td>
                          <td>
                            {{ report.issue.start_date}}
                          </td>
                          <td>
                            {{ report.issue.due_date }}
                          </td>
                          <!-- <td>
                              {{ report.issue }}
                          </td>--> 
                      </tr>
                    </template>
                    <tr v-if="tasksToReport.length == 0">
                      <td class="p-1 text-center border-bottom cursor-default" colspan="8">
                        {{ __("lang.label_no_data") || 'Nenhuma informação disponível' }}
                      </td>
                    </tr>
                  </tbody>
                </table>

                <template v-if="isLoading">
                  <center>Carregando...</center>
                </template>
              </div>
            </div>
          </div>
          <!-- column My Tasks -->
        </div>
        <!-- Folege -->
      </div>
    </div>
    <div v-if="isLoadingData" id="loading-indicator">
        <i class="icon-spinner spinner"></i>
        <span>Carregando dados...</span>
    </div>
  </div>
</template>

<script lang="ts">
import Vue from "vue";
import axios from "axios";
import VueC3 from "vue-c3";

export default Vue.extend({
  components: {
    VueC3,
  },
  created() {
    this.initDashboard();
    this.isLoading = true;
  },
  data() {
    return {
      my_tasks: 0,
      assigned_tasks: 0,
      contribution_margin: 0,
      handler: new Vue(),
      taskCompletion: new Vue(),
      taskOverview: [],
      tasksToReport: [],
      recent_activities: [],
      assignedTasks: [],
      issuesToApprove: [],
      unapprovedBudgetRequest: [],
      myBudgetRequestProcesses: [],
      dashboard_endpoint: "/web/api/dashboard",
      isLoading: false,
      isLoadingData: false,
    };
  },
  mounted() {
    this.isLoading = true;
    const options = {
      data: {
        url: "/web/api/dashboard/datagraph",
        mimeType: "json",
        type: "donut",
        colors: {
          "Em Curso": "#f3e144",
          Planificadas: "#2d96ff",
          Concluídas: "#00cb96",
        },
        labels: false,
        // keys: {
        //     value: ['Abertas', 'Fechadas']
        // }
      },
      grid: {
        y: {
          show: false,
        },
      },
      transition: { duration: 1000 },
      legend: {
        show: false,
      },
    };
    this.handler.$emit("init", options);
    this.isLoading = false;
  },

  methods: {
    async initDashboard() {
      this.isLoadingData = true;
      await axios(this.dashboard_endpoint)
        .then((response) => {
          this.taskOverview = response.data.taskOverview;

          this.my_tasks = response.data.my_tasks;
          this.assigned_tasks = response.data.assigned_tasks;
          this.contribution_margin = response.data.contribution_margin;

          this.recent_activities = response.data.recent_activities;

          this.tasksToReport = response.data.tasksToReport;
          console.log(this.tasksToReport);

          this.assignedTasks = response.data.assignedTasks;
          this.issuesToApprove = response.data.issuesToApprove;


          this.myBudgetRequestProcesses = response.data.myBudgetRequestProcesses;
          this.isLoadingData = false;
        })
        .catch((error) => {
          this.isLoadingData = false;
          console.error("----- Error while loading dashboard data --------\n");
          console.error(error);
        });
    },

    async initDashboard_2() {},
  },

});
</script>

<style scoped>
</style>

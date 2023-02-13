<template>
  <div class>
    <div class="mt-2 border bg-white p-3">
      <div class="d-flex mb-2 border-bottom pb-2">
        <div class="flex-grow-1">
            <div class="flex-grow-1">
              <h5 class="fw-500 mb-2">Relatorio de Solicitação de Fundos</h5>
            </div>
          <div class="align-items-baseline">
            <div class="form-inline align-items-end">
              <div class="w-25 mb-2 mr-2">
                <h6 class="fw-600 m-0 text-muted">Linhas Estratégicas ({{ projects_pde.length }})</h6>
                <select
                  name
                  class="border p-1 w-100"
                  @change="onProjectParent($event)"
                  v-model="projectPDE"
                >
                  <option selected :value="[]">Selecione uma linha estratégica</option>
                  <option
                    v-for="(project, key) in projects_pde"
                    v-bind:key="key"
                    :value="project"
                  >{{ project.name }}</option>
                </select>
              </div>
              <div class="w-50 mb-2">
                <h6 class="fw-600 m-0 text-muted">Projectos ({{ projects.length }})</h6>
                <select
                  name
                  class="border p-1 w-100"
                  @change="getDataAprovementFlow(true)"
                  v-model="project"
                >
                  <option selected :value="[]">Selecione um projecto</option>
                  <option
                    v-for="(project, key) in projects"
                    v-bind:key="key"
                    :value="project"
                  >{{ project.name }}</option>
                </select>
              </div>
            </div>

            <div class="mt-2 form-inline align-items-end" style="font-size:95%">
              <div class="mb-2 mr-2">
                <div class="flex-grow-1 text-muted">Estado da ultima aprovação</div>
                <div class="form-inline">
                <div class="input-group">
                  <div class="pt-1 pl-2 pr-2">
                    <input type="radio" id="_approvement_status_pending"
                      value="pending"
                      name="_approvement_status"
                      aria-label="Radio button for following text input"
                      v-model="approvement_status"
                      @change="getDataAprovementFlow(project !== null)"
                      >
                  </div>
                  <label for="_approvement_status_pending">Pendente</label>
                </div>
                <div class="input-group">
                  <div class="pt-1 pl-2 pr-2">
                    <input type="radio" id="_approvement_status_valid"
                      value="validated"
                      name="_approvement_status"
                      aria-label="Radio button for following text input"
                      v-model="approvement_status"
                      @change="getDataAprovementFlow(project !== null)"
                      >
                  </div>
                  <label for="_approvement_status_valid" class="text-success">Aprovado</label>
                </div>
                </div>
              </div>

              <div class="mb-2 mr-2 ml-2">
                <div class="flex-grow-1 text-muted">Data Inicial:</div>
                <input type="date" name="start_date" v-model="start_date" class="form-control form-control-sm">
              </div>

              <div class="mb-2 mr-2 ml-2">
                <div class="flex-grow-1 text-muted">Data Final:</div>
                <input type="date" name="end_date" v-model="end_date" class="form-control form-control-sm">
              </div>

              <div class="mb-2 mr-2 ml-2">
                <div class="flex-grow-1 text-muted">Acção</div>

                <div class="btn-group btn-group-sm" role="group" aria-label="...">
                  <button class="btn btn-sm m-0 btn-success border" @click="getDataAprovementFlow(project !== null)">
                    <i class="icon-search4 text-white"></i>
                    Filtrar
                  </button>
                  <button class="btn btn-sm m-0 btn-light border" @click="limparFiltros()">
                    <i class="icon-reset"></i>
                    Limpar Filtro
                  </button>
                </div>
              </div>

            </div>
          </div>
        </div>
        <div class>
          <div class="d-flex align-items-baseline">
            <div class>
              <div class="btn-group btn-group-sm" role="group" aria-label="...">
                <button class="btn btn-sm m-0 btn-light border" @click="exportExcel()">
                  <i class="icon-file-excel text-success"></i>
                  Excel
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table border table-sm table-striped table-hover" style="font-size:95%">
          <thead class="table-active">
            <th>Cod. Requisicao</th>
            <th>Data</th>
            <th>Orçamento</th>
            <th class="text-nowrap">Solicitado por</th>
            <th class="text-nowrap" v-if="approvement_status === 'pending'">Por Validar</th>
            <th class="text-nowrap">Estado</th>
            <th class="text-nowrap" v-if="approvement_status === 'validated'">Data aprovação</th>
          </thead>
          <tbody>
            <template v-if="isApprovementFlowLoading">
              <tr>
                <td colspan="10" class="text-center fw-600">
                  <i class="icon-spinner spinner"></i> Carregando dados...
                </td>
              </tr>
            </template>
            <template v-if="approvementFlows.length > 0">
              <template v-for="(approvement, key) in approvementFlows">
                <tr v-bind:key="key">
                  <td class="pl-2 p-1 pr-2" v-bind:title="approvement.objectivo">
                    <a v-bind:href="`/projects/${approvement.project.identifier}/orcamento/new/solicitacao-fundos/requisicao/${approvement.num_requisicao}`">{{ approvement.num_requisicao }}</a>
                  </td>
                  <td class="pl-2 p-1 pr-2 text-nowrap">{{ approvement.created_on }}</td>
                  <td class="pl-2 p-1 pr-2 text-nowrap">{{ formatBudget(approvement.valor_estimado) }} MZN</td>
                  <td class="pl-2 p-1 pr-2">{{ `${approvement.request_by.firstname} ${approvement.request_by.lastname }`}}</td>

                  <td class="pl-2 p-1 pr-2" v-if="!approvement.latest_aprovement.is_approved">
                    {{ approvement.latest_aprovement.validator_category }}
                  </td>

                  <td v-if="approvement.latest_aprovement.is_approved">
                    <small class="bg-success p-1 rounded">Aprovado</small>
                  </td>
                  <td v-if="!approvement.latest_aprovement.is_approved">
                    <small class="bg-danger p-1 rounded">Pendente</small>
                  </td>

                  <td class="pl-2 p-1 pr-2" v-if="approvement.latest_aprovement.is_approved && approvement_status === 'validated'">{{ approvement.latest_aprovement.approved_on }}</td>
                </tr>
              </template>
            </template>
            <template v-if="approvementFlows.length === 0 && !isApprovementFlowLoading">
              <tr>
                <td
                  class="pl-2 p-1 pr-2 text-center fw-600"
                  colspan="10"
                >{{ 'Nenhuma informação disponível' }}</td>
              </tr>
            </template>
          </tbody>
        </table>
      </div>
    </div>

    <div v-if="isLoading" id="loading-indicator">
      <i class="icon-spinner spinner"></i>
      <span>Carregando...</span>
    </div>
  </div>
</template>

<script lang="ts">
import Vue from "vue";
import axios from "axios";
import VueC3 from "vue-c3";

export default {
  components: {
    VueC3
  },
  props: ["projects_pde"],

  mounted() {
    this.loadDataApi();
    this.getDataAprovementFlow();
  },

  beforeUpdate() {},

  data() {
    return {
      handler: new Vue(),
      issueApprovements: new Vue(),
      approvementFlows: [],
      year: new Date().getFullYear(),
      approvement_status: 'validated',
      start_date: null,
      end_date: null,
      isLoading: false,
      isApprovementFlowLoading: false,
      isError: false,
      projectPDE: [],
      project: null,
      projects: [],
      exportRoute: "export/actividades/approvement-flow/"
    };
  },

  methods: {
    /**
     * Limpar Filtros
     */
    limparFiltros() {
      this.start_date = null;
      this.end_date = null;
      this.approvement_status = 'validated';

      this.getDataAprovementFlow(this.project !== null)
    },

    formatBudget(value) {
      let val = (value / 1).toFixed(2).replace(".", ",");
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    },
    async loadDataApi() {
      this.isLoading = true;
      await axios
        .get("/reports/api/actividades/solicitacao/aprovacao")
        .then(response => {
          this.generateChart(response.data);
        })
        .catch(error => {
          console.error(error);
        })
        .finally(() => {
          this.isLoading = false;
        });
    },

    async onProjectParent() {
      this.isLoading = true;
      await axios
        .get(
          `/web/api/reports/activity/pde/${this.projectPDE.identifier}/projects`
        )
        .then(response => {
          this.projects = response.data.projects;
        })
        .catch(error => {
          alert(
            `Ocorreu um erro ao caregar os projetos 'filhos' da linha estratégica`
          );
          console.error({
            status: "Request failed",
            message:
              "Ocorreu um erro ao caregar os projetos 'filhos' da linha estratégica",
            error: error.message
          });
        })
        .then(() => {
          this.isLoading = false;
        });
    },

    async getDataAprovementFlow(setFilter = false) {
      this.isApprovementFlowLoading = true;
      this.isLoading = true;
      let project_identifier = null;
      if (this.project !== null && setFilter) {
        project_identifier = this.project.identifier;
      }
      if (this.project == null && setFilter) {
        alert(
          "Status: Query Params Error\nMessage: Por favor selecione um projecto!"
        );
        this.isLoading = false;
        this.isApprovementFlowLoading = false;
        return;
      }

      return await axios
        .get(
          `/web/api/reports/actividades/approvement-flow?setFilter=${setFilter}&project=${project_identifier}&year=${this.year}&start_date=${this.start_date}&end_date=${this.end_date}&status=${this.approvement_status}`
        )
        .then(response => {
          this.approvementFlows = response.data.approvementFlow;
        })
        .catch(error => {
          alert("Encontramos um error ao requisatar os dados do servidor.");
          this.isError = true;
          console.error({
            status: "Error",
            message: "Encontramos um error ao requisatar os dados do servidor",
            errorLog: error
          });
        })
        .finally(() => {
          this.isApprovementFlowLoading = false;
          this.isLoading = false;
        });
    },

    async exportExcel() {
      this.isApprovementFlowLoading = true;
      let project_identifier = null;
      if (this.project !== null) {
        project_identifier = this.project.identifier;
      }
      if (this.project == null) {
        alert(
          "Status: Query Params Error\nMessage: Por favor selecione um projecto!"
        );
        this.isLoading = false;
        this.isApprovementFlowLoading = false;
        return;
      }

      window.location.href = `/web/api/reports/export/actividades/approvement-flow?setFilter=${true}&project=${project_identifier}&year=${
        this.year
      }&start_date=${this.start_date}&end_date=${this.end_date}`;

      this.isLoading = false;
      this.isApprovementFlowLoading = false;
    }
  }
};
</script>

<style scoped>
circle {
  stroke: black;
  stroke-width: 1px;
  fill: white !important;
}
</style>

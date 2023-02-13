<template>
  <div class="mb-0">
    <div class="bg-white border border-bottom-0">
      <div class="d-flex align-items-baseline p-3">
        <div class="flex-grow-1 form-inline">
          <div class>
            <h6 class="fw-600 m-0 text-muted">
              Planos Estratégicos ({{ projects.length }})
            </h6>
            <select
              name
              class="border p-1"
              @change="onProjectSelect($event)"
              v-model="selected_project"
            >
              <option selected :value="[]">
                Selecione um plano estratégico
              </option>
              <option
                v-for="(project, key) in projects"
                v-bind:key="key"
                :value="project"
              >
                {{ project.name }}
              </option>
            </select>
          </div>
          <div class="ml-2">
            <h6 class="fw-600 m-0 text-muted">Ano (Financeiro)</h6>
            <select
              name=""
              class="border p-1"
              v-model="year"
              @change="onProjectRepYear($event)"
            >
              <option :value="null">Anos</option>
              <option
                v-for="(_year, key) in years"
                v-bind:key="key"
                :value="_year"
              >
                {{ _year }}
              </option>
            </select>
          </div>
        </div>
        <div class>
          <div class="btn-group btn-group-sm" role="group" aria-label="...">
            <a
              href="#"
              class="btn btn-sm m-0"
              v-bind:class="{
                'btn-success': isActiveLinhaEstrategico,
                'btn-light': !isActiveLinhaEstrategico,
              }"
              @click="selectData('isActiveLinhaEstrategico')"
              >Por Linha Estratégica</a
            >
            <button
              class="btn btn-sm m-0 border"
              v-bind:class="{
                'btn-success': isActiveProjectos,
                'btn-light': !isActiveProjectos,
              }"
              @click="selectData('isActiveProjectos')"
            >
              Por Projectos
            </button>
          </div>
        </div>
      </div>
      <hr class="mt-0 mb-0 mr-3 ml-3" />
    </div>
    <div class="bg-white border border-top-0 p-3">
      <div class="d-flex align-items-baseline">
        <div class="flex-grow-1">
          <h5 class="fw-600">
            Relatório Financeiro
            <span class="text-black-50" v-if="selected_project !== []">
              -
              <a href="#">{{ selected_project.name || null }}</a>
            </span>
          </h5>
        </div>
        <div class>
          <div class="btn-group btn-group-sm" role="group" aria-label="...">
            <a
              v-if="selected_project != null"
              v-bind:href="`/reports/api/export/report/${selected_project.identifier}?type=${requestDataType}`"
              class="btn btn-sm m-0 btn-dark"
            >
              <i class="icon-file-excel"></i>
              Excel
            </a>
            <button class="btn btn-sm m-0 btn-light border">Imprimir</button>
          </div>
        </div>
      </div>
      <div class="grath-data">
        <div class="graf-title">
          <p
            style="
              cursor: default;
              color: rgb(117, 117, 117);
              user-select: none;
              -webkit-font-smoothing: antialiased;
              font-size: 16px;
              margin-top: -8px;
            "
          >
            Gráfico de Barras - Relatório de Orçamento
          </p>
          <p
            style="
              margin-top: -18px;
              color: rgb(189, 189, 189);
              cursor: default;
              user-select: none;
              -webkit-font-smoothing: antialiased;
              font-size: 14px;
            "
            class="ng-scope ng-binding"
          >
            {{ selected_project.name || null }}
          </p>
        </div>
        <div class="grapth" style="min-height: 50vh">
          <template v-if="isActiveProjectos" v-bind:name="isActiveProjectos">
            <vue-c3 :handler="relFinProjectos"></vue-c3>

            <div class="mt-3 mb-2">
              <div class="d-flex">
                <div
                  class="flex-grow-1 text-center p-2"
                  title="Orçamento do Projecto"
                >
                  <div
                    class="m-2 w-25 mr-auto ml-auto"
                    style="border-top: 3px solid #3366cc"
                  ></div>
                  <div class="c3-legend-item text-black-50 fw-500">
                    Orçamento do Projecto
                  </div>
                </div>
                <div class="flex-grow-1 text-center p-2" title="Valor Gasto">
                  <div
                    class="m-2 w-25 mr-auto ml-auto"
                    style="border-top: 3px solid #d93025"
                  ></div>
                  <div class="c3-legend-item text-black-50 fw-500">
                    Valor Gasto
                  </div>
                </div>
              </div>
            </div>
          </template>

          <template
            v-if="isActiveLinhaEstrategico"
            v-bind:name="isActiveLinhaEstrategico"
          >
            <vue-c3 :handler="relFinProjectos"></vue-c3>

            <div class="mt-3 mb-2">
              <div class="d-flex">
                <div
                  class="flex-grow-1 text-center p-2"
                  title="Orçamento do Projecto"
                >
                  <div
                    class="m-2 w-25 mr-auto ml-auto"
                    style="border-top: 3px solid #f3e000"
                  ></div>
                  <div class="c3-legend-item text-black-50 fw-500">
                    Orçamento Linha.E
                  </div>
                </div>
                <div
                  class="flex-grow-1 text-center p-2"
                  title="Orçamento do Projecto"
                >
                  <div
                    class="m-2 w-25 mr-auto ml-auto"
                    style="border-top: 3px solid #3366cc"
                  ></div>
                  <div class="c3-legend-item text-black-50 fw-500">
                    Orçamento de Projectos
                  </div>
                </div>
                <div class="flex-grow-1 text-center p-2" title="Valor Gasto">
                  <div
                    class="m-2 w-25 mr-auto ml-auto"
                    style="border-top: 3px solid #d93025"
                  ></div>
                  <div class="c3-legend-item text-black-50 fw-500">
                    Valor Gasto de Projectos
                  </div>
                </div>
              </div>
            </div>
          </template>
        </div>
        <div class="table-responsive">
          <template v-if="isActiveProjectos">
            <table
              class="finances table table-sm table-stripeds border table-hover"
            >
              <thead class="table-active">
                <th>Linha Estratégica/Projecto</th>
                <th>(+) Orçamento</th>
                <th>(-) Valor Gasto</th>
              </thead>

              <tbody>
                <template v-for="project in dataTable">
                  <tr v-bind:key="project.id">
                    <td
                      class="fw-600 text-nowrap bg-light border-top"
                      colspan="3"
                    >
                      {{ project.name }}
                    </td>
                  </tr>
                  <template v-if="project.childs.length > 0">
                    <tr
                      class="td-int-1 child"
                      v-for="child in project.childs"
                      v-bind:key="child.id"
                    >
                      <td class="td-int-1 child p-0 pr-2 pl-4 child">
                        <a :href="child.route" class="link-option">{{
                          child.name
                        }}</a>
                      </td>
                      <td class="p-1 pr-2 pl-2 text-nowrap text-black">
                        {{ formatBudget(child.orcamento_inicial) }} MZN
                      </td>
                      <td class="p-1 pr-2 pl-2 text-nowrap text-black">
                        {{ formatBudget(child.orcamento_gasto) }} MZN
                      </td>
                    </tr>
                  </template>
                </template>
                <template v-if="dataTable.length == 0">
                  <tr>
                    <td colspan="3" class="text-center">
                      {{ __("lang.label_no_data") }}
                    </td>
                  </tr>
                </template>
              </tbody>
            </table>
          </template>

          <template v-if="isActiveLinhaEstrategico">
            <table
              class="finances table table-sm table-stripeds border table-hover"
            >
              <thead class="table-active">
                <th>Linha Estratégica</th>
                <th>Orçamento</th>
                <th>Despesas Realizadas</th>
                <th>Saldo</th>
                <th>%</th>
              </thead>

              <tbody>
                <template v-for="project in dataTable">
                  <tr v-bind:key="project.id">
                    <td class="fw-600 text-nowrap bg-light border-top">
                      {{ project.name }}
                    </td>
                    <td class="fw-600 text-nowrap bg-light border-top">
                      {{ formatBudget(project.orcamento_inicial_sub_project) }}
                      MZN
                    </td>
                    <td class="fw-600 text-nowrap bg-light border-top">
                      {{ formatBudget(project.orcamento_gasto_sub_project) }}
                      MZN
                    </td>
                    <td class="fw-600 text-nowrap bg-light border-top">
                      {{
                        formatBudget(
                          project.orcamento_inicial_sub_project -
                            project.orcamento_gasto_sub_project
                        )
                      }}
                      MZN
                    </td>
                    <td class="fw-600 text-nowrap bg-light border-top">
                      {{
                        formatBudget(
                          (project.orcamento_gasto_sub_project /
                            project.orcamento_inicial_sub_project) *
                            100
                        )
                      }}
                      %
                    </td>
                  </tr>
                </template>
                <template v-if="dataTable.length == 0">
                  <tr>
                    <td colspan="5" class="text-center">
                      {{ __("lang.label_no_data") }}
                    </td>
                  </tr>
                </template>
              </tbody>
            </table>
          </template>
        </div>
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
    VueC3,
  },
  props: ["route_api", "projects"],
  data() {
    return {
      isActiveLinhaEstrategico: true,
      isActiveProjectos: false,
      requestDataType: "linha-estrategica",
      selected_project: [],
      project: null,
      year: null,
      years: [],
      dataTable: [],
      dataGraph: [],
      handler: new Vue(),
      isLoading: false,
      relFinProjectos: new Vue(),
      colorPattern: ["#3366cc", "#d93025"],
    };
  },

  mounted() {
    this.ini_graph_load();
    this.selected_project = this.projects[0];
    this.onProjectSelect(event);
  },

  methods: {
    formatBudget(value) {
      let val = (value / 1).toFixed(2).replace(".", ",");
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    },
    /**
     * Toggle -
     */
    selectData(dataSource) {
      if (dataSource == "isActiveLinhaEstrategico") {
        (this.colorPattern = ["#f3e000", "#3366cc", "#d93025"]),
          (this.isActiveProjectos = false);
        this.requestDataType = "linha-estrategica";
        this.onProjectSelect();
        return (this.isActiveLinhaEstrategico = true);
      } else {
        this.isActiveProjectos = true;
        this.requestDataType = "projects";
        this.colorPattern = ["#3366cc", "#d93025"];
        this.onProjectSelect();
        return (this.isActiveLinhaEstrategico = false);
      }
    },

    // On Porject is Selected
    async onProjectSelect(event) {
      if (this.selected_project.length !== 0) {
        this.isLoading = true;
        await axios
          .get(
            "/reports/api/orcamento/pde/" +
              this.selected_project.identifier +
              "?type=" +
              this.requestDataType
          )
          .then((response) => {
            this.dataTable = response.data.dataTable;
            this.dataGraph = response.data.dataGraph;
            this.years = response.data.years;
            // this.project = this.selected_project;
            this.ini_graph_load();
          })
          .catch((error) => {
            console.log(error);
          })
          .finally(() => {
            this.isLoading = false;
          });
      }
    },

    async onProjectRepYear(event) {
      if (this.year !== null) {
        this.isLoading = true;
        await axios
          .get(
            `/reports/api/orcamento/pde/${this.selected_project.identifier}?type=${this.requestDataType}&getByYear=1&year=${this.year}`
          )
          .then((response) => {
            this.dataTable = response.data.dataTable;
            this.dataGraph = response.data.dataGraph;
            this.years = response.data.years;
            // this.project = this.selected_project;
            this.ini_graph_load();
          })
          .catch((error) => {
            console.log(error);
          })
          .finally(() => {
            this.isLoading = false;
          });
      }
    },

    // Load data and ini graph
    ini_graph_load() {
      const options = {
        data: {
          json: this.dataGraph.data,
          type: "bar",
          keys: {
            x: this.dataGraph.dataGraph_x,
            value: this.dataGraph.dataGraph_x_value,
          },
        },
        color: {
          pattern: this.colorPattern,
        },
        axis: {
          x: {
            type: "category",
            x: ["key"],
          },
        },
        bar: {
          width: {
            ratio: 0.35, // this makes bar width 50% of length between ticks
          },
        },
        tooltip: {
          format: {
            value: function (value, ratio, id, index) {
              return value.toLocaleString("en") + " MZN";
            },
          },
        },
        transition: { duration: 1000 },
        legend: {
          show: false,
        },
      };
      this.relFinProjectos.$emit("init", options);
    },
  },
};
</script>

<style scoped></style>

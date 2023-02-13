<template>
  <div class="mb-0">
    <div class="bg-white border p-3">
      <div class="d-flex align-items-baseline">
        <div class="flex-grow-1">
          <h5 class="fw-600 text-muted">
            RELATÓRIO DE PREVISÃO ORÇAMENTAL
          </h5>
        </div>
        <div class>
          <div class="btn-group btn-group-sm" role="group" aria-label="...">
            <a
              v-bind:href="``"
              class="btn btn-sm m-0 btn-success"
            >
              <i class="icon-file-excel"></i>
              Export Excel
            </a>
          </div>
        </div>
      </div>

      <div class="bg-white mt-2">
            <div class="align-items-baseline">
                <div class="form-inline align-items-end">
                    <div class="mr-2">
                        <h6 class="fw-600 m-0 text-muted">Plano Estratégico</h6>
                        <select
                            name=""
                            class="border pl-2 pr-2 p-1 mb-2"
                            v-model="plano_estrategico"
                        >
                            <template v-for="(plano, key) in reportData.planosEstrategicos">
                                <option v-bind:key="key" v-bind:value="plano.identifier">{{ plano.name }}</option>
                            </template>
                        </select>
                    </div>
                    <div class="mr-2">
                        <h6 class="fw-600 m-0 text-muted">Ano</h6>
                        <select
                            name=""
                            class="border pl-2 pr-2 p-1 mb-2"
                            v-model="year"
                        >
                            <option :value="null">Ano</option>
                            <option :value="2020">2020</option>
                        </select>
                    </div>
                    <div class="mr-2 mb-2">
                        <button
                            class="btn pt-1 pb-1 btn-success rounded-0 fw-600 shadow-sm"
                            @click="
                                filterReportDate(year, start_date, end_date)
                            "
                        >
                            Pesquisar
                        </button>
                    </div>
                </div>
            </div>
            <hr class="mt-0 mb-0" />
        </div>

      <div class="table-responsive">
        <table class="table table-sm table-striped table-bordered table-hover cursor-pointer" style="font-size:92%">
          <thead>

            <tr>
                <th colspan="2"></th>
                <th colspan="3" class="text-center bg-success">Orçamento Previsto 2021</th>
                <th colspan="2" class="text-center">Prazo de Execução do Projecto</th>
            </tr>
            <th>#</th>
            <th>Projecto/Programa</th>
            <th class="text-nowrap">1) Orçamento Anual 2021</th>
            <th class="text-nowrap">2) Despesas Previstas 2021</th>
            <th class="text-nowrap">Saldo Orçamental (1-2 Prev)</th>
            <th>Inicio</th>
            <th>Fim</th>
          </thead>
          <tbody>
              <template v-for="(project, key) in reportData.projects">
                <tr v-bind:key="key">
                    <td>{{ ++key }}</td>
                    <td>
                        <a :href="project.route">{{ project.name }}</a>
                    </td>
                    <td class="text-nowrap">{{ formatBudget(project.orcamento_inicial) }}</td>
                    <td class="text-nowrap">{{ formatBudget(project.issues_valor_prev, 'MZN') }}</td>
                    <td class="text-nowrap">{{ formatBudget((project.orcamento_inicial - project.issues_valor_prev), "MZN") }}</td>
                    <td>{{ project.start_date }}</td>
                    <td>{{ project.due_date }}</td>
                </tr>
              </template>
              <tr colspan="2" class="bg-success">
                  <td>#</td>
                  <td colspan="1" class="text-right fw-600">Total</td>
                  <td class="fw-600 text-nowrap">{{ formatBudget(reportData.total_orcamento_inicial) }}</td>
                  <td class="fw-600 text-nowrap">{{ formatBudget(reportData.total_orcamento_gasto) }}</td>
                  <td class="fw-600 text-nowrap">{{ 'NaN MZN' }}</td>
                  <td>-</td>
                  <td>-</td>
              </tr>
          </tbody>
        </table>
      </div>

      <div class="d-flex align-items-baseline mt-3 mr-1">
        <div class="flex-grow-1"></div>
        <div class>
          <div class="btn-group btn-group-sm" role="group" aria-label="...">
            <a
              v-bind:href="``"
              class="btn btn-sm m-0 btn-success"
            >
              <i class="icon-file-excel"></i>
              Export Excel
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    props: ['report-data'],
    data(){
        return {
            _reportData: this.reportData || [],
            year: new Date().getFullYear(),
            start_date: null,
            due_date: null,
            end_date: null,
            plano_estrategico: this.reportData.planosEstrategicos[0].identifier || ''
        }
    },
    mounted() {
    },
    methods: {
        formatBudget(value, currency = "MZN") {
            if(value === undefined | NaN){
                }
            let val = (value / 1).toFixed(2).replace(".", ",");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ` ${currency}`;
        },

        async getReportDataByYear(){
            // return report filter by year
        }
    }
};
</script>

<style>
</style>

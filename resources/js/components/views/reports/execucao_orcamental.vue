<template>
  <div class="mb-0">
    <div class="bg-white border p-3">
      <div class="d-flex align-items-baseline">
        <div class="flex-grow-1">
          <h5 class="fw-600">
            RELATÓRIO DE EXECUÇÃO ORÇAMENTAL
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

      <div class="table-responsive mt-3">
        <table class="table table-sm table-striped table-bordered table-hover cursor-pointer" style="font-size:92%">
          <thead>

            <tr>
                <th colspan="3"></th>
                <th colspan="4" class="text-center">Orçamento Previsto</th>
                <th colspan="2" class="text-center">Prazo de Execução do Projecto</th>
            </tr>
            <tr>

            </tr>

            <th>#</th>
            <th>Doardor</th>
            <th>Projecto/Programa</th>
            <th>1) Orçamento Anual</th>
            <th>2) Despesas</th>
            <th>3) Saldo Orçamental (1-2)</th>
            <th>% Orçamento Executado (2/1)</th>
            <th>Inicio</th>
            <th>Fim</th>
          </thead>
          <tbody>
              <template v-for="(project, key) in reportData.projects">
                <tr v-bind:key="key">
                    <td>{{ ++key }}</td>
                    <td>Undefined</td>
                    <td>
                        <a :href="project.route">{{ project.name }}</a>
                    </td>
                    <td>{{ formatBudget(project.orcamento_inicial) }}</td>
                    <td>
                        <a href="#">
                            {{ formatBudget(project.orcamento_gasto) }}
                        </a>
                    </td>
                    <td>{{ formatBudget(project.orcamento_inicial - project.orcamento_gasto) }}</td>
                    <td>{{ formatBudget(((project.orcamento_gasto / project.orcamento_inicial) * 100), '%') }}</td>
                    <td>{{ project.start_date }}</td>
                    <td>{{ project.due_date }}</td>
                </tr>
              </template>
              <tr colspan="2" class="bg-success">
                  <td>#</td>
                  <td colspan="2" class="text-right fw-600">Total</td>
                  <td class="fw-600">{{ formatBudget(reportData.total_orcamento_inicial) }}</td>
                  <td class="fw-600">{{ formatBudget(reportData.total_orcamento_gasto) }}</td>
                  <td class="fw-600">{{ formatBudget(reportData.total_orcamento_inicial - reportData.total_orcamento_gasto) }}</td>
                  <td class="fw-600">{{ formatBudget(((reportData.total_orcamento_gasto / reportData.total_orcamento_inicial) * 100), '%') }}</td>
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
        }
    },
    mounted() {
    },
    methods: {
        formatBudget(value, currency = "MZN") {
            if(value === undefined | NaN){
                }
                console.log(value == 'NaN', currency)
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

<template>
    <div class="mb-0">
        <div class="bg-white border border-bottom-0">
            <div class="align-items-baseline p-3">
                <div class="form-inline align-items-end">
                    <div class="w-25">
                        <h6 class="fw-600 m-0 text-muted">
                            Planos Estratégicos ({{ projects.length }})
                        </h6>
                        <select
                            name=""
                            class="border p-1 w-100"
                            @change="onProjectSelect($event)"
                            v-model="selected_project"
                        >
                            <option selected :value="[]"
                                >Selecione um plano estratégico</option
                            >
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
                         <h6 class="fw-600 m-0 text-muted">
                            Pilares ({{ pilares.length }})
                        </h6>
                        <select
                            name=""
                            class="border p-1 w-100"
                            @change="onProjectPilarSelect($event)"
                            v-model="selected_project_pilar"
                        >
                            <option selected :value="[]"
                                >Selecione um Pilar</option
                            >
                            <option
                                v-for="(pilar, key) in pilares"
                                v-bind:key="key"
                                :value="pilar"
                            >
                                {{ pilar.name }}
                            </option>
                        </select>
                    </div>
                    <div class="ml-2">
                         <h6 class="fw-600 m-0 text-muted">
                            Projectos ({{ projectos.length }})
                        </h6>
                        <select
                            name=""
                            class="border p-1 w-100"
                            @change="onProject($event)"
                            v-model="selected_projectos"
                        >
                            <option selected :value="[]"
                                >Selecione um projecto</option
                            >
                            <option
                                v-for="(projecto, key) in projectos"
                                v-bind:key="key"
                                :value="projecto"
                            >
                                {{ projecto.name }}
                            </option>
                        </select>
                    </div>

                    <!--
                    <div class="ml-2 d-none">
                        <h6 class="fw-600 m-0 text-muted">Data de Inicio</h6>
                        <input
                            type="date"
                            class="border pl-2 p-1"
                            style="font-size:90%"
                        />
                    </div>
                    <div class="ml-2 mr-2 d-none">
                        <h6 class="fw-600 m-0 text-muted">Data de Fim</h6>
                        <input
                            type="date"
                            class="border pl-2 p-1"
                            style="font-size:90%"
                        />
                    </div>
                    <div class="mr-2 d-none">
                        <button
                            class="btn pt-1 pb-1 btn-success rounded-0 fw-600 shadow-sm"
                        >
                            Pesquisar
                        </button>
                    </div>
                    -->
                </div>
                <div class="mt-2 form-inline align-items-end" style="font-size:95%">
            <!--
              <div class="mb-2 mr-2">
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
            -->
            </div>
            </div>
            <hr class="mt-0 mb-0 mr-3 ml-3" />
        </div>
        <div class="bg-white border border-top-0 p-3">
            <div class="d-flex align-items-baseline">
                <div class="flex-grow-1">
                    <h5 class="fw-600">Relatório geral de realização</h5>
                </div>
                <div class="d-flex align-items">
                    <div
                        class="btn-group btn-group-sm d-none"
                        role="group"
                        aria-label="..."
                    >
                        <a href="#" class="btn btn-sm m-0 btn-dark">
                            <i class="icon-file-excel"></i>
                            Excel
                        </a>
                        <button class="btn btn-sm m-0 btn-light border">
                            Imprimir
                        </button>
                    </div>
                    <div style="font-size:95%" class="mt-1 mr-2">
                        <label for="" class="mb-0">Tamanho: {{ viewSize }} %</label>
                        <input type="range" name="range" id="table-font-size" style="width:100px" class="align-middle" :min="50" v-model="viewSize">
                    </div>
                    <div class="btn-group btn-group-sm" role="group" aria-label="...">
                        <a
                        v-bind:href="`/reports/api/exportGI/report/${this.selected_project_pilar.identifier}?type=${requestDataType}`"
                        class="btn btn-sm m-0 btn-success"
                        >
                        <i class="icon-file-excel"></i>
                        Export Excel
                        </a>
                    </div>

                </div>
            </div>
            <div class="table-responsive mt-2">
                <table class="table table-sm table-striped table-hover table-bordered" v-bind:style="`font-size:${viewSize}%`">
                    <thead class="table-activez">
                        <tr>
                            <th colspan="2">Pilar:</th>
                            <th colspan="17" v-if="selected_project_pilar.name">
                                <a v-bind:href="selected_project_pilar.route">{{ selected_project_pilar.name }}</a>
                            </th>
                            <th colspan="17" v-if="selected_project_pilar.length === 0">
                                Selecione um projecto e um prilar
                            </th>
                        </tr>
                        <tr>
                            <th colspan="2">OBJECTIVO ESTRATÉGICO:</th>

                            <th colspan="17" v-if="selected_project_pilar.name">
                                {{ selected_projectos.identifier }}
                            </th>
                            <th colspan="17" v-if="selected_project_pilar.length === 0">
                                Selecione um projecto e um prilar
                            </th>
                        </tr>
                        <tr>
                            <th colspan="2">RESULTADO:</th>
                            <th colspan="17" v-if="selected_project_pilar.name">
                                {{ selected_project_pilar.resultado }}
                            </th>
                            <th colspan="17" v-if="selected_project_pilar.length === 0">
                                Selecione um projecto e um prilar
                            </th>
                        </tr>
                        <tr class='bg-slate-700'>
                            <th class="text-nowrap" rowspan="2">Nº Ordem</th>
                            <th rowspan="2">Resultado (Output)</th>
                            <th class="text-nowrap" rowspan="2">Actividade (Grande Actividade)</th>
                            <th rowspan="2">Indicador</th>
                            <th class="text-nowrap" rowspan="2">Meta Anual</th>
                            <th class="text-nowrap" colspan="4">Meta Trimestral</th>
                            <th rowspan="2">Meta Realizada</th>
                            <th rowspan="2">Grau de Realização (%)</th>
                            <th rowspan="2">Local de realização</th>
                            <th class="text-nowrap" colspan="3">Benificiário</th>
                            <th rowspan="2">Orçamento (MT)</th>
                            <th rowspan="2">Orçamento Executado (MT)</th>
                            <th rowspan="2">Grau de Realização (%)</th>
                            <th rowspan="2">Projecto Responsável</th>
                        </tr>
                        <tr>
                            <th>I</th>
                            <th>II</th>
                            <th>III</th>
                            <th>IV</th>
                            <th>H</th>
                            <th>M</th>
                            <th>Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        <template v-for="(data, key) in reportsData">
                            <tr v-bind:key="key">
                                <td class="p-2 pl-2 pr-2 text-capitalize">
                                    {{ ++key }}
                                </td>
                                <td class="p-2 pl-2 pr-2" style="min-width: 180px;">
                                    <a v-bind:href="'#'">
                                        {{ data.result ? data.result.subject : null }}
                                    </a>
                                </td>
                                <td class="p-2 pl-2 pr-2">
                                    <a v-bind:href="data.issue.route">
                                        {{ data.issue.subject }}
                                    </a>
                                </td>
                                <td class="p-2 pl-2 pr-2"  style="min-width: 180px;">
                                    <ul>
                                        <template v-for="(indicador, key) in data.indicadores">
                                            <li v-bind:key="key">
                                                {{ indicador.indicator_field.name }}
                                            </li>
                                        </template>
                                    </ul>
                                </td>
                                <td class="p-2 pl-2 pr-2">
                                   <ul>
                                        <template v-for="(indicador, key) in data.indicadores">
                                            <li v-bind:key="key">
                                                {{ indicador.indicator_field.indicator_issue_values.meta || 0}}
                                            </li>
                                        </template>
                                    </ul>
                                </td>
                                <td class="p-2 pl-2 pr-2">
                                    <ul>
                                        <template v-for="(indicador, key) in data.indicadores">
                                            <li v-bind:key="key">
                                                {{ indicador.indicator_field.indicator_issue_values.m_trim_01 || 0}}
                                            </li>
                                        </template>
                                    </ul>
                                </td>
                                <td class="p-2 pl-2 pr-2">
                                    <ul>
                                        <template v-for="(indicador, key) in data.indicadores">
                                            <li v-bind:key="key">
                                                {{ indicador.indicator_field.indicator_issue_values.m_trim_02 || 0 }}
                                            </li>
                                        </template>
                                    </ul>
                                </td>
                                <td class="p-2 pl-2 pr-2">
                                    <ul>
                                        <template v-for="(indicador, key) in data.indicadores">
                                            <li v-bind:key="key">
                                                {{ indicador.indicator_field.indicator_issue_values.m_trim_03 || 0 }}
                                            </li>
                                        </template>
                                    </ul>
                                </td>
                                <td class="p-2 pl-2 pr-2">
                                    <ul>
                                        <template v-for="(indicador, key) in data.indicadores">
                                            <li v-bind:key="key">
                                                {{ indicador.indicator_field.indicator_issue_values.m_trim_04 || 0 }}
                                            </li>
                                        </template>
                                    </ul>
                                </td>
                                <td class="p-2 pl-2 pr-2">
                                    {{ data.meta_realizada }}
                                </td>
                                <td class="p-2 pl-2 pr-2">
                                    {{ data.grao_realizacao }}
                                </td>
                                <td class="p-2 pl-2 pr-2 text-nowrap">
                                    {{ data.local_realizacao }}
                                </td>
                                <td class="p-2 pl-2 pr-2">
                                    {{ data.beneficiarios._homens.meta }}
                                </td>
                                <td class="p-2 pl-2 pr-2">
                                    {{ data.beneficiarios._mulheres.meta }}
                                </td>
                                <td class="p-2 pl-2 pr-2">
                                    {{ data.beneficiarios._total.meta }}
                                </td>
                                <td class="p-2 pl-2 pr-2">
                                    {{ data.beneficiarios.orcamento }}
                                </td>
                                <td class="p-2 pl-2 pr-2">
                                    {{ data.beneficiarios.orcamento_exec }}
                                </td>
                                <td class="p-2 pl-2 pr-2">
                                    0
                                </td>
                                <td class="p-2 pl-2 pr-2 text-nowrap">
                                    <a v-bind:href="data.project.route">
                                        {{ data.project.name }}
                                    </a>
                                </td>
                            </tr>
                        </template>
                        <template v-if="reportsData.length == 0">
                            <tr>
                                <td colspan="19" class="text-center">
                                    {{ "Nenhuma informação disponível" }}
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>


            <div class="mt-2 mb-2">
                <div class="form-group" style="font-size:95%">
                    <label for="">Tamanho: {{ viewSize }} %</label>
                    <input type="range" name="range" id="table-font-size" style="width:100px" class="align-middle" :min="50" v-model="viewSize">
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
        VueC3
    },
    props: ["projects"],
    data() {
        return {
            selected_project: [],
            selected_project_pilar: [],
            selected_projectos: [],
            project: null,
            project_pilar: null,
            year: null,
            pilares: [],
            projectos: [],
            reportsData: [],
            viewSize: 90,


            isLoading: false,
            requestError: false
        };
    },

    mounted() {},

    methods: {
        /**
         * On Project Select
         */
        async onProjectPilarSelect(event){
            if(this.selected_project_pilar.length !== 0){

                this.isLoading = true;
                this.requestError = false;

                await axios
                    .get(`/web/api/reports/general_issues_report/${this.selected_project_pilar.identifier}`)
                    .then(response => {
                        this.reportsData = response.data;
                    })
                    .catch(error => {
                        this.isLoading = false;
                        this.requestError = true;
                })


                await axios
                    .get(
                        `/web/api/reports/general_issues/${this.selected_project_pilar.identifier}`
                    )
                    .then(response => {
                        this.projectos = response.data;
                    })
                    .catch(error => {
                        console.log(error);
                    })
                    .finally(() =>{
                    this.isLoading = false;
                })
            }
        },
        // On Porject is Selected
        async onProjectSelect(event) {
            if (this.selected_project.length !== 0) {
                this.isLoading = true;
                await axios
                    .get(
                        `/web/api/projects/${this.selected_project.identifier}?type=programs`
                    )
                    .then(response => {
                        this.pilares = response.data;
                    })
                    .catch(error => {
                        console.log(error);
                    })
                    .finally(() => {
                        this.isLoading = false;
                    });
            }
        },

        async onProject(event) {
            if (this.selected_projectos.length !== 0) {
                this.isLoading = true;
                this.requestError = false;
                await axios
                    .get(
                        `/web/api/reports/general_issues_report/${this.selected_projectos.identifier}`
                    )
                    .then(response => {
                        this.report = response.data;
                    })
                    .catch(error => {
                        console.log(error);
                    })
                    .finally(() => {
                        this.isLoading = false;
                    });
            }
        }


    }
};
</script>

<style scoped></style>

<template>
    <div class="bg-white border p-3">
        <div class="d-flex h-100">
            <div class="flex-grow-1">
                <div class="d-flex align-items-baseline">
                    <div class="flex-grow-1">
                        <h5 class="fw-500 mb-0">
                            Atividades por Pronvícias
                        </h5>
                    </div>
                    <div class="">
                        <div class="btn-group btn-group-sm" role="group" aria-label="...">
                            <a href="#" class="btn btn-sm m-0 btn-secondary">
                                <i class="icon-file-excel"></i>
                                Excel
                            </a>
                            <button class="btn btn-sm m-0 btn-light border">
                                Imprimir
                            </button>
                        </div>
                    </div>
                </div>
                <div class="grath-data">
                    <div class="graf-title">
                        <p style="cursor: default; color:rgb(117, 117, 117) ; user-select: none;-webkit-font-smoothing: antialiased; font-size: 12px;">
                            Gráfico de Barras - Projectos vs Actividades
                        </p>
                        <p ng-controller="orc_pdeController" style=" margin-top: -18px; color:rgb(189, 189, 189);; cursor: default; user-select: none;-webkit-font-smoothing: antialiased;font-size: 14px" class="ng-scope ng-binding">
                            <!-- {{ project.name || null}} -->
                        </p>
                    </div>
                    <div class="grapth" style="min-height: 50vh">
                        <vue-c3 :handler="relAtividadeProvincia"></vue-c3>

                        <div class="mt-3 mb-2 d-none">
                            <div class="d-flex">
                                <div class="flex-grow-1 text-center p-2" title="Orçamento do Projecto">
                                    <div class="m-2 w-25 mr-auto ml-auto" style="border-top: 3px solid #3366cc"></div>
                                    <div class="c3-legend-item text-black-50 fw-500">Orçamento do Projecto</div>
                                </div>
                                <div class="flex-grow-1 text-center p-2" title="Valor Gasto">
                                    <div class="m-2 w-25 mr-auto ml-auto" style="border-top: 3px solid #d93025"></div>
                                    <div class="c3-legend-item text-black-50 fw-500">Valor Gasto</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-left pl-2 ml-3" style="width:250px">
                <h5 class="border-bottom btn w-100 text-left fw-600 pl-1"><i class="icon-arrow-up5"></i>FILTROS</h5>
                <div class="_filters">
                    <div class="border-bottom w-100">
                        <div class="w-100 d-flex pl-1 btn rounded-0 btn-white text-left cursor-pointer" id="dropdownNotidications" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="flex-grow-1 text-muted">Periodo:</div>
                            <div class="">
                                {{ "Mensal" }}
                                <i class="icon-arrow-down12"></i>
                            </div>
                        </div>
                        <div class="dropdown-menu border my-shadow" aria-labelledby="dropdownNotidications">
                            <ul class="list-unstyled pb-0 mb-0" style="max-height: 300px; overflow-y:auto">
                                <li class="dropdown-item cursor-pointer">Mensal</li>
                                <li class="dropdown-item cursor-pointer">Semestral</li>
                                <li class="dropdown-item cursor-pointer">Anual</li>
                            </ul>
                        </div>
                    </div>
                    <div class="border-bottom w-100">
                        <div class="w-100 d-flex pl-1 btn rounded-0 btn-white text-left cursor-pointer" id="dropdownNotidications" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="flex-grow-1 text-muted">Ano:</div>
                            <div class="">
                                2020
                                <i class="icon-arrow-down12"></i>
                            </div>
                        </div>
                        <div class="dropdown-menu border my-shadow" aria-labelledby="dropdownNotidications">
                            <ul class="list-unstyled pb-0 mb-0" style="max-height: 300px; overflow-y:auto">
                                <li class="dropdown-item cursor-pointer">
                                    2020
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="border-bottom w-100">
                        <div class="w-100 d-flex pl-1 btn rounded-0 btn-white text-left cursor-pointer" id="dropdownNotidications" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="flex-grow-1 text-muted">Data Inicial:</div>
                            <div class="">
                                {{ start_date || "mm/dd/yyyy" }}
                                <i class="icon-arrow-down12"></i>
                            </div>
                        </div>
                        <div class="dropdown-menu border my-shadow p-2" aria-labelledby="dropdownNotidications">
                            <input type="date" class="form-control" v-model="start_date">
                            <li class="dropdown-item cursor-pointer text-center rounded bg-light mt-1">
                                Fechar
                            </li>
                        </div>
                    </div>
                    <div class="border-bottom w-100">
                        <div class="w-100 d-flex pl-1 btn rounded-0 btn-white text-left cursor-pointer" id="dropdownNotidications" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="flex-grow-1 text-muted">Data Final:</div>
                            <div class="">
                                {{ end_date || "mm/dd/yyyy" }}
                                <i class="icon-arrow-down12"></i>
                            </div>
                        </div>
                        <div class="dropdown-menu border my-shadow p-2" aria-labelledby="dropdownNotidications">
                            <input type="date" class="form-control" v-model="end_date">
                            <li class="dropdown-item cursor-pointer text-center rounded bg-light mt-1">
                                Fechar
                            </li>
                        </div>
                    </div>

                    <div class="w-100 mt-2">
                        <button class="w-100 rounded btn btn-dark border fw-700 btn-sm p-1 shadow-sm">Submeter</button>
                    </div>
                </div>
                <div class="m-3"></div>
                <h5 class="border-bottom btn w-100 text-left fw-600 pl-1"><i class="icon-arrow-up5"></i>FILTROS AVANCADOS</h5>
                <div class="_advanced_filters">
                    <!-- <label for="show_genero" class="form-check-inline pl-1 mb-0 pb-0">
                        <input type="radio" name="get_data_type" id="show_genero" value="1" checked="checked">
                        <span class="pl-1">Mostrar dados por genero</span>
                    </label>
                        <label for="show_faixa_etaria" class="form-check-inline pl-1 mb-0 pb-0">
                        <input type="radio" name="get_data_type" id="show_faixa_etaria">
                        <span class="pl-1">Mostrar dados por faixa etaria</span>
                    </label> -->
                    <small class="pl-1 text-center text-muted">Upcoming release</small>
                </div>
            </div>
        </div>

        <div class="mt-2" id="table-content-container">
            <div class="table-responsive">
                <table class="border finances table table-sm table-striped table-hover" style="font-size: 95%;">
                    <thead class="table-active">
                        <th class="fw-600">Actividade</th>
                        <th class="fw-600">Projecto</th>
                        <th class="fw-600">Província</th>
                        <th class="fw-600">Indicador</th>
                        <th class="fw-600">Meta</th>
                        <th class="fw-600">Realizado</th>
                    </thead>
                    <tbody>
                        <template v-for="(issue , key) in issues">
                            <tr v-bind:key="key">
                                <td class="fw-400" :title="`Actividade: ${issue.subject}`">
                                    <a :href="issue.route" class="link-option">
                                        {{ issue.subject }}
                                    </a>
                                </td>
                                <td class="fw-400" title="Projecto">
                                    <a :href="issue.project.route" class="link-option">
                                        {{ issue.project.name || null}}
                                    </a>
                                </td>
                                <td  class="p-0 pl-2 pr-2 text-nowrap fw-500" title="Província">
                                    {{ issue.provincia.value || 'undefined' }}
                                </td>
                                <td class="fw-400" title="Indicador">
                                    <template v-for="(indicador, key_2) in issue.indicators">
                                        <li v-bind:key="key_2">
                                            {{ indicador.indicator_field.name }}
                                        </li>
                                    </template>
                                </td>
                                <td class="p-0 pl-2 pr-2 text-nowrap fw-500" title="Meta">
                                    <template v-for="(indicador, key_3) in issue.indicators">
                                        <li v-bind:key="key_3">
                                            {{ indicador.indicator_field.indicator_issue_values.meta }}
                                        </li>
                                    </template>
                                </td>
                                <td  class="p-0 pl-2 pr-2 text-nowrap fw-500" title="Realizado">
                                    {{ 0 }}
                                </td>
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
    import Vue from 'vue'
    import axios from 'axios'
    import VueC3 from 'vue-c3'

    export default Vue.extend({
        components: {
            VueC3
        },
        props: [
            'issues'
        ],

        mounted() {
            this.processQueries();
        },

        data (){
            return {
                handler: new Vue(),
                relAtividadeProvincia: new Vue(),
                year: null,
                start_date: null,
                end_date: null,
                isLoading: false,
            }
        },
        methods: {
            async processQueries(){
                this.isLoading = true;
                await axios.get('/reports/api/actividades/provincia')
                    .then(response =>{
                        this.generate_graph(response.data)
                    })
                    .catch(error =>{
                        console.error(error)
                    })
                    .finally(()=>{
                        this.isLoading = false;
                    })
            },

            generate_graph(data){
                const options = {
                    data: {
                        json: data,
                        type: 'bar',
                        keys: {
                            x: 'provincia',
                            value: ['Aciviades']
                        },
                    },
                    color: {
                        pattern: ['#3366cc']
                    },
                    axis:{
                        x: {
                            type: 'category',
                            x:['key'],
                        },
                        y: {
                            tick: {
                                // format: d3.format(),
                                format: function (d) {
                                    return (parseInt(d) == d) ? d : null;
                                }
                            }
                        }
                    },
                    bar: {
                        width: {
                            ratio: 0.35 // this makes bar width 50% of length between ticks
                        }
                    },
                    tooltip: {},
                    y: {
                        min: 0,
                        padding: {top: 0, bottom: 0}
                    },
                    transition: { duration: 1000 },
                    legend: {
                        show: false
                    }
                }
                this.relAtividadeProvincia.$emit('init', options)
            }
        },
    })
</script>

<style scoped>

</style>

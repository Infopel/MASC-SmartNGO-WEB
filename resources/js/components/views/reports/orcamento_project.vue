<template>
    <div class="bg-white border p-3">
        <div class="d-flex h-100">
            <div class="flex-grow-1">
                <div class="">
                    <h6 class="fw-600 m-0 text-muted">
                        Projectos ({{ projects.length }})
                    </h6>
                    <select
                        name=""
                        class="border mt-1 p-1 w-100"
                        @change="onProjectSelect($event)"
                        v-model="project"
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
                    <hr class="mt-1 mb-2" />
                </div>
                <div class="d-flex align-items-baseline">
                    <div class="flex-grow-1">
                        <h5 class="fw-500 mb-0">
                            Orçamento do Projecto
                        </h5>
                    </div>
                    <div class="">
                        <div
                            class="btn-group btn-group-sm"
                            role="group"
                            aria-label="..."
                        >
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
                        <p
                            style="cursor: default; color:rgb(117, 117, 117) ; user-select: none;-webkit-font-smoothing: antialiased; font-size: 12px;"
                        >
                            Gráfico de Barras - Orçamento do Projecto
                        </p>
                        <p
                            ng-controller="orc_pdeController"
                            style=" margin-top: -18px; color:rgb(189, 189, 189);; cursor: default; user-select: none;-webkit-font-smoothing: antialiased;font-size: 14px"
                            class="ng-scope ng-binding"
                        >
                            {{ project.name || null }}
                        </p>
                    </div>
                    <div class="grapth" style="min-height: 50vh">
                        <vue-c3 :handler="relFinProject"></vue-c3>

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
                                    <div
                                        class="c3-legend-item text-black-50 fw-500"
                                    >
                                        Orçamento do Projecto
                                    </div>
                                </div>
                                <div
                                    class="flex-grow-1 text-center p-2"
                                    title="Valor Gasto"
                                >
                                    <div
                                        class="m-2 w-25 mr-auto ml-auto"
                                        style="border-top: 3px solid #d93025"
                                    ></div>
                                    <div
                                        class="c3-legend-item text-black-50 fw-500"
                                    >
                                        Valor Gasto
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table
                            class="finances border table table-sm table-hover"
                        >
                            <thead class="table-active">
                                <th class="fw-600">Descrição</th>
                                <th class="fw-600">Valor (MZN)</th>
                                <!-- <th class="fw-600">Valor Gasto</th> -->
                                <!-- <th class="fw-600">% Execucao</th> -->
                            </thead>
                            <tbody>
                                <template
                                    v-if="dataTable !== null && !isLoading"
                                >
                                    <tr>
                                        <td class="table-active text-body pl-2">
                                            Orçamento do Projecto
                                        </td>
                                        <td>
                                            {{
                                                dataTable
                                                    ? formatBudget(
                                                          dataTable.orcamento_inicial
                                                      )
                                                    : 0.0
                                            }}
                                            MZN
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-active text-body pl-2">
                                            Valor Gasto
                                        </td>
                                        <td>
                                            {{
                                                dataTable
                                                    ? formatBudget(
                                                          dataTable.orcamento_gasto
                                                      )
                                                    : 0.0
                                            }}
                                            MZN
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-active text-body pl-2">
                                            % Execucao
                                        </td>
                                        <td>0 %</td>
                                    </tr>
                                </template>
                                <tr v-if="dataTable == null && !isLoading">
                                    <td colspan="2" class="text-center">
                                        {{ __("lang.label_no_data") }}
                                    </td>
                                </tr>
                                <tr v-if="isLoading">
                                    <td colspan="2" class="text-center">
                                        {{ "Carregando..." }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="border-left pl-2 ml-3" style="width:250px">
                <h5 class="border-bottom btn w-100 text-left fw-600 pl-1">
                    <i class="icon-arrow-up5"></i>FILTROS
                </h5>
                <div class="_filters">
                    <!-- <form action=""></form> -->
                    <!-- <div class="border-bottom w-100">
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
                    </div> -->
                    <div class="border-bottom w-100">
                        <div
                            class="w-100 d-flex pl-1 btn rounded-0 btn-white text-left cursor-pointer"
                            id="dropdownNotidications"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                        >
                            <div class="flex-grow-1 text-muted">Ano:</div>
                            <div class="">
                                {{ year }}
                                <i class="icon-arrow-down12"></i>
                            </div>
                        </div>
                        <div
                            class="dropdown-menu border my-shadow"
                            aria-labelledby="dropdownNotidications"
                        >
                            <ul
                                class="list-unstyled pb-0 mb-0"
                                style="max-height: 300px; overflow-y:auto"
                            >
                                <li class="dropdown-item cursor-pointer">
                                    2020
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="border-bottom w-100">
                        <div
                            class="w-100 d-flex pl-1 btn rounded-0 btn-white text-left cursor-pointer"
                            id="dropdownNotidications"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                        >
                            <div class="flex-grow-1 text-muted">
                                Data Inicial:
                            </div>
                            <div class="">
                                {{ start_date || "mm/dd/yyyy" }}
                                <i class="icon-arrow-down12"></i>
                            </div>
                        </div>
                        <div
                            class="dropdown-menu border my-shadow p-2"
                            aria-labelledby="dropdownNotidications"
                        >
                            <input
                                type="date"
                                class="form-control"
                                v-model="start_date"
                            />
                            <li
                                class="dropdown-item cursor-pointer text-center rounded bg-light mt-1"
                            >
                                Fechar
                            </li>
                        </div>
                    </div>
                    <div class="border-bottom w-100">
                        <div
                            class="w-100 d-flex pl-1 btn rounded-0 btn-white text-left cursor-pointer"
                            id="dropdownNotidications"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                        >
                            <div class="flex-grow-1 text-muted">
                                Data Final:
                            </div>
                            <div class="">
                                {{ end_date || "mm/dd/yyyy" }}
                                <i class="icon-arrow-down12"></i>
                            </div>
                        </div>
                        <div
                            class="dropdown-menu border my-shadow p-2"
                            aria-labelledby="dropdownNotidications"
                        >
                            <input
                                type="date"
                                class="form-control"
                                v-model="end_date"
                            />
                            <li
                                class="dropdown-item cursor-pointer text-center rounded bg-light mt-1"
                            >
                                Fechar
                            </li>
                        </div>
                    </div>

                    <div class="w-100 mt-2">
                        <button
                            class="w-100 rounded btn btn-dark border fw-700 btn-sm p-1 shadow-sm"
                            v-on:click="filter(year, start_date, end_date)"
                        >
                            Submeter
                        </button>
                    </div>
                </div>
                <div class="m-3"></div>
                <h5 class="border-bottom btn w-100 text-left fw-600 pl-1">
                    <i class="icon-arrow-up5"></i>FILTROS AVANCADOS
                </h5>
                <div class="_advanced_filters">
                    <!-- <label for="show_genero" class="form-check-inline pl-1 mb-0 pb-0">
                        <input type="radio" name="get_data_type" id="show_genero" value="1" checked="checked">
                        <span class="pl-1">Mostrar dados por genero</span>
                    </label>
                        <label for="show_faixa_etaria" class="form-check-inline pl-1 mb-0 pb-0">
                        <input type="radio" name="get_data_type" id="show_faixa_etaria">
                        <span class="pl-1">Mostrar dados por faixa etaria</span>
                    </label> -->
                    <small class="pl-1 text-center text-muted"
                        >Upcoming release</small
                    >
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
    props: ["route_api", "projects"],

    mounted() {
        this.ini_graph_load([]);
        this.project = this.projects[0];
        this.onProjectSelect();
    },

    data() {
        return {
            handler: new Vue(),
            relFinProject: new Vue(),
            project: [],
            timeType: [
                {
                    name: "Anual",
                    key: 1
                },
                {
                    name: "Semestral",
                    key: 2
                },
                {
                    name: "Mensal",
                    key: "01"
                }
            ],
            year: new Date().getFullYear(),
            start_date: null,
            end_date: null,
            isLoading: false,
            dataTable: null
        };
    },

    methods: {
        formatBudget(value) {
            let val = (value / 1).toFixed(2).replace(".", ",");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        },
        async onProjectSelect() {
            if (this.project.length !== 0) {
                this.isLoading = true;
                await axios
                    .get(
                        "/reports/api/budget/project/" + this.project.identifier
                    )
                    .then(response => {
                        this.dataTable = response.data.dataTable;
                        this.ini_graph_load(response.data.dataGraph);
                    })
                    .catch(error => {
                        console.error({ Request: error });
                        this.ini_graph_load([]);
                        this.dataTable = [];
                        alert(
                            `Sinceras Desculpas! \nOcorreu um erro enquanto carregavamos os dados...\n${error}`
                        );
                    })
                    .finally(() => {
                        this.isLoading = false;
                    });
            }
        },
        async ini_graph_load(data) {
            const options = {
                data: {
                    json: data,
                    type: "bar",
                    keys: {
                        x: "project",
                        value: ["Orçamento Inicial", "Valor Gasto"]
                    }
                },
                color: {
                    pattern: ["#3366cc", "#d93025"]
                },
                axis: {
                    x: {
                        type: "category",
                        x: ["key"]
                    }
                },
                bar: {
                    width: {
                        ratio: 0.35 // this makes bar width 50% of length between ticks
                    }
                },
                tooltip: {
                    format: {
                        value: function(value, ratio, id, index) {
                            return value.toLocaleString("en") + " MZN";
                        }
                    }
                },
                transition: { duration: 1000 },
                legend: {
                    show: false
                }
            };
            this.relFinProject.$emit("init", options);
        },

        async filter(year, start_date, end_date) {
            if (this.project.length !== 0) {
                this.isLoading = true;
                await axios
                    .get(
                        `/reports/api/budget/project/${this.project.identifier}?year=${year}&start_date=${start_date}&end_date=${end_date}`
                    )
                    .then(response => {
                        // let type = "bar";
                        this.dataTable = response.data.dataTable;
                        this.ini_graph_load(response.data.dataGraph);
                    })
                    .catch(error => {
                        console.error({ Request: error });
                        this.ini_graph_load([]);
                        this.dataTable = [];
                        alert(
                            `Sinceras Desculpas! \nOcorreu um erro enquanto carregavamos os dados...\n${error}`
                        );
                    })
                    .finally(() => {
                        this.isLoading = false;
                    });
            }
        }
    }
};
</script>

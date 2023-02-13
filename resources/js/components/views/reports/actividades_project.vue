<template>
    <div class="mb-0">
        <div class="bg-white border border-bottom-0">
            <div class="align-items-baseline p-3">
                <div class="form-inline align-items-end">
                    <div class="w-25 mb-2">
                        <h6 class="fw-600 m-0 text-muted">
                            Linhas Estratégicas ({{ projects_pde.length }})
                        </h6>
                        <select
                            name=""
                            class="border p-1 w-100"
                            @change="onProjectParent($event)"
                            v-model="projectPDE"
                        >
                            <option selected :value="[]"
                                >Selecione uma linha estratégica</option
                            >
                            <option
                                v-for="(project, key) in projects_pde"
                                v-bind:key="key"
                                :value="project"
                            >
                                {{ project.name }}
                            </option>
                        </select>
                    </div>
                    <div class="w-25 ml-2 mb-2" v-if="projectPDE.length !== 0">
                        <h6 class="fw-600 m-0 text-muted">
                            Projectos ({{ projects.length }})
                        </h6>
                        <select
                            name=""
                            class="border p-1 w-100"
                            @change="onProjectSelect($event)"
                            v-model="selected_project"
                        >
                            <option selected :value="[]"
                                >Selecione um projecto</option
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
                    <div class="ml-2 mb-2">
                        <h6 class="fw-600 m-0 text-muted">Ano</h6>
                        <select
                            name=""
                            class="border pl-2 pr-2 p-1"
                            v-model="year"
                        >
                            <option :value="null">Ano</option>
                            <option :value="2020">2020</option>
                        </select>
                    </div>
                    <div class="ml-2 mb-2">
                        <h6 class="fw-600 m-0 text-muted">Data de Inicio</h6>
                        <input
                            type="date"
                            name="start_date"
                            v-model="start_date"
                            class="border pl-2 p-1"
                            style="font-size:90%"
                        />
                    </div>
                    <div class="ml-2 mr-2 mb-2">
                        <h6 class="fw-600 m-0 text-muted">Data de Fim</h6>
                        <input
                            type="date"
                            name="end_date"
                            v-model="end_date"
                            class="border pl-2 p-1"
                            style="font-size:90%"
                        />
                    </div>
                    <div class="mr-2 mb-2">
                        <button
                            class="btn pt-1 pb-1 btn-success rounded-0 fw-600 shadow-sm"
                            @click="getDataByDate(project !== null)"
                        >
                            Pesquisar
                        </button>
                    </div>
                </div>
            </div>
            <hr class="mt-0 mb-0 mr-3 ml-3" />
        </div>
        <div class="bg-white border border-top-0 p-3">
            <div class="d-flex align-items-baseline">
                <div class="flex-grow-1">
                    <h5 class="fw-600">Actividades por Projecto</h5>
                </div>
                <div class="">
                    <div
                        class="btn-group btn-group-sm"
                        role="group"
                        aria-label="..."
                    >
                        <button
                            class="btn pt-1 pb-1 btn-success rounded-0 fw-600 shadow-sm"
                            @click="getExportExcel(project !== null)"
                        >
                            Folege
                        </button>
                        <a  class="btn btn-sm m-0 btn-dark"
                            v-bind:href="`/web/api/reports/activity/pde/${this.selected_project.identifier}/activity/export?start_date=${this.start_date}&end_date=${this.end_date}`">
                            <i class="icon-file-excel"></i>
                            Excel
                        </a>
                        <button class="btn btn-sm m-0 btn-light border">
                            Imprimir
                        </button>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-sm table-stripeds border table-hover">
                    <thead class="table-active">
                        <th>Designação</th>
                        <th>Data Inicio</th>
                        <th>Data Termino</th>
                        <th>Indicador</th>
                        <th>Tipo de meta</th>
                        <th>Meta</th>
                        <th>Base de Referencia</th>
                        <th>Realizado (total)</th>
                        <th>Percentual</th>
                    </thead>

                    <tbody>
                        <template v-for="(issue, key) in reportsData">
                            <tr v-bind:key="key">

                                <td class="p-2 pl-2 pr-2 text-capitalize">
                                    {{ issue.subject }}
                                </td>
                                <td class="p-2 pl-2 pr-2 text-capitalize">
                                    {{ issue.start_date }}
                                </td>
                                <td class="p-2 pl-2 pr-2 text-capitalize">
                                    {{ issue.due_date }}
                                </td>
                                <td>
                                    <template v-if="issue.indicators[0] != null">
                                        {{ issue.indicators[0].indicator_field.name }}
                                    </template>
                                </td>
                                <td class="p-2 pl-2 pr-2 text-capitalize">
                                    <template v-if="issue.indicators[0] != null">
                                        {{ issue.indicators[0].indicator_field.indicator_issue_values.meta_type }}
                                    </template>
                                </td>
                                <td class="p-2 pl-2 pr-2 text-capitalize">
                                    <template v-if="issue.indicators[0] != null">
                                        {{ issue.indicators[0].indicator_field.indicator_issue_values.meta }}
                                    </template>
                                </td>
                                <td class="p-2 pl-2 pr-2 text-capitalize">
                                    <template v-if="issue.indicators[0] != null">
                                        {{ issue.indicators[0].indicator_field.indicator_issue_values.base_ref }}
                                    </template>
                                </td>
                                <td class="p-2 pl-2 pr-2 text-capitalize">
                                    <template v-if="issue.indicators[0] != null">
                                        {{ issue.indicators[0].indicator_field.indicator_issue_values.base_ref }}
                                    </template>
                                </td>
                                <td class="p-2 pl-2 pr-2 text-capitalize">
                                    <template v-if="issue.indicators[0] != null">
                                        {{ issue.indicators[0].indicator_field.indicator_issue_values.base_ref }}
                                    </template>
                                </td>
                            </tr>
                        </template>
                        <template v-if="reportsData.length == 0">
                            <tr>
                                <td colspan="8" class="text-center">
                                    {{ __("lang.label_no_data") }}
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
import Vue from "vue";
import axios from "axios";
import VueC3 from "vue-c3";

export default {
    components: {
        VueC3
    },
    props: ["projects_pde"],
    data() {
        return {
            selected_project: [],
            projectPDE: [],
            projects: [],
            project: null,
            start_date: null,
            end_date: null,
            year: new Date().getFullYear(),
            isLoading: false,
            reportsData: []
        };
    },

    mounted() {},

    methods: {
        // On Porject is Selected
        async onProjectParent(event) {
            if (this.projectPDE.length !== 0) {
                this.isLoading = true;
                await axios
                    .get(
                        `/web/api/reports/activity/pde/${this.projectPDE.identifier}/projects`
                    )
                    .then(response => {
                        this.projects = response.data.projects;
                        //this.reportsData = response.data.projects;
                    })
                    .catch(error => {
                        console.log(error);
                    })
                    .finally(() => {
                        this.isLoading = false;
                    });
            }
        },

        async onProjectSelect(event) {
            if (this.projects.length !== 0) {
                this.isLoading = true;
                await axios
                    .get(
                        `/web/api/reports/activity/pde/${this.selected_project.identifier}/activity`
                    )
                    .then(response => {
                        this.reportsData = response.data.projects;
                    })
                    .catch(error => {
                        console.log(error);
                    })
                    .finally(() => {
                        this.isLoading = false;
                    });
            }
        },

        async getDataByDate(setFilter = false) {
            this.isLoading = true;

            return await axios
                .get(
                `/web/api/reports/activity/pde/${this.selected_project.identifier}/activityByDate?setFilter=${setFilter}&start_date=${this.start_date}&end_date=${this.end_date}`
                )
                .then(response => {
                    this.reportsData = response.data.projects;
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
                    this.isLoading = false;
            });
        },

        async getExportExcel(setFilter = false) {
            this.isLoading = true;
            return await axios
                .get(
                `/web/api/reports/activity/pde/${this.selected_project.identifier}/activity/export?start_date=${this.start_date}&end_date=${this.end_date}`
                )
                .catch(error => {
                    //alert("Encontramos um error ao exportar o Ficheiro Excel.");
                    this.isError = true;
                    console.error({
                        status: "Error",
                        message: "Encontramos um error ao exportar o Ficheiro Excel",
                        errorLog: error
                    });
                })
                .finally(() => {
                    this.isLoading = false;
            });
        }
    }
};
</script>

<style scoped></style>

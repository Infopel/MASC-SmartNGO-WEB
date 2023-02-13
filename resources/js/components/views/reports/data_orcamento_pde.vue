<template>
    <div class="mb-0">
        <div class="bg-white border border-bottom-0">
            <div class="align-items-baseline p-3">
                <div class="form-inline align-items-end">
                    <div class="w-25">
                        <h6 class="fw-600 m-0 text-muted">
                            <!-- Planos Estratégicos ({{ projects.length }}) -->
                            Planos Estratégicos
                        </h6>
                        <select
                            name=""
                            class="border p-1 w-100 mb-2"
                            @change="getReportData($event)"
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
                    <div class="ml-2">
                        <h6 class="fw-600 m-0 text-muted">Data de Inicio</h6>
                        <input
                            type="date"
                            class="border pl-2 p-1 mb-2"
                            style="font-size:90%"
                            v-model="start_date"
                        />
                    </div>
                    <div class="ml-2">
                        <h6 class="fw-600 m-0 text-muted">Data de Fim</h6>
                        <input
                            type="date"
                            class="border pl-2 p-1 mr-2 mb-2"
                            style="font-size:90%"
                            v-model="end_date"
                        />
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
            <hr class="mt-0 mb-0 mr-3 ml-3" />
        </div>
        <div class="bg-white border border-top-0 p-3">
            <div class="d-flex align-items-baseline">
                <div class="flex-grow-1">
                    <h5 class="fw-600">Relatório Orçamento PDE</h5>
                </div>
                <div class="">
                    <div
                        class="btn-group btn-group-sm"
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
                </div>
            </div>
            <div class="">
                {{ selected_project.name || null }}
            </div>
            <div class="table-responsive">
                <table class="table table-sm table-stripeds border table-hover">
                    <thead class="table-active">
                        <template v-if="isFilter">
                            <th>Ano</th>
                            <th class="text-nowrap">Data de Inicio</th>
                            <th class="text-nowrap">Data de Fim</th>
                        </template>
                        <th>Tipo</th>
                        <th>Designação</th>
                        <th>Orcamento</th>
                        <th class="text-nowrap">Valor gasto (total)</th>
                        <th class="text-nowrap">Valor gasto / projecto</th>
                        <th>Percentual</th>
                    </thead>

                    <tbody>
                        <template v-for="(item, index) in reportsData">
                            <tr :key="index">
                                <template v-if="isFilter">
                                    <td>
                                        {{ year }}
                                    </td>
                                    <td>
                                        {{ start_date }}
                                    </td>
                                    <td>
                                        {{ end_date }}
                                    </td>
                                </template>
                                <td class="text-nowrap">
                                    {{ item.tracker.name }}
                                </td>
                                <td>
                                    {{ item.subject }}
                                </td>
                                <td>
                                    {{ "0.00" }}
                                </td>
                                <td>
                                    {{ "0.00" }}
                                </td>
                                <td>
                                    {{ "0.00" }}
                                </td>
                                <td>
                                    {{ 0 }}
                                </td>
                            </tr>
                        </template>

                        <template v-if="reportsData.length == 0">
                            <tr>
                                <td colspan="6" class="text-center">
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
    props: ["projects", "type"],

    data() {
        return {
            selected_project: [],
            project: null,
            year: new Date().getFullYear(),
            start_date: null,
            end_date: null,
            isLoading: false,
            reportsData: [],
            isError: false,
            isFilter: false,
            url: "/web/api/reports/rel/butget/pde"
        };
    },

    mounted() {
        this.selected_project = this.projects[0];
        this.getReportData();
    },

    methods: {
        async getReportData() {
            if (this.selected_project != null) {
                this.isLoading = true;
                this.isFilter = false;
                await axios
                    .get(`${this.url}/${this.selected_project.identifier}`)
                    .then(response => {
                        this.reportsData = response.data;
                        this.isError = false;
                    })
                    .catch(error => {
                        this.isError = true;
                        console.error({
                            status: "Error Fetching data from server",
                            message: error.message
                        });
                    })
                    .then(() => {
                        this.isLoading = false;
                    });
            }
        },

        async filterReportDate(year, start_date, end_date) {
            if (this.selected_project != null) {
                this.isLoading = true;
                this.isFilter = true;
                await axios
                    .get(
                        `${this.url}/${this.selected_project.identifier}?setFilter=1&year=${year}&start_date=${start_date}&end=${end_date}`
                    )
                    .then(response => {
                        // this.reportsData = response.data;
                        this.isError = false;
                    })
                    .catch(error => {
                        this.isError = true;
                        console.error({
                            status: "Error Fetching data from server",
                            message: error.message
                        });
                    })
                    .finally(() => {
                        this.isLoading = false;
                    });
            }
        },
        printReportData() {
            return console.info("Printing report data");
        }
    }
};
</script>

<style scoped></style>

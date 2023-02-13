<template>
    <div class="mb-0">
        <div class="bg-white border border-bottom-0">
            <div class="align-items-baseline p-3">
                <div class="form-inline align-items-end">
                    <div class="w-25">
                        <h6 class="fw-600 m-0 text-muted">
                            Linhas Estratégicas {{ programs.length }}
                        </h6>
                        <select
                            name=""
                            class="border p-1 w-100 mb-2"
                            @change="onProgramSelect($event)"
                            v-model="selected_project"
                        >
                            <option selected :value="[]"
                                >Selecione uma linha estratégica</option
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
                        />
                    </div>
                    <div class="ml-2">
                        <h6 class="fw-600 m-0 text-muted">Data de Fim</h6>
                        <input
                            type="date"
                            class="border pl-2 p-1 mr-2 mb-2"
                            style="font-size:90%"
                        />
                    </div>
                    <div class="mr-2 mb-2">
                        <button
                            class="btn pt-1 pb-1 btn-success rounded-0 fw-600 shadow-sm"
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
            <div class="table-responsive">
                <table
                    class="finances table table-sm table-stripeds border table-hover"
                >
                    <thead class="table-active">
                        <th>Tipo</th>
                        <th>Designação</th>
                        <th>Orçamento</th>
                        <th>Valor gasto (total)</th>
                        <th>Percentual</th>
                    </thead>

                    <tbody>
                        <template>
                            <tr>
                                <td colspan="9" class="text-center">
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
    props: ["programs"],
    data() {
        return {
            selected_project: [],
            project: null,
            year: null,
            isLoading: false
        };
    },

    mounted() {},

    methods: {}
};
</script>

<style scoped></style>

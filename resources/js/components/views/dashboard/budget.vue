<template>
    <div class="row m-1 ml-lg-5 mr-lg-5">
        <div class="col-md-12 mt-1 p-1">

            <div class="mb-3 p-2 bg-white">
                <div class="d-flex">
                    <div class="flex-grow-1 p-1">
                        <h5 class="mb-0">Projecto:</h5>
                        <span v-if="selectedProject">{{ selectedProject.name }}</span>
                        <span v-if="!selectedProject">Select a project...</span>
                    </div>

                    <div class="p-1 col-md-3">
                        <select @change="onSelectProj($event)" v-model="selectedProject" class="form-control">
                            <option>Select a project...</option>
                            <option v-for="project in projects" :value="project" v-bind:key="project.id" :project="project.name">{{ project.name }}</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <!-- row 2 -->
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <div class="card-block p-3">
                                <div class="title-card pt-2 pl-2 rounded bg-light mb-2 d-flex">
                                    <h6 class="flex-grow-1">
                                        <span>Orçamento</span>
                                    </h6>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 border-lg border-right">
                                        <div class="p-0 pt-3 border-bottom">
                                            <div class="content-group m-0">
                                                <i class="icon-coins position-center " style="font-size: 24px; color:#2D96FF"></i>
                                                <h4 class="text-semibold no-margin">
                                                    <small>MZN</small> 5,689
                                                </h4>
                                                <span class="text-muted ">Orçamento</span>
                                            </div>
                                        </div>
                                        <div class="p-0 pt-3">
                                            <div class="content-group m-0">
                                                <i class="icon-coins position-center" style="font-size: 24px; color:#ff2d62"></i>
                                                <h4 class="text-semibold no-margin">
                                                    <small>MZN</small> 5,689
                                                </h4>
                                                <span class="text-muted ">Valor Gasto</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <vue-c3 :handler="BudgetG_1"></vue-c3>

                                        <div class="col-md-12" id="grafGenero" v-if="BudgetG_1_loading">
                                            <div class="col-12 m-auto text-center" ng-if="loading;">
                                                <div class="spinner-grow text-warning" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                                <div class="spinner-grow text-success" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                                <div class="spinner-grow text-danger" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                                <div class="spinner-grow" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                                <div class="">
                                                    Loading...
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- column My Tasks -->
                        <div class="col-md-6 mb-3">
                            <div class="card-block p-3">
                                <div class="title-card pt-2 pl-2 rounded bg-light mb-2 d-flex">
                                    <h6 class="flex-grow-1">
                                        <span>Project Perfomance</span>
                                    </h6>
                                </div>
                                <div class="row m-auto h-75 text-center">
                                    <div class="col-6 mb-2 mb-lg-0  border-right">
                                        <div class="card-block  p-0 pt-3 border-bottom">
                                            <div class="content-group m-0">
                                                <i class="icon-coins position-center text-slate" style="font-size: 24px;"></i>
                                                <h4 class="text-semibold no-margin" style="white-space: normal;">
                                                    <small>MZN</small> 5,689
                                                    <small class="text-success text-size-base">(+16.2%)</small></h4>
                                                <span class="text-muted ">Orçamento Previsto</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-2 mb-lg-0 ">
                                        <div class="card-block  p-0 pt-3 border-bottom">
                                            <div class="content-group m-0">
                                                <i class="icon-coins position-center text-slate" style="font-size: 24px;"></i>
                                                <h4 class="text-semibold no-margin" style="white-space: normal;">
                                                    <small>MZN</small> 5,689
                                                </h4>
                                                <span class="text-muted ">Orçamento Realizado</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-2 mb-lg-0 border-right mt-2">
                                        <div class="card-block  p-0 pt-3">
                                            <div class="content-group m-0">
                                                <i class="icon-coins position-center text-slate" style="font-size: 24px;"></i>
                                                <h4 class="text-semibold no-margin">
                                                    <small>MZN</small> 5,689
                                                    <small class="text-danger text-size-base">(-6.2%)</small>
                                                </h4>
                                                <span class="text-muted ">Valor Gasto Previsto</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-2 mb-lg-0 mt-2">
                                        <div class="card-block  p-0 pt-3">
                                            <div class="content-group m-0">
                                                <i class="icon-coins position-center text-slate" style="font-size: 24px;"></i>
                                                <h4 class="text-semibold no-margin">
                                                    <small>MZN</small> 5,689
                                                </h4>
                                                <span class="text-muted ">Valor Gasto Realizado</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- column My Tasks -->
                    </div>
                    <!-- /row 2 -->

                    <!-- row 3 -->
                    <div class="row">
                        <!-- Column 1 -->
                        <div class="col-md-3 mb-3">
                            <div class="card-block bg-white p-3">
                                <div class="title-card pt-2 pl-2 rounded bg-light mb-2 d-flex">
                                    <h6 class="flex-grow-1">
                                        <span>% Contribuicao de Sub-Projectos</span>
                                    </h6>
                                </div>
                                <div class="">
                                    <vue-c3 :handler="BudgetG_2"></vue-c3>
                                </div>
                            </div>
                        </div>
                        <!-- /Column 1 -->

                        <!-- Column 1 -->
                        <div class="col-md-3 mb-3">
                            <div class="card-block bg-white p-3">
                                <div class="title-card pt-2 pl-2 rounded bg-light mb-2 d-flex">
                                    <h6 class="flex-grow-1">
                                        <i class="icon-coin-dollar"></i>
                                        <span>Contribuicao de Sub-Projectos</span>
                                    </h6>
                                </div>
                                <div class="">
                                    <vue-c3 :handler="BudgetG_2"></vue-c3>
                                </div>
                            </div>
                        </div>
                        <!-- /Column 1 -->

                        <!-- Column 2 -->
                        <div class="col-md-6 mb-3">
                            <div class="card-block bg-white p-3">
                                <div class="title-card pt-2 pl-2 rounded bg-light mb-2 d-flex">
                                    <h6 class="flex-grow-1">
                                        <i class="icon-list-ordered"></i>
                                        <span>Orçamento de Sub-Projectos</span>
                                    </h6>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-sm nowrap">
                                        <thead class="bg-slate">
                                            <th>Project</th>
                                            <th class="text-right">Orçamento</th>
                                            <th class="text-right">Valor Gasto</th>
                                        </thead>
                                        <tbody v-if="projectBudget.childsBudget">
                                            <tr class="text-uppercase" v-for="project in projectBudget.childsBudget" v-bind:key="project">
                                                <td>{{ project.name }}</td>
                                                <td class="text-right">25,000.00</td>
                                                <td class="text-right">15,000.00</td>
                                            </tr>
                                            <tr v-if="!projectBudget.childsBudget" class="text-center text-black-50">
                                                <td colspan='3'>Select a project...</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /Column 2 -->
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="row">
                        <!-- Column 1 -->
                        <div class="col-md-5 mb-3">
                            <div class="card-block bg-white p-3">
                                <div class="title-card pt-2 pl-2 rounded bg-light mb-2 d-flex">
                                    <h6 class="flex-grow-1">
                                        <i class="icon-coin-dollar"></i>
                                        <span>Relatorio de Actividades</span>
                                    </h6>
                                </div>
                                <div class="">
                                    <vue-c3 :handler="BudgetG_3"></vue-c3>
                                </div>
                                <div id="grafGenero" v-if="BudgetG_3_loading">
                                    <div class="col-6 col-lg-7 m-auto text-center" ng-if="loading;">
                                        <div class="spinner-grow text-warning" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                        <div class="spinner-grow text-success" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                        <div class="spinner-grow text-danger" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                        <div class="spinner-grow" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                        <div class="">
                                            Loading...
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Column 1 -->

                        <!-- Column 1 -->
                        <div class="col-md-7 mb-3">
                            <div class="card-block bg-white p-3">
                                <div class="title-card pt-2 pl-2 rounded bg-light mb-2 d-flex">
                                    <h6 class="flex-grow-1">
                                        <i class="icon-coin-dollar"></i>
                                        <span>Orçamento de Sub-Projectos</span>
                                    </h6>
                                </div>
                                <div class="">
                                    <vue-c3 :handler="BudgetG_4"></vue-c3>
                                </div>
                                <div id="grafGenero" v-if="BudgetG_4_loading">
                                    <div class="col-6 col-lg-7 m-auto text-center" ng-if="loading;">
                                        <div class="spinner-grow text-warning" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                        <div class="spinner-grow text-success" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                        <div class="spinner-grow text-danger" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                        <div class="spinner-grow" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                        <div class="">
                                            Loading...
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Column 1 -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
    import Vue from 'vue'
    import axios from 'axios'
    import VueC3 from 'vue-c3'

    export default Vue.extend({
        components: {
            VueC3,
        },
        created() {
            this.initDashboard(),
            this.getProjects()
        },
        data () {
            return {
                handler: new Vue(),
                BudgetG_1: new Vue(),
                BudgetG_2: new Vue(),
                BudgetG_3: new Vue(),
                BudgetG_4: new Vue(),
                BudgetG_1_loading: true,
                BudgetG_2_loading: true,
                BudgetG_3_loading: true,
                BudgetG_4_loading: true,
                dashboard_endpoint: '/api/dashboard',

                projects_endpoind: '/api/projects',
                projects: [],
                selectedProject: null,

                projectBudget_endpoind: '/api/projects/id/',
                projectBudget: [],
                subProjectBudget: [],
                subProjectBudget_column_data: []
            }
        },
        mounted () {
            this.initBudgetG_1(),
            this.initBudgetG_2(null)
            this.initBudgetG_3(null)
            this.initBudgetG_4(null)
        },
        methods:{
            async initDashboard(){
                axios(this.dashboard_endpoint)
                .then(response=>{

                })
                .catch(error =>{
                    console.log("----- Error on Loading data -------");
                    console.log(error);
                })
            },

            async getProjects(){
                axios(this.projects_endpoind)
                    .then(response=>{
                        this.projects = response.data.projects;
                    })
                    .catch(error =>{
                        console.log(" ----- Error detected on loading data -----")
                        console.log(error)
                    })
            },

            async getProjectsBuget(project_id){
                axios(this.projectBudget_endpoind+project_id)
                    .then(response=>{
                        this.projectBudget = response.data.projectBugdet;
                        this.initBudgetG_2(this.projectBudget);
                        this.BudgetG_2_loading = false
                    })
                    .catch(error =>{
                        console.log(" ----- Error detected on loading data -----")
                        console.log(error)
                    })
            },

            onSelectProj(event){
                this.getProjectsBuget(this.selectedProject.id);
            },

            async initBudgetG_1(){
                const options = {
                    padding: {
                        right: -150,
                        left: 100,
                    },
                    data: {
                        columns: [
                            // ['Orcamento', 3985],
                            ['Valor Gasto', 2785],
                        ],
                        type: 'gauge',
                        labels: false
                    },
                    color: {
                        pattern: ['#89b53c', '#FF2D62']
                    },
                    gauge: {
                        // label: {
                        //     format: function(value, ratio) {
                        //         return value + " MZN";
                        //     },
                        //     show: false // to turn off the min/max labels.
                        // },
                        min: 0, // 0 is default, //can handle negative min e.g. vacuum / voltage / current flow / rate of change
                        max: 3985, // 100 is default
                        // units: ' ',
                        width: 35 // for adjusting arc thickness
                    },
                    size: {
                        height: 200
                    },
                    tooltip: {
                        format: {
                            value: function (value, ratio, id, index) {
                                return value.toLocaleString('en')+" MZN";
                            }
                        }
                    }
                }
                this.BudgetG_1_loading = false
                this.BudgetG_1.$emit('init', options)

            },
            async initBudgetG_2(projectBudget){
                if(this.projectBudget.childsBudget){
                    this.subProjectBudget_column_data = [];
                    projectBudget.childsBudget.forEach(project => {
                        this.subProjectBudget_column_data[project.name] = project.budget;
                    })
                }
                console.log(this.subProjectBudget_column_data)
                const options = {
                    data:{
                        json: this.subProjectBudget_column_data,
                        type:'pie',
                        labels: true
                    },
                    color: {
                        pattern: ['#f84004', '#f7b925','#00cd99', '#008b69','#5252f7', '#008b69', '#98df8a', '#d62728', '#ff9896', '#9467bd', '#c5b0d5', '#8c564b', '#c49c94', '#e377c2', '#f7b6d2', '#7f7f7f', '#c7c7c7', '#bcbd22', '#dbdb8d', '#17becf', '#9edae5']
                    },
                    pie:{

                    },
                    tooltip: {
                        format: {
                            value: function (value, ratio, id, index) {
                                return value.toLocaleString('en')+" MZN";
                            }
                        }
                    },
                    transition: {
                        duration: 100
                    }
                }
                this.BudgetG_2.$emit('init', options)
            },
            async initBudgetG_3(projectBudget = null){

                const options = {
                    data:{
                        columns:[
                            ['x', 'Actividades Fechadas', 'Actividades Abertas', 'Actividades Em progresso','Actividades Resolvidas'],
                            ['Act. Status', 78, 58, 48, 78],
                        ],
                        x: 'x',
                        labels: true,
                        type: "bar",
                        legend:{
                            show: false
                        }
                    },
                    color: {
                        pattern: ['#5252f7', '#f84004', '#f7b925', '#00cd99', '#008b69', '#008b69', '#98df8a', '#d62728', '#ff9896', '#9467bd', '#c5b0d5', '#8c564b', '#c49c94', '#e377c2', '#f7b6d2', '#7f7f7f', '#c7c7c7', '#bcbd22', '#dbdb8d', '#17becf', '#9edae5']
                    },
                    bar: {
                        width: {
                            ratio: .55
                        },
                    },
                    axis: {
                        rotated: true,
                        x: {
                            type: 'category',
                            tick: {
                                multiline: true
                            }
                        }
                    },
                    tooltip:{
                        format: function (value, ratio, id, index){
                            return value.toLocaleString('en')+" MZN";
                        }
                    }
                }
                this.BudgetG_3.$emit('init', options);
                this.BudgetG_3_loading = false
            },

            async initBudgetG_4(projectBudget= null){
                const options = {
                    data:{
                        type: 'bar',
                        columns:[
                            ['Orçamento', 698, 1684, 4987,6987],
                            ['Valor Gasto', 385, 487, 564,5687],
                        ],
                        legend:{
                            show: false
                        }
                    },
                    color: {
                        pattern: ['#5252f7 ', '#00cd99', '#f7b925']
                        // pattern: ['#F44336 ', '#f7b925', '#f7b925']
                    },
                    bar:{
                        width:{
                            ratio: .28
                        },
                        // space: 0.25
                    },
                    axis: {
                        x: {
                            type: 'category',
                            categories: ['08 Dezembro 2019', '10 Dezembro 2019', '11 Dezembro 2019', '12 Dezembro 2019', '13 Dezembro 2019', '14 Dezembro 2019'],
                            padding: {
                                left: -0.33,
                                right: -0.33,
                            },
                            tick:{
                                multiline: true
                            },
                            show: true,
                        },
                        y: {
                            show: true
                        }
                    },
                    tooltip: {
                        format: {
                            value: function (value, ratio, id, index) {
                                return value.toLocaleString('en')+" MZN";
                            }
                        }
                    },
                    transition: {
                        duration: 100
                    }
                }
                this.BudgetG_4.$emit('init', options);
                this.BudgetG_4_loading = false
            }
        },
    })

</script>

<style scoped>

</style>

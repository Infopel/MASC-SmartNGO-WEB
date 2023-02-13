<template>
    <div class="row m-1 ml-lg-5 mr-lg-5">
        <div class="col-12 containers mt-1 p-1">
            <div class="row">
                <div class="col-md-8 col-lg-9">
                    <!-- row 2 -->
                    <div class="row mb-3">
                        <div class="col-md-4 mb-3">
                            <div class="card-block p-3">
                                <div class="title-card border-bottom">
                                    <h6>
                                        <a href="" class="text-slate-800">
                                            <span>Tasks Overview</span>
                                        </a>
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <!-- column My Tasks -->
                        <div class="col-md-8 mb-3">
                            <div class="card-block p-3">
                                <div class="title-card border-bottom mb-2 d-flex">
                                    <h6 class="flex-grow-1">
                                        <a href="" class="text-slate-800">
                                            <i class="icon-star-full2 text-orange-300"></i>
                                            <span>Tarefas Observadas</span>
                                        </a>
                                    </h6>
                                    <div class="">
                                        <a href="" class="text-slate-800 btn btn-sm bg-warning border-0">
                                            <span>Todas Tarefas</span>
                                        </a>
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
                        <div class="col-md-4 mb-3">
                            <div class="card-block bg-white p-3">
                                <div class="title-card border-bottom">
                                    <div class="">
                                        <h6>
                                            <a href="" class="text-slate-800">
                                                <i class="icon-stack3"></i>
                                                <span>Team member progress</span>
                                            </a>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Column 1 -->

                        <!-- Column 2 -->
                        <div class="col-md-8 mb-3">
                            <div class="card-block bg-white p-3">
                                <div class="title-card border-bottom">
                                    <div class="">
                                        <h6>
                                            <a href="" class="text-slate-800">
                                                <i class="icon-stack3"></i>
                                                <span>Hot Tasks</span>
                                            </a>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Column 2 -->
                    </div>
                </div>

                <div class="col-md-4 col-lg-3 mb-3">
                    <div class="card-block p-3">
                        <div class="title-card border-bottom">
                            <h6>
                                <a href="" class="text-slate-800">
                                    <i class="icon-history"></i>
                                    <span>Actividades recentes</span>
                                </a>
                            </h6>
                        </div>
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
            VueC3
        },
        created() {
            this.initDashboard()
        },
        data () {
            return {
                handler: new Vue(),
                dashboard_endpoint: '/api/dashboard',
            }
        },
        mounted () {

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
        },
    })
</script>

<style scoped>

</style>

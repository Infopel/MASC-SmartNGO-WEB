<template>
    <div>
        <div class="">
            <!-- Button trigger modal -->
            <a href="#" class="text-success" v-on:click="loadModalUsers()" data-toggle="modal" data-target="#usersModal">
                <i class="icon-plus2"></i>
                <span>{{ __('lang.label_user_new') }}</span>
            </a>

            <!-- Modal -->
            <div class="modal fade text-capitalize" id="usersModal" tabindex="-1" role="dialog" aria-labelledby="usersModalCenter" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form @submit.prevent="submit" method="POST">
                            <div class="modal-header p-2 pl-4 pr-4">
                                <h5 class="modal-title uppercase" id="exampleModalCenterTitle">{{ __('lang.label_user_new') }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div v-if="loading" class="bg-light p-2">
                                    Caregando Dados...
                                </div>
                                <div v-if="!loading" class="bg-light p-2">
                                    <div class="users">
                                        <div class="objects-selection">
                                            <label v-for="(user, key) in users" :key="key" class="mb-0">
                                                <input type="checkbox" name="user_ids[]" v-model="user_ids[user.id]"> {{ user.full_name }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer p-1">
                                <button type="submit">{{ __('lang.button_add') }}</button>
                                <button type="button"  data-dismiss="modal">{{ __('lang.button_cancel') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Members Table -->
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-sm border table-striped">
                        <thead class="table-active">
                            <th>Usuário / Grupo</th>
                            <th>Papéis</th>
                            <th>-</th>
                        </thead>

                        <tbody>
                            <tr class="d-none">
                                <td>NOme do user</td>
                                <td>Role</td>
                                <td>action</td>
                            </tr>

                            <tr>
                                <td colspan="3 text-center">
                                    <div class="alert-warning p-1 text-center border">
                                        {{ __('lang.label_no_data') }}
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- / user Members Table -->
    </div>
</template>

<script lang="ts">
    import Vue from 'vue'
    import axios from 'axios'

    export default Vue.extend({

         props:[
            'usersEndpoint',
            'actionendpoint'
        ],

        computed: {

        },
        data() {
            return {
                loading: true,
                users: [],
                user_ids: {},
                errors: [],
                actionEndPoint: this.actionendpoint
            }
        },

        methods: {
            async loadModalUsers(){

                this.loading = true,
                this.users = [],
                axios(this.usersEndpoint || '/api/user')
                .then(response=>{
                    this.users = response.data;
                    this.loading = false;
                })
                .catch(error =>{
                    console.log("----- Error on Load dataDashboard --------");
                    console.log(error);
                })
            },

            submit(){
                axios.post(this.actionEndPoint, {
                    user_ids: this.user_ids
                }).
                then(response=>{
                    console.log(response)
                })
                .catch(error=>{
                    console.log(error)
                })
            }
        },
    })
</script>

<style scoped>

</style>

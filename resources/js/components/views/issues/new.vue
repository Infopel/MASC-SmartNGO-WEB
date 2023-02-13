<template>
    <div>
        <div class="mb-3 bg-light rounded border p-2 pt-0" style="font-size: 90%;">
            <div class="tabular">
                <p class="col-md-8">
                    <label for="issues_type" class="float-left">{{ __('lang.field_type') }}<span class="text-danger"> *</span></label>
                    <select name="issue[type]" class="p-1 border my_input w-50">
                            <option value="a">ABC</option>
                    </select>
                </p>
                <p class="col-md-8">
                    <label for="name" class="float-left">Nome<span class="required"> *</span></label>
                    <input size="60" type="text" value="" name="issue[name]" class="border">
                </p>
                <p class="col-md-11 mt-2" >
                    <label for="project_name" class="float-left">Descrição<span class="required"> *</span></label>
                    <vue-editor v-model="editor_content" name="description"></vue-editor>
                </p>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <div class="tabular">
                            <p class="">
                                <label for="issues_type" class="float-left">{{ __('lang.field_status') }}<span class="text-danger"> *</span></label>
                                <select name="issue[status]" class="p-1 border my_input w-75">
                                    <option value="1">OPtion 1</option>
                                </select>
                            </p>

                            <p class="">
                                <label for="issues_type" class="float-left">{{ __('lang.field_priority') }}<span class="text-danger"> *</span></label>
                                <select name="issue[priority]" class="p-1 border my_input w-75">
                                    <option value="1">OPtion 1</option>
                                </select>
                            </p>

                            <p class="">
                                <label for="issues_type" class="float-left">{{ __('lang.field_assigned_to') }}</label>
                                <select name="issue[assigned_to]" class="p-1 border my_input w-75">
                                    <option value="1">OPtion 1</option>
                                </select>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="tabular">
                            <p>
                                <label for="issues_parent" class="float-left">Tarefa pai<span class="required"> *</span></label>
                                <select name="issue[parent_id]" class="p-1 border my_input w-100">
                                    <option value="1">OPtion 1</option>
                                </select>
                            </p>

                            <p>
                                <div class="d-md-flex">
                                    <div class="date-tab input-group w-auto">
                                        <div class="">
                                            <label class="float-left mr-3 mt-2">Início:</label>
                                        </div>
                                        <input type="text" class="my_input pickadate-year" name="issue[start_date]">
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="date-tab input-group w-auto">
                                        <div class="">
                                            <label class="float-left mr-3 mt-2">Data prevista:</label>
                                        </div>
                                        <input type="text" class="my_input pickadate-year" name="issue[due_date]">
                                    </div>
                                </div>
                            </p>

                            <p>
                                <label for="name" class="float-left">Tempo estimado<span class="required"> *</span></label>
                                <input size="60" type="text" value="" name="issue[time_tracking]" class="border w-50">
                            </p>
                            <p>
                                <label for="issue_done_ratio" class="float-left">% Terminado<span class="required"> *</span></label>
                                <select name="issue[done_ratio]">
                                    <option selected="selected" value="0">0 %</option>
                                    <option value="10">10 %</option>
                                    <option value="20">20 %</option>
                                    <option value="30">30 %</option>
                                    <option value="40">40 %</option>
                                    <option value="50">50 %</option>
                                    <option value="60">60 %</option>
                                    <option value="70">70 %</option>
                                    <option value="80">80 %</option>
                                    <option value="90">90 %</option>
                                    <option value="100">100 %</option>
                                </select>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
    import Vue from 'vue'

    export default Vue.extend({

        data() {
            return {
                editor_content: ''
            }
        },
    })
</script>

<style scoped>

</style>

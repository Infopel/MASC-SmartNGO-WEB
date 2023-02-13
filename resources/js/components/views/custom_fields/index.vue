<template>
    <div class="row">
        <!-- column 1 -->
        <div class="col-md-7">
            <div class="mb-3 bg-light rounded border p-2 pt-0" style="font-size:90%">
                <div class="tabular">
                    <!-- Default -->
                    <div class="">
                        <!-- selected="selected"  -->

                        <p class="pr-3">
                            <label for="format" class="float-left">Formato<span class="text-danger"></span></label>
                            <select v-model="selected_format" @change="selectedFormat(selected_format)" name="custom_field[field_format]" id="custom_field_field_format" class="selectd my_input" v-bind="{'disabled': is_edit }">
                                <option value="attachment">Arquivo</option>
                                <option value="bool">Booleano</option>
                                <option value="date">Data</option>
                                <option value="float">Decimal</option>
                                <option value="int">Inteiro</option>
                                <option value="link">Link</option>
                                <option value="list">Lista</option>
                                <option value="string">Texto</option>
                                <option value="text">Texto longo</option>
                            </select>
                        </p>
                        <p>
                            <label for="custom_field_name" class="float-left">Nome <span class="text-danger">*</span></label>
                            <input size="25" type="text" name="custom_field[name]" id="custom_field_name" placeholder="Tipo de tarefa" v-bind:value="custom_field ? custom_field.name : null" class="my_input "> <br>
                        </p>
                        <p>
                            <label for="custom_field_description" class="float-left">Descrição<span class="text-danger"></span></label>
                            <textarea class="border" name="custom_field[description]" id="custom_field_description" rows="7" v-bind:value="custom_field ? custom_field.description : null"></textarea>
                        </p>
                    </div>
                    <!-- /end Default -->
                    <attachment :custom_field="custom_field" v-if="selected_format == 'attachment'"></attachment>
                    <bool :custom_field="custom_field" v-if="selected_format == 'bool'"></bool>
                    <date :custom_field="custom_field" v-if="selected_format == 'date'"></date>
                    <enumeration :custom_field="custom_field" v-if="selected_format == 'enumeration'"></enumeration>
                    <link-input :custom_field="custom_field" v-if="selected_format == 'link'"></link-input>
                    <list-box :custom_field="custom_field" v-if="selected_format == 'list'"></list-box>
                    <numeric :custom_field="custom_field" v-if="selected_format == 'float'"></numeric>
                    <numeric :custom_field="custom_field" v-if="selected_format == 'int'"></numeric>
                    <string :custom_field="custom_field" v-if="selected_format == 'string'"></string>
                    <long-text :custom_field="custom_field" v-if="selected_format == 'text'"></long-text>
                    <user :custom_field="custom_field" v-if="selected_format == 'user'"></user>
                    <version :custom_field="custom_field" v-if="selected_format == 'version'"></version>
                </div>
            </div>
        </div>
        <!-- /Column 1 -->

        <!-- Column 2 -->
        <div class="col-md-5">
            <div class="mb-3 bg-light rounded border p-3 pt-0" style="font-size:90%">
                <div class="box tabular">
                    <p>
                        <label for="custom_field_is_required" class="float-left">{{ __('lang.label_required') }}</label>
                        <input name="custom_field[is_required]" type="hidden" value="0">
                        <input type="checkbox" value="1" name="custom_field[is_required]" id="custom_field_is_required">
                    </p>
                    <p>
                        <label for="custom_field_visible" class="float-left">{{ __('lang.field_visible') }}</label>
                        <input name="custom_field[visible]" type="hidden" value="0">
                        <input type="checkbox" value="1" checked="checked" name="custom_field[visible]" id="custom_field_visible">
                    </p>
                    <p>
                        <label for="custom_field_is_filter" class="float-left">{{ __('lang.field_is_filter') }}</label>
                        <input name="custom_field[is_filter]" type="hidden" value="0">
                        <input type="checkbox" value="1" name="custom_field[is_filter]" id="custom_field_is_filter">
                    </p>
                </div>
            </div>
            <div v-if="is_extra_options">
                <fieldset class="mb-3 bg-light rounded border pt-0 pl-3 pr-3">
                    <legend class="w-auto p-0 pl-2 pr-2" style="text-transform:none">
                        {{ __('lang.field_visible') }}
                    </legend>
                    <div class="box tabular">
                        <label class="block m-0 p-0">
                            <input type="radio" name="custom_field[visible]" id="custom_field_visible_on" value="1" data-disables=".custom_field_role input" checked="checked">
                            {{ __('lang.label_visibility_public') }}
                        </label>
                        <label class="block m-0 p-0">
                            <input type="radio" name="custom_field[visible]" id="custom_field_visible_off" value="0" data-enables=".custom_field_role input">
                            {{ __('lang.label_visibility_roles') }}:
                        </label>

                        <label v-for="(role, key) in roles" :key="key" class="block custom_field_role" style="padding-left:2em;">
                            <input type="checkbox" name="custom_field[role_ids][]" v-bind:value="role.id">
                            {{ role.name }}
                        </label>
                    </div>
                </fieldset>

                <fieldset class="mb-3 bg-light rounded border pt-0 pl-2 pr-3">
                    <legend class="w-auto p-0 pl-2 pr-1" style="text-transform:none">
                        <i class="icon-checkmark5 text-success"></i>{{ __('lang.label_tracker_plural') }}
                    </legend>

                    <div id="custom_field_tracker_ids" v-if="issues_type.lenght > 0">
                        <div class="">
                            <label v-if="(issue_type, key) in issues_type" :key="key" class="mr-2" for="custom_field_tracker_ids_4">
                                <input type="checkbox" name="custom_field[tracker_ids][]" v-bind:id="'custom_field_tracker_ids_'+issues_type.id" v-bind:value="issue_type.id">
                                {{ issues_type.name }}
                            </label>

                        </div>
                        <input type="hidden" name="custom_field[tracker_ids][]" id="custom_field_tracker_ids_" value="">
                        <p>
                            <a href="#" onclick="checkAll('custom_field_tracker_ids', true); return false;">Marcar todos</a> |
                            <a href="#" onclick="checkAll('custom_field_tracker_ids', false); return false;">Desmarcar todos</a>
                        </p>
                    </div>

                </fieldset>

                <fieldset class="mb-3 bg-light rounded border pt-0 pl-1 pr-3">
                    <legend class="w-auto p-0 pl-2 pr-1" style="text-transform:none">
                        <i class="icon-checkmark5 text-success"></i>{{ __('lang.label_project_plural') }}
                    </legend>

                    <div v-if="issues_type.lenght > 0">
                        <p class="m-0">
                            <label for="custom_field_is_for_all">Para todos os projetos</label>
                            <input name="custom_field[is_for_all]" type="hidden" value="0">
                            <input data-disables="#custom_field_project_ids input" type="checkbox" value="1" name="custom_field[is_for_all]" id="custom_field_is_for_all">
                        </p>

                        <div id="custom_field_project_ids">
                            <ul class="projects p-0">
                                <li class="m-0">
                                    <div class="">
                                        <label><input type="checkbox" name="custom_field[project_ids][]" value="7"> Nova Versao do SGMP</label>
                                    </div>
                                </li>
                            </ul>
                            <input type="hidden" name="custom_field[project_ids][]" value="">
                            <p>
                                <a href="#" onclick="checkAll('custom_field_project_ids', true); return false;">Marcar todos</a> |
                                <a href="#" onclick="checkAll('custom_field_project_ids', false); return false;">Desmarcar todos</a>
                            </p>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
        <!-- /Column 2 -->
    </div>
</template>

<script lang="ts">
    import Vue from 'vue'

    let attachment = require('./formats/attachment.vue').default;
    let bool = require('./formats/bool.vue').default;
    let date = require('./formats/date.vue').default;
    let enumeration = require('./formats/enumeration.vue').default;
    let linkInput = require('./formats/link.vue').default;
    let listBox = require('./formats/list.vue').default;
    let numeric = require('./formats/numeric.vue').default;
    let string = require('./formats/string.vue').default;
    let longText = require('./formats/text.vue').default;
    let user = require('./formats/user.vue').default;
    let version = require('./formats/version.vue').default;

    export default Vue.extend({

        mounted() {

        },
        components:{
            attachment,
            bool,
            date,
            enumeration,
            linkInput,
            listBox,
            numeric,
            string,
            longText,
            user,
            version
        },
        props:['is_edit', 'custom_field', 'is_extra_options','roles', 'issues_type', 'projects'],
        data() {
            return {
                selected_format: this.custom_field ? this.custom_field.field_format : 'attachment',
            }
        },

        methods: {
           async selectedFormat(format){
            }
        },
    })
</script>

<style scoped>

</style>

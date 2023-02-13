<template>
    <div>
        <div class="mb-3 bg-light rounded border p-2 pt-0" style="font-size: 90%;">
            <div class="tabular">
                <p class="col-md-7">
                    <label for="name" class="float-left">Nome<span class="required"> *</span></label>
                    <input size="60" type="text" v-model="pde_title" value="" name="pde[name]" id="project_name" class="border">
                </p>
                <p class="col-md-10 mt-2" >
                    <label for="project_name" class="float-left">Descrição<span class="required"> *</span></label>
                    <vue-editor v-model="editor_content" name="description"></vue-editor>
                    <input type="hidden" name="pde[description]" class="d-none" style="display:none !important" v-bind:value="editor_content">
                </p>
                <p>
                    <label for="identifier" class="float-left">Identificador<span class="required"> *</span></label>
                    <input size="60" maxlength="100" type="text" v-model="identifier" name="pde[identifier]" id="project_identifier" class="border">
                    <em class="info">deve ter entre 1 e 100 caracteres. Somente letras minúsculas (a-z), números, traços e sublinhados são permitidos. <br> Uma vez salvo, o identificador não pode ser alterado.</em>
                </p>

                <p>
                    <div class="d-flex">
                        <div class="date-tab input-group w-auto">
                            <div class="">
                                <label class="float-left mr-3 mt-2">Ano de Inicio:</label>
                            </div>
                            <input type="text" class="my_input pickadate-year" name="pde[start_date]">
                        </div>
                        <div class="date-tab input-group w-auto">
                            <div class="">
                                <label class="float-left mr-3 mt-2">Ano de Fim:</label>
                            </div>
                            <input type="text" class="my_input pickadate-year" name="pde[due_date]">
                        </div>
                    </div>
                </p>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
    import Vue from 'vue'
    import { VueEditor, Quill } from 'vue2-editor'

    export default Vue.extend({
        components: {
            VueEditor
        },

        props:['content', 'pde'],

        computed: {
            identifier: function(){
                let slug = this.sanitizeTitle(this.pde_title);
                return slug;
            },
        },

        data() {
            return {
            editor_content: this.content ? this.content.description : null,
            pde_title: this.content ? this.content.name : '',
            };
        },

        methods: {
            sanitizeTitle: function(pde_title){
                let slug = null;
                let identifierLowercase = pde_title.toLowerCase();
                slug = identifierLowercase.replace(/[^\w\s]/gi, ' ');
                slug = slug.replace(/e|é|è|ẽ|ẻ|ẹ|ê|ế|ề|ễ|ể|ệ/gi, 'e');
                slug = slug.replace(/a|á|à|ã|ả|ạ|ă|ắ|ằ|ẵ|ẳ|ặ|â|ấ|ầ|ẫ|ẩ|ậ/gi, 'a');
                slug = slug.replace(/o|ó|ò|õ|ỏ|ọ|ô|ố|ồ|ỗ|ổ|ộ|ơ|ớ|ờ|ỡ|ở|ợ/gi, 'o');
                slug = slug.replace(/u|ú|ù|ũ|ủ|ụ|ư|ứ|ừ|ữ|ử|ự/gi, 'u');
                slug = slug.replace(/đ/gi, 'd');
                slug = slug.replace(/-/gi, ' ');
                slug = slug.replace(/:/gi, ' ');
                slug = slug.replace(/[^\w\s]/gi, ' ');

                // Trim the last whitespace
                slug = slug.replace(/\s*$/g, '');
                // Change whitespace to "-"
                slug = slug.replace(/\s+/g, '-');
                return slug;
            }
        },
    })
</script>

<style lang="css">
@import "~vue2-editor/dist/vue2-editor.css";

/* Import the Quill styles you want */
@import '~quill/dist/quill.core.css';
@import '~quill/dist/quill.bubble.css';
@import '~quill/dist/quill.snow.css';
</style>
<style>
    #editor1, #editor2 {
        height: 350px;
        max-height: 450px;
    }

    .ql-toolbar.ql-snow{
        border: none !important;
        padding: 0px !important;
    }

    #quill-container{
        background: white;
        border-top: 1px solid #ccc;
    }
    .ql-snow .ql-toolbar button svg, .quillWrapper .ql-snow.ql-toolbar button svg {
        width: 16px !important;
        height: 16px !important;
    }
</style>

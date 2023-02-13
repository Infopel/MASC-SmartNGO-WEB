<template>
    <div>
        <div
            class="mb-3 bg-light rounded border p-2 pt-0"
            style="font-size: 90%;"
        >
            <div class="tabular">
                <p class="col-md-7">
                    <label for="name" class="float-left"
                        >Nome<span class="required"> *</span></label
                    >
                    <input
                        size="60"
                        type="text"
                        v-model="project_title"
                        value=""
                        name="project[name]"
                        id="project_name"
                        class="border"
                    />
                </p>
                <p class="col-md-10 mt-2">
                    <label for="project_name" class="float-left"
                        >Descrição<span class="required"> *</span></label
                    >
                    <vue-editor
                        v-model="editor_content"
                        name="description"
                    ></vue-editor>
                    <input
                        type="hidden"
                        name="project[description]"
                        class="d-none"
                        style="display:none !important"
                        v-bind:value="editor_content"
                    />
                </p>
                <p>
                    <label for="identifier" class="float-left"
                        >Identificador<span class="required"> *</span></label
                    >
                    <input
                        size="60"
                        maxlength="100"
                        type="text"
                        v-model="identifier"
                        name="project[identifier]"
                        id="project_identifier"
                        class="border"
                    />
                    <em class="info"
                        >deve ter entre 1 e 100 caracteres. Somente letras
                        minúsculas (a-z), números, traços e sublinhados são
                        permitidos. <br />
                        Uma vez salvo, o identificador não pode ser
                        alterado.</em
                    >
                </p>
                <p>
                    <label for="project_is_public" class="float-left"
                        >Público</label
                    >
                    <input name="project[is_public]" type="hidden" value="0" />
                    <input
                        type="checkbox"
                        value="1"
                        v-model="is_public"
                        name="project[is_public]"
                        id="project_is_public"
                    />
                    <em class="info"
                        >Projetos públicos e seu conteúdo estão disponíveis para
                        todos os usuários conectados.</em
                    >
                </p>

                <p>
                     <label for="project_has_shared_budget" class="float-left"
                        >Compartilhamento de Orçamento</label
                    >
                    <input name="project[has_shared_budget]" type="hidden" value="0" />
                    <input
                        type="checkbox"
                        value="1"
                        v-model="has_shared_budget"
                        name="project[has_shared_budget]"
                        id="project_has_shared_budget"
                    />
                    <em class="info">Projetos públicos com opção de compartilhamento de orçamento activo,<br> seram listados na seleção de projecto durante a solicitação ou cadastro de fundos de tarefas de projectos.</em>
                </p>
                <!-- Parent - Program / type Project -->
                <p class="col-md-7" v-if="this.project_type == 'Project'">
                    <label for="project_parent_id" class="float-left"
                        >Linha Estratégica:</label
                    >
                    <select
                        name="project[parent_id]"
                        v-model="parent_program_id"
                        id="program_parent_id"
                        class="select-search border w-100 p-1"
                        data-placeholder="selectione o projecto pai"
                    >
                        <option value="NULL"></option>
                        <option
                            v-for="(program, key) in programs"
                            :key="key"
                            v-bind:value="program.id"
                        >
                            {{ program.name }}
                        </option>
                    </select>
                </p>
                <!-- /Parent - Program -->

                <!-- Parent - Project -->
                <p class="col-md-7" v-if="this.parent.type == 'Project'">
                    <label for="project_parent_id" class="float-left"
                        >Subprojeto de</label
                    >
                    <select
                        name="project[parent_id]"
                        v-model="parent_program_id"
                        id="project_parent_id"
                        class="select-search border w-100"
                        data-placeholder="selectione o projecto pai"
                    >
                        <option value="null"></option>
                        <option
                            v-for="(project, key) in projects"
                            :key="key"
                            v-bind:value="project.id"
                        >
                            {{ project.name }}
                        </option>
                    </select>
                </p>
                <!-- /Parent - Project -->
                <p v-if="this.parent.type == 'Project'">
                    <label for="project_inherit_members" class="float-left"
                        >Herdar membros</label
                    >
                    <input
                        name="project[inherit_members]"
                        type="hidden"
                        value="0"
                    />
                    <input
                        type="checkbox"
                        value="1"
                        name="project[inherit_members]"
                        id="project_inherit_members"
                    />
                </p>

                <p>
                    <label for="project_start_date" class="float-left"
                        >{{ __("lang.field_start_date")
                        }}<span class="required"> *</span></label
                    >
                    <input
                        size="20"
                        type="date"
                        v-bind:value="project ? project.start_date : null"
                        name="project[start_date]"
                        id="project_start_date"
                        class="border"
                    />
                </p>
                <p>
                    <label for="project_due_date" class="float-left"
                        >{{ __("lang.field_due_date")}}<span class="required"> *</span>
                    </label>
                    <input
                        size="20"
                        type="date"
                        v-bind:value="project ? project.due_date : null"
                        name="project[due_date]"
                        id="project_due_date"
                        class="border"
                    />
                </p>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from "vue";
import { VueEditor, Quill } from "vue2-editor";

export default Vue.extend({
    components: {
        VueEditor
    },

    props: [
        "content",
        "project",
        "custom_fields",
        "projects",
        "programs",
        "parent"
    ],

    computed: {
        identifier: function() {
            let slug = this.sanitizeTitle(this.project_title);
            return slug;
        }
    },

    data() {
        return {
            editor_content: this.project ? this.project.description : null,
            project_title: this.project ? this.project.name : "",
            parent_program_id: this.parent ? this.parent.id : null,
            // parent_program_id: this.program ? this.program.parent_id : null,
            parent_project_id: this.project ? this.project.parent_id : null,
            project_type: this.project ? this.project.type : null,
            has_shared_budget: this.project ? this.project.has_shared_budget : false,
            is_public: this.project ? this.project.is_public : false
        };
    },

    methods: {
        sanitizeTitle: function(project_title) {
            let slug = null;
            let identifierLowercase = project_title.toLowerCase();
            slug = identifierLowercase.replace(/[^\w\s]/gi, " ");
            slug = slug.replace(/e|é|è|ẽ|ẻ|ẹ|ê|ế|ề|ễ|ể|ệ/gi, "e");
            slug = slug.replace(/a|á|à|ã|ả|ạ|ă|ắ|ằ|ẵ|ẳ|ặ|â|ấ|ầ|ẫ|ẩ|ậ/gi, "a");
            slug = slug.replace(/o|ó|ò|õ|ỏ|ọ|ô|ố|ồ|ỗ|ổ|ộ|ơ|ớ|ờ|ỡ|ở|ợ/gi, "o");
            slug = slug.replace(/u|ú|ù|ũ|ủ|ụ|ư|ứ|ừ|ữ|ử|ự/gi, "u");
            slug = slug.replace(/đ/gi, "d");
            slug = slug.replace(/-/gi, " ");
            slug = slug.replace(/:/gi, " ");
            slug = slug.replace(/[^\w\s]/gi, " ");

            // Trim the last whitespace
            slug = slug.replace(/\s*$/g, "");
            // Change whitespace to "-"
            slug = slug.replace(/\s+/g, "-");
            // console.log(slug);
            return slug;
        }
    }
});
</script>

<style lang="css">
@import "~vue2-editor/dist/vue2-editor.css";

/* Import the Quill styles you want */
@import "~quill/dist/quill.core.css";
@import "~quill/dist/quill.bubble.css";
@import "~quill/dist/quill.snow.css";
</style>
<style>
#editor1,
#editor2 {
    height: 350px;
    max-height: 450px;
}

.ql-toolbar.ql-snow {
    border: none !important;
    padding: 0px !important;
}

#quill-container {
    background: white;
    border-top: 1px solid #ccc;
}
.ql-snow .ql-toolbar button svg,
.quillWrapper .ql-snow.ql-toolbar button svg {
    width: 16px !important;
    height: 16px !important;
}
</style>

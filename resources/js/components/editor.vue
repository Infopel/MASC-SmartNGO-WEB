<template>
    <div>
        <vue-editor v-model="editor_content"></vue-editor>
        <input type="hidden" v-bind:name="input_field" class="d-none" style="display:none !important" v-bind:value="editor_content">
    </div>
</template>

<script lang="ts">
    import Vue from 'vue'
    import { VueEditor, Quill } from 'vue2-editor'

    export default Vue.extend({

        props:['content', 'form_to', 'input_field'],

        components: {
            VueEditor
        },

        data() {
            return {
                editor_content: this.content ? this.content : '',
                input_field_name: this.input_field ? this.input_field : 'content[description]'
            };
        }
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

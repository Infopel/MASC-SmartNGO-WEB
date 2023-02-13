<template>
    <div>
        <p>
            <label for="custom_field_default_value" class="float-left">Padrão</label>
            <select name="custom_field[default_value]" id="custom_field_default_value" class="border p-1">
                <option value="">&nbsp;</option>
                <option value="1">Sim</option>
                <option value="0">Não</option>
            </select>
        </p>
        <p>
            <label for="custom_field_url_pattern" class="float-left">Valores do link para URL</label>
            <input class="my_input " size="50" type="text" name="custom_field[url_pattern]" id="custom_field_url_pattern">
        </p>
        <p>
            <label for="custom_field_edit_tag_style" class="float-left">Exibição</label>
            <select name="custom_field[edit_tag_style]" id="custom_field_edit_tag_style" class="border p-1">
                <option value="">lista suspensa</option>
                <option value="check_box">checkboxes</option>
                <option value="radio">botões radio</option>
            </select>
        </p>
    </div>
</template>

<script lang="ts">
    import Vue from 'vue'

    export default Vue.extend({
        props:['custom_field']
    })
</script>

<style scoped>

</style>

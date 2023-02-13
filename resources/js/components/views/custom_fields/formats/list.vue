<template>
    <div>
        <p>
            <label for="custom_field_multiple" class="float-left">Múltiplos valores</label>
            <input name="custom_field[multiple]" type="hidden" value="0">
            <input type="checkbox" value="1" name="custom_field[multiple]" id="custom_field_multiple" v-model="is_multiple_values">
        </p>
        <p>
            <label for="custom_field_possible_values" class="float-left">Possíveis valores</label>
            <textarea rows="15" name="custom_field[possible_values]" id="custom_field_possible_values" v-model="custom_field_possible_values" class="border"></textarea>
            <em class="info">Uma linha para cada valor</em>
        </p>
        <p>
            <label for="custom_field_default_value" class="float-left">Padrão</label>
            <input class="my_input " type="text" name="custom_field[default_value]" id="custom_field_default_value" v-bind:value="custom_field ? custom_field.default_value : null">
        </p>
        <p>
            <label for="custom_field_url_pattern" class="float-left">Valores do link para URL</label>
            <input class="my_input " size="50" type="text" name="custom_field[url_pattern]" id="custom_field_url_pattern" v-bind:value="custom_field ? custom_field.format_store.url_pattern : null">
        </p>
        <p>
            <label for="custom_field_edit_tag_style" class="float-left">Exibição</label>
            <select v-model="edit_tag_style" name="custom_field[edit_tag_style]" id="custom_field_edit_tag_style" class="border p-1">
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
        props:['custom_field'],
        data() {
            return {
                custom_field_possible_values: this.custom_field ? this.custom_field.possible_values : '',
                is_multiple_values: this.custom_field ? this.custom_field.multiple : false,
                edit_tag_style: this.custom_field ? this.custom_field.format_store.edit_tag_style : ''
            }
        },
    })
</script>

<style scoped>

</style>

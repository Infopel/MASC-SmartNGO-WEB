<template>
    <div>
        <p>
            <label for="custom_field_min_length" class="float-left">Tamanho mín-máx</label>
            <input class="border " size="5" type="text" name="custom_field[min_length]" id="custom_field_min_length"> -
            <input class="border " size="5" type="text" name="custom_field[max_length]" id="custom_field_max_length">
        </p>
        <p>
            <label for="custom_field_regexp" class="float-left">Expressão regular</label>
            <input class="my_input " size="50" type="text" value="" name="custom_field[regexp]" id="custom_field_regexp">
            <em class="info">ex. ^[A-Z0-9]+$</em>
        </p>
        <p>
            <label for="custom_field_default_value" class="float-left">Padrão</label>
            <input class="my_input " type="text" name="custom_field[default_value]" id="custom_field_default_value">
        </p>
        <p>
            <label for="custom_field_url_pattern" class="float-left">Valores do link para URL</label>
            <input class="my_input " size="50" type="text" name="custom_field[url_pattern]" id="custom_field_url_pattern">
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

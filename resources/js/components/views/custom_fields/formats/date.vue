<template>
    <div>
        <p>
            <label for="custom_field_default_value" class="float-left">Padrão</label>
            <input size="10" type="date" name="custom_field[default_value]" id="custom_field_default_value" class="my_input">
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

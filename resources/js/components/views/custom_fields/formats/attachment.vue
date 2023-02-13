<template>
    <div>
        <p>
            <label for="custom_field_extensions_allowed" class="float-left">Permitir extensões</label>
            <input class="my_input" size="50" type="text" name="custom_field[extensions_allowed]" id="custom_field_extensions_allowed">
            <em class="info">Múltiplos valores são permitidos (separados por vírgula). Exemplo: txt, png</em>
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

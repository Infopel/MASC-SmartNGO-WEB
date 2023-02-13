<template>
    <form action="" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <fieldset class="">
                    <legend class="border-bottom text-bold text-black-50">
                        <i class="icon-info3"></i>
                        Descricao
                    </legend>
                    <div class="form-group">
                        <label class="display-block text-semibold">Left inline styled</label>
                        <label class="radio-inline">
                            <div class="choice"><span class=""><input type="radio" name="radio-inline-left" class="styled" checked="checked"></span></div>
                            Selected styled
                        </label>

                        <label class="radio-inline">
                            <div class="choice"><span class="checked"><input type="radio" name="radio-inline-left" class="styled"></span></div>
                            Unselected styled
                        </label>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <input type="text" class="form-control" id="firstName" placeholder="Nome:" value="" required="">
                            <div class="invalid-feedback">
                            Valid first name is required.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <select name="" id="" class="form-control">

                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <textarea type="text" class="form-control" id="address" placeholder="1234 Main St" required="" style="min-height: 250px">
                        </textarea>
                        <div class="invalid-feedback">
                            Please enter your shipping address.
                        </div>
                    </div>
                </fieldset>
            </div>

            <div class="col-md-6">
                <fieldset class="tabular">
                    <legend class="border-bottom text-bold text-black-50">
                        <i class="icon-info3"></i>
                        Novo orcamento
                    </legend>
                    <p>
                        <label for="my_input" class="text-danger">Criar para<span class="text-danger"> *</span></label>
                        <select name="tipo_documento" id="my_input" class="p-1 select">
                            <option value="BI" name="tipoDoc">Projecto</option>
                            <option value="BI" name="tipoDoc">Actividade</option>
                        </select>
                    </p>
                    <p class="">
                        <label for="my_input" class="text-danger">Tarefa:<span class="text-danger"> *</span></label>
                        <input size="25" disabled class="@error('nome') is-invalid @enderror" type="text" name="nome" placeholder="Primeiro nome" id="my_input">
                        <br>
                        @error('nome')
                            <span class="required-feedback text-danger-600" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </p>
                    <p>
                        <label for="my_input">Data: </label>
                        <input size="25" class="w-75 @error('nome') is-invalid @enderror" type="text" name="nome" placeholder="01/01/2019" id="my_input">
                        <br>
                        @error('nome')
                            <span class="required-feedback text-danger-600" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </p>
                    <p>
                        <label for="my_input">Valor sem IVA: </label>
                        <input size="25" class="w-50 @error('nome') is-invalid @enderror" type="text" name="nome" value="0.0" id="my_input">
                        <br>
                        @error('nome')
                            <span class="required-feedback text-danger-600" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </p>
                    <p>
                        <label for="my_input">IVA: </label>
                        <input size="25" class="w-25 @error('nome') is-invalid @enderror" type="text" name="nome" placeholder="17" id="my_input">
                        %
                        <label style="margin:0px !important; width:auto !important;" class="text-left font-weight-normal text-black-50" id="">
                            <input style="margin:0px !important" type="checkbox" name="is_iva_valid" value="isIva" class="styled">
                            usar contagem de IVA
                        </label>

                        <br>
                        @error('nome')
                            <span class="required-feedback text-danger-600" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </p>
                    <p>
                        <label for="my_input">Valor Total: </label>
                        <input size="25" class="w-50 @error('nome') is-invalid @enderror" type="text" name="nome" value="0.0" id="my_input">
                        <br>
                        @error('nome')
                            <span class="required-feedback text-danger-600" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </p>
                    <p>
                        <label for="my_input">Moeda: </label>
                        <select name="tipo_documento" id="my_input" class="w-25 p-1 select">
                            <option value="BI" name="tipoDoc">Metical (MZN)</option>
                            <option value="BI" name="tipoDoc">US Dollar ($)</option>
                        </select>
                    </p>
                </fieldset>
            </div>
        </div>
    </form>
</template>

<script lang="ts">
    import Vue from 'vue'

    export default Vue.extend({

    })
</script>

<style scoped>

</style>

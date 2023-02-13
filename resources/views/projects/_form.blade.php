<div class="row">
    <div class="col-md-12">
        <div class="mb-3 bg-light rounded border p-2 pt-0" style="font-size: 90%;">
            <div class="tabular">
                <p class="col-md-7">
                    <label for="project_name" class="float-left">Nome<span class="required"> *</span></label>
                    <input size="60" type="text" value="" name="project[name]" id="project_name" class="border">
                </p>
                <p class="col-md-10 mt-2" >
                    <label for="project_name" class="float-left">Descrição<span class="required"> *</span></label>
                    <vue-editor v-model="content"></vue-editor>
                </p>

                <p>
                    <label for="project_identifier" class="float-left">Identificador<span class="required"> *</span></label>
                    <input size="60" maxlength="100" type="text" name="project[identifier]" id="project_identifier" class="border">
                    <em class="info">deve ter entre 1 e 100 caracteres. Somente letras minúsculas (a-z), números, traços e sublinhados são permitidos. <br> Uma vez salvo, o identificador não pode ser alterado.</em>
                </p>
            </div>
        </div>
    </div>
</div>
@include('projects._otherOptions')

<div class="row">
    <div class="col-md-12">
        <div class="mb-3 bg-light rounded border p-3 pt-0" style="font-size:90%">
            <p class="text-muted">Selecione o tipo de objeto ao qual o campo personalizado é para ser anexado:</p>
            <p>
                <label class="m-0" style="display:block;">
                    <input type="radio" name="type" id="type_IssueCustomField" value="IssueCustomField" checked="checked"> Tarefas
                </label>
                <label class="m-0" style="display:block;">
                    <input type="radio" name="type" id="type_TimeEntryCustomField" value="TimeEntryCustomField"> Tempo gasto
                </label>
                <label class="m-0" style="display:block;">
                    <input type="radio" name="type" id="type_ProjectCustomField" value="ProjectCustomField"> Projetos
                </label>
                <label class="m-0" style="display:block;">
                    <input type="radio" name="type" id="type_VersionCustomField" value="VersionCustomField"> Versões
                </label>
                <label class="m-0" style="display:block;">
                    <input type="radio" name="type" id="type_DocumentCustomField" value="DocumentCustomField"> Documentos
                </label>
                <label class="m-0" style="display:block;">
                    <input type="radio" name="type" id="type_UserCustomField" value="UserCustomField"> Usuários
                </label>
                <label class="m-0" style="display:block;">
                    <input type="radio" name="type" id="type_GroupCustomField" value="GroupCustomField"> Grupos
                </label>
                <label class="m-0" style="display:block;" for="type_PartnerCustomField">
                    <input type="radio" name="type" id="type_PartnerCustomField" value="PartnerCustomField"> {{ __('lang.label_partner_plural') }}
                </label>
                <label class="m-0" style="display:block;">
                    <input type="radio" name="type" id="type_TimeEntryActivityCustomField" value="TimeEntryActivityCustomField"> Atividades (registro de horas)
                </label>
                <label class="m-0" style="display:block;">
                    <input type="radio" name="type" id="type_IssuePriorityCustomField" value="IssuePriorityCustomField"> Prioridade das tarefas
                </label>
                <label class="m-0" style="display:block;">
                    <input type="radio" name="type" id="type_DocumentCategoryCustomField" value="DocumentCategoryCustomField"> Categorias de documento
                </label>
            </p>
        </div>
    </div>
</div>

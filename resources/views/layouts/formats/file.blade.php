<p>
    <label class="float-left">{{ $field }}:</label>
    <span class="attachments_form">
        <span class="attachments_fields"></span>
        <span class="add_attachment" style="">
            <input type="file" name="attachments[file]" class="file_selector filedrop" multiple="multiple" onchange="addInputFiles(this);" data-max-file-size="204800000" data-max-file-size-message="Este ficheiro não pode ser carregado pois excede o tamanho máximo permitido por ficheiro (2 MB)" data-max-concurrent-uploads="2" data-upload-path="/uploads.js" data-param="attachments" data-description="true" data-description-placeholder="Descrição opcional" {{ $is_desabled ? $is_desabled ? 'disabled="true"' : '' : null }}>
            (Tamanho máximo: 2 MB)
        </span>
    </span>
</p>

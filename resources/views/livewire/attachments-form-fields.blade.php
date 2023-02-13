<div class="multiple_file_upload_row mt-2">
    <div class="small text-bold text-capitalize text-black-50">
        <i class="icon-file-empty2" style="font-size:95%"></i>
        {{ $title }}
    </div>
    <p class="mt-2 border-top pt-2">
        <label class="float-left mr-3">Ficheiros</label>
        <span class="attachments_form">
            <span class="attachments_fields">
            </span>
            <span class="add_attachment" style="">
                <input type="file" name="attachments[0][file]" class="file_selector filedrop" onchange="addInputFiles(this);" data-max-file-size="204800000" data-max-file-size-message="Este ficheiro não pode ser carregado pois excede o tamanho máximo permitido por ficheiro (15 MB)" data-max-concurrent-uploads="2" data-upload-path="/uploads.js" data-param="attachments" data-description="true" data-description-placeholder="Descrição opcional">
                (Tamanho máximo: 15 MB)
            </span>
        </span>
    </p>
    @foreach ($file_forms as $key => $item)
        <p class="mt-2 border-top pt-2">
            <label class="float-left mr-3">Ficheiros</label>
            <span class="attachments_form">
                <span class="attachments_fields">
                </span>
                <span class="add_attachment" style="">
                    <input type="file" name="attachments[{{ $item['index'] }}][file]" class="file_selector filedrop" onchange="addInputFiles(this);" data-max-file-size="204800000" data-max-file-size-message="Este ficheiro não pode ser carregado pois excede o tamanho máximo permitido por ficheiro (15 MB)" data-max-concurrent-uploads="2" data-upload-path="/" data-param="attachments" data-description="true" data-description-placeholder="Descrição opcional">
                    (Tamanho máximo: 15 MB)
                </span>
            </span>
            <button type="button" class="btn btn-sm border-0 btn-light" wire:click="remove_file_forms({{ $key, $item['index']}})" title="Remover">
                <i class="icon-trash text-danger"></i>
            </button>
        </p>
    @endforeach

    <button type="button" class="btn btn-sm border btn-light" wire:click="add_file_forms(0)">
        <i class="icon-plus2"></i>
        Add Ficheiro
    </button>
</div>

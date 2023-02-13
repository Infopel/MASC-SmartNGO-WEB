<div class="mb-3 bg-light rounded border p-2 pt-0" style="font-size: 90%;">
    <div class="tabular">
        <p class="col-md-7 mb-1">
            <label for="news-name" class="float-left">Titulo<span class="text-danger"> *</span></label>
            <input size="60" type="text" value="{{ $news['title'] ?? null }}" name="news[title]" id="news-name" class="border">
        </p>
        <p>
            <label for="news-name" class="float-left">Sumário</label>
            <textarea cols="60" rows="2" name="news[summary]" id="news_summary" class="border">{{ $news['summary'] ?? null }}</textarea>
        </p>
        <p>

            <label for="news-name" class="float-left">Descrição <span class="text-danger"> *</span></label>
            <vue-editor name="description" :content="'{{ $news->description ?? null }}'" :input_field="'content[description]'" :form_to="'news'"></vue-editor>
        </p>
        <p>
            <label class="float-left">Ficheiros</label>
            <span class="attachments_form">
                <span class="attachments_fields">
                </span>
                <span class="add_attachment" style="">
                    <input type="file" name="attachments[file]" class="file_selector filedrop" multiple="multiple" onchange="addInputFiles(this);" data-max-file-size="204800000" data-max-file-size-message="Este ficheiro não pode ser carregado pois excede o tamanho máximo permitido por ficheiro (195 MB)" data-max-concurrent-uploads="2" data-upload-path="/uploads.js" data-param="attachments" data-description="true" data-description-placeholder="Descrição opcional">
                    (Tamanho máximo: 195 MB)
                </span>
            </span>
        </p>
    </div>
</div>

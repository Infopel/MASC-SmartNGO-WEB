<div class="mb-3 bg-light rounded border p-2 pt-0" style="font-size: 90%;">
    <div class="tabular">
        <p class="col-md-7 mb-1">
            <label for="news-name" class="float-left">{{ __('lang.field_category') }}</label>

            <select name="documents[category]" id="" class="border w-50">
                <option value=""></option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </p>

        <p class="col-md-8 mb-1">
            <label for="news-name" class="float-left">{{ __('lang.field_title') }}<span class="text-danger"> *</span></label>
            <input size="60" type="text" value="" name="documents[title]" id="news-name" class="border">
        </p>
        <p class="col-md-10 mb-1">
            <label for="news-name" class="float-left">{{ __('lang.field_description') }}</label>
            <vue-editor name="description" :input_field="'content[description]'" :form_to="'documents'"></vue-editor>
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

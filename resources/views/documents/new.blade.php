@extends('layouts.main', ['title' => __('lang.label_document_new')])
@section('content')
    <div class="row m-0 p-2">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 col-lg-12 bg-white p-3">
                    <div class="d-flex mb-0">
                        <div class="flex-grow-1">
                            <h5>{{ __('lang.label_document_new') }}</h5>
                        </div>
                    </div>
                    <hr class="mt-0 mb-3">

                    {{-- error fontEnd handler --}}
                    @include('errors.any')
                    {{-- / error fontEnd handler --}}

                    <div class="">
                        <form action="{{ route('document.store', ['project_identifier' => $_project['identifier']]) }}" method="POST"  enctype="multipart/form-data">
                            @csrf
                            @include('documents._form')
                            <button>Cadastrar Arquivo</button>
                            <a href="{{ url()->previous() }}" class="link-option ml-2">Cancelar</a>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function addInputFiles(inputEl) {
        var attachmentsFields = $(inputEl).closest('.attachments_form').find('.attachments_fields');
        var addAttachment = $(inputEl).closest('.attachments_form').find('.add_attachment');
        var clearedFileInput = $(inputEl).clone().val('');
        var sizeExceeded = false;
        var param = $(inputEl).data('param');
        if (!param) { param = 'attachments' };
        sizeExceeded = uploadAndAttachFiles(inputEl.files, inputEl);
        if(sizeExceeded){
            $(inputEl).remove();
            clearedFileInput.prependTo(addAttachment);
        }
    }
    function uploadAndAttachFiles(files, inputEl) {
        // var maxFileSize = $(inputEl).data('max-file-size');
        var maxFileSize = 204800000;
        var maxFileSizeExceeded = $(inputEl).data('max-file-size-message');
        var sizeExceeded = false;
        $.each(files, function () {
            if (this.size && maxFileSize != null && this.size > parseInt(maxFileSize)) { sizeExceeded = true; }
        });
        if (sizeExceeded) {
            window.alert(maxFileSizeExceeded);
        }
        return sizeExceeded;
    }
</script>
@endsection

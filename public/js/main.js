/* ------------------------------------------------------------------------------
 *  # Main Script
 * ---------------------------------------------------------------------------- */

$(function() {
    // $('#app').on('change', 'input[data-disables], input[data-enables], input[data-shows]', toggleDisabledOnChange);
    // // toggleDisabledInit();

    // let url = location.href.replace(/\/$/, "");

    // if (location.hash) {
    //     const hash = url.split("#");
    //     $('#nav-tab a[href="#' + hash[1] + '"]').tab("show");

    //     url = location.href.replace(/\/#/, "#");
    //     history.replaceState(null, null, url);
    //     setTimeout(() => {
    //         $(window).scrollTop(0);
    //     }, 400);
    // }

    // $('a[data-toggle="tab"]').on("click", function () {
    //     let newUrl;
    //     const hash = $(this).attr("href");
    //     if (hash == "#home") {
    //         newUrl = url.split("#")[0];
    //     } else {
    //         newUrl = url.split("#")[0] + hash;
    //     }
    //     newUrl += "/";
    //     history.replaceState(null, null, newUrl);
    // });

    /* ------------------------------------------------------------------------------
     *  # Select2 selects
     * ---------------------------------------------------------------------------- */
    // Default initialization
    $(".select").select2({
        minimumResultsForSearch: Infinity
    });

    // Select with search
    $(".select-search").select2();
    /* ---------------------------------------------------------------------------- */
    // Groups checkboxs
    window.checkAll = function(id, checked) {
        this.console.log(id);
        $("#" + id)
            .find("input[type=checkbox]:enabled")
            .prop("checked", checked);
    };

    function toggleDisabledOnChange() {
        var checked = $(this).is(":checked");
        $($(this).data("disables")).attr("disabled", checked);
        $($(this).data("enables")).attr("disabled", !checked);
        $($(this).data("shows")).toggle(checked);
    }

    function toggleDisabledInit() {
        $("input[data-disables], input[data-enables], input[data-shows]").each(
            toggleDisabledOnChange
        );
    }

    $(document).on("change", "textarea", function() {
        $(this).data("changed", "changed");
    });

    /* ------------------------------ */
    // guess user timezone
    // $('#tz').val(moment.tz.guess())

    function forceNumericInt() {
        var $input = $(this);
        $input.val($input.val().replace(/[^\d]+/g, ""));
    }
    function forceNumericDecimal() {
        let input = $(this);
        input.val(input.val().replace(/[^\.\d]/g, ""));
    }
    $("body").on(
        "propertychange input",
        'input[cf_type="int"]',
        forceNumericInt
    );
    $("body").on(
        "propertychange input",
        'input[cf_type="decimal"]',
        forceNumericInt
    );
    $("body").on(
        "propertychange input",
        'input[cf_type="double"]',
        forceNumericInt
    );
    $("body").on(
        "propertychange input",
        'input[cf_type="float"]',
        forceNumericDecimal
    );

    $("body").on(
        "propertychange input",
        'input[input_type="int"]',
        forceNumericInt
    );
    $("body").on(
        "propertychange input",
        'input[input_type="decimal"]',
        forceNumericInt
    );
    $("body").on(
        "propertychange input",
        'input[input_type="double"]',
        forceNumericInt
    );
    $("body").on(
        "propertychange input",
        'input[input_type="float"]',
        forceNumericDecimal
    );

    /** ---------------------------------------------------- */
    /** Validar tamanho dos arquivos nos attachments */

    function addInputFiles(inputEl) {
        var attachmentsFields = $(inputEl)
            .closest(".attachments_form")
            .find(".attachments_fields");
        var addAttachment = $(inputEl)
            .closest(".attachments_form")
            .find(".add_attachment");
        // var clearedFileInput = $(inputEl).clone().val('');
        var sizeExceeded = false;
        var param = $(inputEl).data("param");
        if (!param) {
            param = "attachments";
        }
        sizeExceeded = uploadAndAttachFiles(inputEl.files, inputEl);
        if (sizeExceeded) {
            $(inputEl).remove();
            // clearedFileInput.prependTo(addAttachment);
        }
    }
    function uploadAndAttachFiles(files, inputEl) {
        var maxFileSize = $(inputEl).data("max-file-size");
        // var maxFileSize = 204800000;
        var maxFileSizeExceeded = $(inputEl).data("max-file-size-message");
        var sizeExceeded = false;
        $.each(files, function() {
            if (
                this.size &&
                maxFileSize != null &&
                this.size > parseInt(maxFileSize)
            ) {
                sizeExceeded = true;
            }
        });
        if (sizeExceeded) {
            window.alert(maxFileSizeExceeded);
        }
        return sizeExceeded;
    }
});

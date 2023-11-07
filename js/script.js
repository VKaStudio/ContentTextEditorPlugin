$ = jQuery.noConflict();
$(document).ready(function () {
    $('#test-plugin-search').on('click', function (e) {
        e.preventDefault();
        const alert = $('.output-alert');
        const output = $('.output');
        const text = $('#test-plugin-input').val();

        if (!text) {
            alert.text('input is empty');
            return;
        }

        const data = {
            action: 'content-text-editor-plugin-search-action',
            value: text,
        }

        jQuery.get(ajaxurl, data, function (response) {
            output.html(response);
        });
    });

    $('#test-plugin-input').keydown(function(e) {
        if (e.key === 'Enter') {
            $('#test-plugin-search').click();
        }
    });

    $(document).on('click', '.replace-btn', function (e) {
        e.preventDefault();
        const fieldKey = $(this).data('field');
        const oldText = $(this).data('old-keyword');
        const output = $('.output');
        const text = $(this).closest('.replace-form').find('input').val();
        let dataPostIds = [];

        $(".output [data-post-id]").each(function() {
            dataPostIds.push($(this).data("post-id"));
        });

        if (dataPostIds.length === 0 || !fieldKey || !oldText) return;

        const data = {
            action: 'content-text-editor-plugin-replace-action',
            field: fieldKey,
            ids: dataPostIds,
            oldText: oldText,
            text: text,
        }

        jQuery.post(ajaxurl, data, function (response) {
            output.html(response);
            $('#test-plugin-input').val(text);
            $('#test-plugin-search').click();
        });
    });
});
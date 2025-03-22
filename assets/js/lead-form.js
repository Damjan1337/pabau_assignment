jQuery(document).ready(function ($) {
    $('#lead-form').on('submit', function (e) {
        e.preventDefault();

        $('#form-response').removeClass('success error').html('');
        $('.submit-btn').prop('disabled', true).text('Submitting...');

        var formData = {
            action: 'process_lead_form',
            first_name: $('#first_name').val(),
            last_name: $('#last_name').val(),
            email: $('#email').val(),
            mobile: $('#mobile').val()
        };

        $.ajax({
            type: 'POST',
            url: lead_form_vars.ajax_url,
            data: formData,
            dataType: 'json'
        })
            .done(function (response) {
                if (response.success) {
                    $('#form-response').addClass('success').html(response.message);
                    $('#lead-form')[0].reset();
                } else {
                    $('#form-response').addClass('error').html(response.message || 'An error occurred. Please try again.');
                }
            })
            .fail(function (jqXHR) {
                var errorMsg = 'An error occurred. Please try again.';
                if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                    errorMsg = jqXHR.responseJSON.message;
                }
                $('#form-response').addClass('error').html(errorMsg);
            })
            .always(function () {
                $('.submit-btn').prop('disabled', false).text('Submit');
            });
    });
});

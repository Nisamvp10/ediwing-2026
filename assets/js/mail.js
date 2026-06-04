$('#conactForm').on('submit', function (e) {
    formData = new FormData(this);
    e.preventDefault();
    let formId = $('#conactForm');
    formData.append('send', true)
    formId.find('.is-invalid').removeClass('is-invalid');
    formId.find('.invalid-feedback').empty();
    $('#submitBtn').prop('disabled', true).html(
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...'
    );
    let comonBtn = `  <span class="gt-theme-btn-arrow-left">
                                                                <i class="fa-solid fa-arrow-up-right"></i>
                                                            </span>
                                                            <span class="gt-theme-btn">Get Free Academic Guidance</span>
                                                            <span class="gt-theme-btn-arrow-right">
                                                                <i class="fa-solid fa-arrow-up-right"></i>
                                                            </span>`;
    $.ajax({
        method: formId.attr('method'),
        url: 'mail.php',
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json',

        success: function (response) {
            if (response.status == 'success') {
                formId[0].reset();
                toastr.success(response.message);
                $('#submitBtn').prop('disabled', false).html(comonBtn);
            } else {
                if (response.validate) {
                    $.each(response.validate, function (key, value) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key + '_error').text(`${value}`);
                    });
                }
                $('#submitBtn').prop('disabled', false).html(comonBtn);
                alert(response.message);
            }
        }
    })
})
function showModal() {
    $('#createModal').modal('show');
}

function submitCreateForm() {
    var formData = new FormData($('#createForm')[0]);
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    formData.append('_token', csrfToken);

    $.ajax({
        type: 'POST',
        url: 'products', 
        data: formData,
        contentType: false, 
        processData: false,
        success: function(result) {
            alert(result.message);
            location.reload();
        },
        error: function (result) {
            var errors = result.responseJSON.errors;

        // Lặp qua từng trường và hiển thị thông báo lỗi
            for (var field in errors) {
                if (errors.hasOwnProperty(field)) {
                    var errorMessage = errors[field][0];
                    $('#' + field + '-error').text(errorMessage);
                }
            }
        }
    });
}
function previewImage() {
    var input = document.getElementById('create-image');
    var img = document.getElementById('show-image');
    var reader = new FileReader();

    reader.onload = function(e) {
        img.src = e.target.result;
    };

    reader.readAsDataURL(input.files[0]);
}
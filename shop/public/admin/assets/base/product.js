function previewImage(input_image, output_image) {
    var input = document.getElementById(input_image);
    var img = document.getElementById(output_image);
    var reader = new FileReader();

    reader.onload = function(e) {
        img.src = e.target.result;
    };

    reader.readAsDataURL(input.files[0]);
}


function submitCreateModal() {
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
                    $('#' + field + '-error-create').text(errorMessage);
                }
            }
        }
    });
}
function displayShowModal(product_id) {
    $.ajax({
            url: "/products/" + product_id,
            method: "GET",
            success: function(response) {
                if (response.hasOwnProperty('error')) {
                    console.error("Error loading product data: " + response.error);
                } else if (response.hasOwnProperty('product')) {
                    var product = response.product;
    
                    var categoriesHtml = "";
                    for (var i = 0; i < product.categories.length; i++) {
                        categoriesHtml += product.categories[i].name + "<br>";
                    }
    
                    var html = `
                        <td>${product.id}</td>  
                        <td>${product.images.length > 0 ? '<img src="upload/' + product.images[0].url + '" alt="Product Image" width="200px" height="200px">' : '<h4>#</h4>'} </td>
                        <td>${product.name}</td>
                        <td>${product.price}</td>
                        <td>${product.sale}</td>
                        <td>${categoriesHtml}</td>
                        <td>${product.description}</td>
                  `;
                  $("#productTableBody").html(html);
                }
            },
            error: function(error) {
                console.log("Error loading product data: " + error);
            }
          });
}
function displayEditModal(product_id){
    $.ajax({
        url: "/products/" + product_id+ "/edit",
        method: "GET",
        success: function(response) {
            if (response.hasOwnProperty('error')) {
                console.error("Error loading product data: " + response.error);
            } else if (response.hasOwnProperty('product')) {
                
                var product = response.product;
                $("#edit-id").val(product.id);
                $("#edit-name").val(product.name);
                $("#edit-price").val(product.price);
                $("#edit-sale").val(product.sale);
                $("#edit-description").val(product.description);
                $("#old-image").val(product.images[0].url);
                
                var imageName = product.images[0].url;
                $("#show-image-edit").attr("src", "upload/" + imageName);
                // get array of categories to compare
                var categoryIds = product.categories.map(function(category) {
                    return category.id;
                });
                $("#edit-category option").each(function() {
                    var categoryId = parseInt($(this).val());
                
                    // Kiểm tra xem categoryId có trong mảng ajaxCategoryIds không
                    if (categoryIds.indexOf(categoryId) !== -1) {
                        // Nếu có, đánh dấu option này là selected
                        $(this).prop("selected", true);
                    } else {
                        // Nếu không, đảm bảo option này không được chọn
                        $(this).prop("selected", false);
                    }
                });
                $("#editModal").modal("show");
            }
        },error: function (result) {
            alert('loi');
        }
    });
}
function submitEditModal() {
    var formData = new FormData($('#editForm')[0]);
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
                    $('#' + field + '-error-create').text(errorMessage);
                }
            }
        }
    });
}

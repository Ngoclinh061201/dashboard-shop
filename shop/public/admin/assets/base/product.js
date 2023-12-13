
$(document).ready(function () {
    $('.modal').on('hidden.bs.modal', function () {
        var inputs = document.querySelectorAll('.modal-body input');
        inputs.forEach(function(input) {
            input.value = '';
        });
        document.getElementById('show-image-create').src = '';
        $('#productTableBody').empty();
    });
});

function storeProduct() {
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
            for (var field in errors) {
                if (errors.hasOwnProperty(field)) {
                    var errorMessage = errors[field][0];
                    $('#' + field + '-error-create').text(errorMessage);
                }
            }
        }
    });
}

function showProduct(product_id) {
    $.ajax({
            url: "/products/" + product_id,
            method: "GET",
            success: function(response) {
                if (response.hasOwnProperty('product')) {
                    var product = response.product;
                    var categoriesHtml = "";
                    for (var i = 0; i < product.categories.length; i++) {
                        categoriesHtml += `${product.categories[i].name}<br>`;
                    }
                    var productHTML = `<tr>
                                          <td>${product.id}</td>
                                          <td>${product.images.length > 0 ? `<img src="upload/${product.images[0].url}" alt="Product Image" width="200px" height="200px">` : '<h4>#</h4>'}</td>
                                          <td>${product.name}</td>
                                          <td>${product.price}</td>
                                          <td>${product.sale}</td>
                                          <td>${categoriesHtml}</td>
                                          <td>${product.description}</td>
                                      </tr>`;

                        $('#showModal #productTableBody').append(productHTML);
                    
                    $('#showModal').modal('show');
                }
            },
            error: function(error) {
                alert("Error " + error);
            }
          });
}

function editProduct(product_id){
    $.ajax({
        url: "/products/" + product_id+ "/edit",
        method: "GET",
        success: function(response) {
            if (response.hasOwnProperty('product')) {
                
                var product = response.product;
                $("#edit-id").val(product.id);
                $("#edit-name").val(product.name);
                $("#edit-price").val(product.price);
                $("#edit-sale").val(product.sale);
                $("#edit-description").val(product.description);
                $("#old-image").val(product.images[0].url);
                
                var imageName = product.images[0].url;
                $("#show-image-edit").attr("src", "upload/" + imageName);
                var categoryIds = product.categories.map(function(category) {
                    return category.id;
                });
                $("#edit-category option").each(function() {
                    var categoryId = parseInt($(this).val());
                    if (categoryIds.indexOf(categoryId) !== -1) {
                        $(this).prop("selected", true);
                    } else {
                        $(this).prop("selected", false);
                    }
                });
                $("#editModal").modal("show");
            }
        },error: function (response) {
            alert('Error' + response.message);
        }
    });
}

function updateProduct() {
    var productId = $('#edit-id').val();
    var formData = new FormData($('#editFormProduct')[0]);
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    formData.append('_token', csrfToken);
    formData.append('_method', 'PUT');
   
    $.ajax({
        type: 'POST',
        url: '/products/' + productId,
        dataType: 'json',
        data: formData,
        contentType: false, 
        processData: false,
        success: function(response) {
            alert('Success' + response.message);
            location.reload();
        },
        error: function (response) {
            var errors = response.responseJSON.errors;
            for (var field in errors) {
                if (errors.hasOwnProperty(field)) {
                    var errorMessage = errors[field][0];
                    $('#' + field + '-error-edit').text(errorMessage);
                }
            }
        }
    });
}

function searchProduct() {
    var searchCategory = document.getElementById('searchCategory').value;   
    var searchInput = document.getElementById('searchInput').value;
    $.ajax({
        url: '/products',
        type: 'GET',
        data: {
            searchCategory: searchCategory,
            searchInput: searchInput
        },
        success: function(response) {
            if (response.hasOwnProperty('product')) {
                var products = response.product.data;
                var roleUsers = response.roles.map(role => role.name);
                productsLength = products.length;
                $('#searchProductsIndex').empty(); // xoa du lieu cua view index
                $('#paginationLinks').hide();
                if(productsLength >0){
                    for (var i = 0; i < productsLength; i++) {
                        var product = products[i];
                        var productHTML = `
                            <tr>
                                <td>${product.id}</td>
                                <td>${product.images.length > 0 ? `<img src="upload/${product.images[0].url}" alt="Product Image" width="100px" height="100px">` : '<h4>#</h4>'}</td>
                                <td>${product.name}</td>
                                <td>${product.price}</td>
                                <td>${product.sale}</td>
                                <td>${product.categories.map(category => category.name).join('<br>')}</td>
                                <td>
                                    <div style="display: flex;">
                                        <button type="button" class="btn btn-success" style="margin-left: 5px;" data-bs-toggle="modal" data-bs-target="#showModal" onclick="displayShowModal(${product.id})">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        ${roleUsers.some(role => ['admin','super-admin'].includes(role)) ? `
                                            <button type="button" class="btn btn-warning" style="margin-left: 5px;" data-bs-toggle="modal" data-bs-target="#editModal" onclick="displayEditModal(${product.id})">
                                                <i class="fas fa-edit"></i>
                                            </button>` : ''
                                        }
                                        ${roleUsers.some(role => ['super-admin'].includes(role)) ? `
                                            <button type="button" class="btn btn-danger" style="margin-left: 5px;" onclick="handleDelete(${product.id})">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>` : ''
                                        }
                                        
                                    </div>
                                </td>
                            </tr>
                        `;
                    
                        $('#searchProductsIndex').append(productHTML); 
                    }
                }else {
                    $('#searchProductsIndex').append('<tr><td colspan="7" style="text-align: center;">Không có kết quả</td></tr>');
                }
            }
            
        },error:function(error) {
            alert('Error ' + error.message);
        }
    });
}

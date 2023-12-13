//setup token 
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

$(document).on("click", ".btn-delete", function (e) {
    e.preventDefault();
    let id = $(this).data("id");
    confirmDelete()
        .then(function () {
            $(`#form-delete${id}`).submit();
        })
        .catch();
});

function confirmDelete() {
    return new Promise((resolve, reject) => {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                resolve(true);
            } else {
                reject(false);
            }
        });
    });
}
     
function search() {
    var searchTerm = document.getElementById('searchInput').value;
    var currentUrl = new URL(window.location.href);
    currentUrl.searchParams.set('search', searchTerm);
    window.location.href = currentUrl.toString();
} 

function resetSearch() {
    document.getElementById('searchInput').value = '';
    var urlWithoutQuery = window.location.href.split('?')[0];
    history.pushState({}, document.title, urlWithoutQuery);
    window.location.reload();
}

function previewImage(input_image, output_image) {
    var input = document.getElementById(input_image);
    var img = document.getElementById(output_image);
    var reader = new FileReader();

    reader.onload = function(e) {
        img.src = e.target.result;
    };
    reader.readAsDataURL(input.files[0]);
}
    

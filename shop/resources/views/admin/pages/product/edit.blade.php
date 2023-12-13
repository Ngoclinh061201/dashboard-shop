<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <form id ="editFormProduct">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
          </div>
          <div class="modal-body">
            <div class="container-fluid">
                <div class="row mb-3">
                  <div class="col-md-6">
                      <div class="input-group-static">
                          <label>Create New Image</label>
                          <input type="file" accept="image/*" class="form-control" id="edit-image" name="image"placeholder="Image" onchange="previewImage('edit-image', 'show-image-edit')">
                          <input type="text"  class="form-control" id="old-image" style="display: none;">
                          <input type="text" class="form-control" id="edit-id" style="display: none;" >
                          </div>

                      <div class="input-group-static mt-6">
                          <label>Name</label>
                          <input type="text" value="{{ old('name') }}" class="form-control" id="edit-name" name="name" placeholder="Name" >
                          <span id="name-error-edit" class="text-danger"></span>
                      </div>
                  </div>
                  <div class="col-md-6">
                    <div class="input-group-static" style="max-width: 100%; max-height: 100%;">
                        <img src="" id="show-image-edit" alt="Image Preview" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                    </div>
                </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-4">
                    <div class="input-group-static">
                      <label>Price</label>
                      <input type="number" value="{{ old('price') }}" class="form-control" id="edit-price" name="price" placeholder="Price" >
                      <span id="price-error-edit" class="text-danger"></span>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="input-group-static">
                      <label>Sale</label>
                      <input type="number" value="{{ old('sale') }}" class="form-control" id="edit-sale" name="sale" placeholder="Sale" >
                      <span id="sale-error-edit" class="text-danger"></span>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <label class="">Category</label>
                    <div class="form-group">
                        <select class="form-control" multiple="multiple" id="edit-category" name="category_ids[]">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <span id="category-error-edit" class="text-danger"></span>
                    </div>
                  </div>
                </div>
                
                <div class="col-md-12 mb-3">
                  <div class="input-group-static">
                    <label>Description</label>
                    <input type="text" value="{{ old('description') }}" class="form-control" id="edit-description" name="description" placeholder="description" >
                    <span id="description-error-edit" class="text-danger"></span>
                  </div>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn bg-gradient-info" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn bg-gradient-primary" onclick="updateProduct()">Save changes</button>
          </div>
        </div>
      </div>
    </form>
  </div>
  
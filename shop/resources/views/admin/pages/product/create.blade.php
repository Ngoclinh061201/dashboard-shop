<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <form id ="createForm">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="createModalLabel">Create Product</h5>
          </div>
          <div class="modal-body">
            <div class="container-fluid">
              <div class="row mb-3">
                <div class="col-md-6">
                    <div class="input-group-static">
                        <label>Image</label>
                        <input type="file" accept="image/*" class="form-control" id="create-image" name="image"placeholder="Image" onchange="previewImage()">
                        {{-- <span id="image-error" class="text-danger"></span> --}}
                    </div>
                    <div class="input-group-static mt-6">
                        <label>Name</label>
                        <input type="text" value="{{ old('name') }}" class="form-control" id="create-name" name="name" placeholder="Name" >
                        <span id="name-error" class="text-danger"></span>
                    </div>
                </div>
                <div class="col-md-6 ml-auto">
                  <div class="input-group-static">
                    <img src="" id="show-image" alt="Image Preview">
                  </div>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-md-6">
                  <div class="input-group-static">
                    <label>Price</label>
                    <input type="number" value="{{ old('price') }}" class="form-control" id="create-price" name="price" placeholder="Price" >
                    <span id="price-error" class="text-danger"></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="input-group-static">
                    <label>Sale</label>
                    <input type="number" value="{{ old('sale') }}" class="form-control" id="create-sale" name="sale" placeholder="Sale" >
                    <span id="sale-error" class="text-danger"></span>
                  </div>
                </div>
              </div>
              <div class="col-md-12 mb-3">
                <label class="">Category</label>
                <div class="form-group">
                    <select class="form-control" multiple="multiple" id="create-category" name="category_ids[]">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
              </div>
              <div class="col-md-12 mb-3">
                <div class="input-group-static">
                  <label>Description</label>
                  <input type="text" value="{{ old('description') }}" class="form-control" id="create-description" name="description" placeholder="description" >
                  <span id="description-error" class="text-danger"></span>
                </div>
              </div
            </div>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn bg-gradient-info" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn bg-gradient-primary">Save changes</button>
          </div>
        </div>
      </div>
    </form>
</div>

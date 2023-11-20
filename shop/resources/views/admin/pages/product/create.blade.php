@extends('admin.layouts.app')
@section('title', 'Create Product')
@section('content')
  
  <!-- Navbar -->
      <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
        <div class="container-fluid py-1 px-3">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
              <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
              <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Product</li>
            </ol>
            <h6 class="font-weight-bolder mb-0">Product</h6>
          </nav>

        </div>
      </nav>
      <!-- End Navbar -->
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header" >
                <h1> Create Product</h1>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="{{route('products.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class ="row">
                        <div class="input-group-static col-5 mb-4">
                            <label>Image</label>
                            <input type="file" accept="image/*" class="form-control" name="image" id="image-input" placeholder="Image" onchange="previewImage()">
                            
                            @error('image')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-5">
                            <img src="" id="show-image" alt="Image Preview">
                        </div>
                    </div>
                    
                    <div class="input-group input-group-static mb-4">
                            <label>Name</label>
                            <input type="text" value = "{{old('name')}}"class="form-control"name="name" placeholder="Name" required>
                            @error('name')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                    </div>  
                    <div class="input-group input-group-static mb-4">
                            <label>Price</label>
                            <input type="number" value = "{{old('price')}}"class="form-control"name="price" placeholder="price" required>
                            @error('price')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                    </div>
                    <div class="input-group input-group-static mb-4">
                        <label>Sale</label>
                        <input type="number" value="{{ old('sale') }}" class="form-control" name="sale" placeholder="sale" required>
                        @error('sale')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="input-group input-group-static mb-4">
                        <label>Description</label>
                        <textarea id="editor" name="description" required>{{ old('description') }}</textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                   
                    
                    
                    <div class ="form-group"
                                    @foreach ($categories as $category)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{$category->id}}" name="category_ids[]">
                                            <label class="custom-control-label" for="">{{$category->name}}</label>
                                        </div>
                                    @endforeach
                            
                       
                              
                    </div>
                
                    <button type="submit" class="btn btn-submit btn-primary">Submit</button> 
                
                </form>
            </div>
        </div>
    </div>
    <script>
        function previewImage() {
            var input = document.getElementById('image-input');
            var img = document.getElementById('show-image');
            var reader = new FileReader();
    
            reader.onload = function(e) {
                img.src = e.target.result;
            };
    
            reader.readAsDataURL(input.files[0]);
        }
    </script>
@endsection
@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => {
            console.error(error);
        });
</script>


@extends('admin.layouts.app')
@section('title', 'Create Categories')
@section('content')
  
  <!-- Navbar -->
      <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
        <div class="container-fluid py-1 px-3">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
              <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
              <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Category</li>
            </ol>
            <h6 class="font-weight-bolder mb-0">Category</h6>
          </nav>

        </div>
      </nav>
      <!-- End Navbar -->
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header" >
                <h1> Create Category</h1>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="{{route('categories.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    
                    <div class="input-group input-group-static mb-4">
                            <label>Name</label>
                            <input type="text" value = "{{old('name')}}"class="form-control"name="name" placeholder="Name">
                            @error('name')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                    </div>  
                    
                    
                    <div class="input-group input-group-static mb-4">
                        <label name="parent_id" class="ms-0">Parent Categories</label>
                        <select name="parent_id"  class="form-control">
                            @foreach ($parentCategories as $item)
                                <option value="{{$item->id}}" {{old('parent_id') == $item->id ? 'selected' : ''}}>
                                    {{$item->name}}</option>
                            @endforeach
                          
                        </select>
                        @error('parent_id')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
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


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
                <h1> Product Detail</h1>
                
                @if (session()->has('success'))
                            <div class="alert alert-success">
                                {{ session()->get('success') }}
                            </div>
                @endif
  
            </div>

            <div class="card-body">
                <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                  <a href="javascript:history.back()"}}" class="btn btn-info">
                    <i class="fas fa-arrow-left"></i> 
                  </a>
              
                  <a href="{{ route('products.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                </div>

                
                <table class="table table-hover">
                    <tr>
                      <th>#</th>
                      <th>Image</th>
                      <th>Name</th>
                      <th>Email</th> 
                      <th>Phone</th> 
                      <th>Action</th>
                    </tr>
                    
                    <tr>
                      <td>{{$product->id}}</td>
                      <td>
                        @if($product->images->isNotEmpty())
                        
                            <img src="{{ asset('upload/products/'.$product->images()->latest()->first()->url) }}" alt="Product Image" width="200px" height="200px">
                        @else
                          <h4>#</h4>
                        @endif
                    </td>
                      <td>{{$product->name}}</td>
                      <td>{{$product->email}}</td>
                      <td>{{$product->phone}}</td>
                      <td>
                        <div style="display: flex;">
                        {{-- <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit</a> --}}
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-info">
                          <i class="fas fa-eye"></i> 
                        </a>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning" style="margin-left: 5px;">
                          <i class="fas fa-edit"></i> 
                        </a>


                        {{-- <button href="{{ route('products.destroy', $product->id) }}"  class="btn btn-danger">Delete</button> --}}
                        <form method="POST" action="{{ route('products.destroy',  $product->id) }}" onsubmit="return confirm('Are you sure you want to delete?')">
                          @method('DELETE')
                          @csrf
                          <button class="btn btn-danger" type="submit" style="margin-left: 5px;" data-toggle="tooltip" data-placement="top" title="Delete">
                              <i class="fas fa-trash-alt"></i>
                          </button>
                        </form>
                      </div>
                      </td> 
                  </tr>
                    
                </table
                
            </div>
        </div>
      
      </div>
      <script>
        function search() {
            // Lấy giá trị từ ô nhập
            var searchTerm = document.getElementById('searchInput').value;
      
            // Lấy URL hiện tại
            var currentUrl = new URL(window.location.href);
      
            // Cập nhật hoặc thêm query parameter 'search'
            currentUrl.searchParams.set('search', searchTerm);
      
            // Chuyển hướng đến URL mới
            window.location.href = currentUrl.toString();
        }
        function resetSearch() {
              // Xóa giá trị của input search
              document.getElementById('searchInput').value = '';
      
              // Xóa các query trong URL (nếu có)
              var urlWithoutQuery = window.location.href.split('?')[0];
              history.pushState({}, document.title, urlWithoutQuery);
          }
      </script>
      
@endsection
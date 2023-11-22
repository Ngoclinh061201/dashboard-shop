@extends('admin.layouts.app')
@section('title', 'Products')
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
                <h1> Product list</h1>
                
                @if (session()->has('success'))
                            <div class="alert alert-success">
                                {{ session()->get('success') }}
                            </div>
                @endif
  
            </div>

            <div class="card-body">
                <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                  <a href="javascript:history.back()" class="btn btn-info">
                    <i class="fas fa-arrow-left"></i> 
                  </a>
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class="fas fa-plus"></i> 
                  </button>

                  
                </div>

                <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                  <div class="search-container" style="flex-grow: 1; display: flex; align-items: center;">
                    <div style=" width: 80%; "> <!-- Thay đổi ở đây -->
                      <input name="search" type="text" id="searchInput" placeholder="Search..." style="width: 100%; padding: 10px;"value="{{ isset($searchTerm) ? $searchTerm : '' }}">
                    </div>
              
                    <button type="button" onclick="search()" style="margin-left: 10px; background-color: #4CAF50; color: white; border: none; padding: 10px; border-radius: 5px;">
                        Search
                    </button>
                    <button style="background-color: #ff0000; color: white; border: none; padding: 10px; border-radius: 5px; margin-left:10px">
                      <a href="{{ route('products.index') }}" style="text-decoration: none; color: inherit;">
                          Reset
                      </a>
                    </button>
                  </div>
                </div>
                <table class="table table-hover">
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th> 
                        <th>Sale</th> 
                        <th>Category</th> 
                        <th>Action</th>
                    </tr>
                    @foreach ($products as $product)
                    <tr>
                        <td>{{$product->id}}</td>
                        <td>
                          @if($product->images->isNotEmpty())
                              <img src="{{ asset('upload/'.$product->images->first()->url) }}" alt="Product Image" width="100px" height="100px">
                              @else
                              <img src="{{ asset('upload/default.png') }}" alt="User Image" width="100px" height="100px">
                            @endif 
                        </td>
                        <td>{{$product->name}}</td>
                        <td>{{$product->price}}</td>
                        <td>{{$product->sale}}</td>
                        <td>
                          @foreach($product->categories as $category)
                              {{$category->name}}<br>
                          @endforeach
                        </td>
                        <td>
                          <div style="display: flex;">
                         
                            <button type="button" class="btn btn-info" style = " margin-left: 5px;"data-bs-toggle="modal" data-bs-target="#showModal" onclick="displayShowModal({{$product->id}})">
                              <i class="fas fa-eye"></i> 
                            </button>
                              @include('admin.pages.product.show')
                            <button type="button" class="btn btn-warning" style = " margin-left: 5px;"data-bs-toggle="modal" data-bs-target="#editModal" onclick="displayEditModal({{$product->id}})">
                              <i class="fas fa-edit"></i> 
                            </button>
                              @include('admin.pages.product.edit')
                            <form action="{{ route('products.destroy', $product->id) }}"
                              id="form-delete{{$product->id}}" method="post">
                              @csrf
                              @method('delete')
                            </form>
                            <button class="btn btn-delete btn-danger" style = " margin-left: 5px;" data-id={{ $product->id }}>
                              <i class="fas fa-trash-alt"></i></button>
                          </div>
                        </td> 
                    </tr>
                    @endforeach
                </table
                {{  $products->links()  }}
            </div>
        </div>
      </div>
@include('admin.pages.product.create')


      
@endsection
@section('scripts')
     <script src="{{asset ('admin/assets/base/product.js')}}" ></script>

@endsection

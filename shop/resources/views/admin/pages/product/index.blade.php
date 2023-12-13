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
                  @if( auth()->user()->hasAnyRole(['admin', 'super-admin']) )
                      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                          <i class="fas fa-plus"></i> 
                      </button>
                  @endif
                                    
                  
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <div class="input-group input-group-outline my-3">
                      <select class="form-control" id="searchCategory">
                        <option value="">All</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="input-group input-group-outline my-3">
                        <input name="search" type="text" class="form-control" id="searchInput" value="{{ isset($searchTerm) ? $searchTerm : '' }}">
                    </div>
                  </div>
                  <div class="col-md-3">
                        <button type="button" class="btn btn-primary" style =" margin-left:5px; margin-top:15px" onclick="searchProduct()" >
                          <i class="fas fa-search"></i> 
                        </button>
                        <button type="button" class="btn btn-danger" style =" margin-left:5px ; margin-top:15px" onclick="resetSearch()" >
                          <i class="fas fa-trash-alt"></i> 
                        </button>
                  </div>
                </div>
                <table class="table table-hover">
                  <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th> 
                        <th>Sale</th> 
                        <th>Category</th> 
                        <th>Action</th>
                    </tr>
                  </thead>
                  <tbody id = "searchProductsIndex">
                    @foreach ($products as $product)
                    <tr>
                        <td>{{$product->id}}</td>
                        <td>
                          <img class="img-fluid border-radius-lg" src="{{ $product->image_url }}" alt="Product Image" width="100px" height="100px">
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
                         
                            <button type="button" class="btn btn-success" style = " margin-left: 5px;"onclick="showProduct({{$product->id}})">
                              <i class="fas fa-eye"></i> 
                            </button>
                            @if( auth()->user()->hasAnyRole(['admin', 'superadmin']))
                            <button type="button" class="btn btn-warning" style = " margin-left: 5px;" onclick="editProduct({{$product->id}})">
                              <i class="fas fa-edit"></i> 
                            </button>
                            @endif
                            <form action="{{ route('products.destroy', $product->id) }}"
                              id="form-delete{{$product->id}}" method="post">
                              @csrf
                              @method('delete')
                            </form>
                            @if( auth()->user()->hasAnyRole('super-admin'))
                            <button class="btn btn-delete btn-danger" style = " margin-left: 5px;" data-id={{ $product->id }}>
                              <i class="fas fa-trash-alt"></i></button>
                            @endif
                          </div>
                        </td> 
                    </tr>
                    @endforeach
                  </tbody>
                  </table>
                  <div id="paginationLinks">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
      </div>

@include('admin.pages.product.create')
@include('admin.pages.product.edit')
@include('admin.pages.product.show')    

@endsection
@section('scripts')
<script src="{{asset ('admin/assets/base/base.js')}}" ></script>
<script src="{{asset ('admin/assets/base/product.js')}}" ></script>

@endsection

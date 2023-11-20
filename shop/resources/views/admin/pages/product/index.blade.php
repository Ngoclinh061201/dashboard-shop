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
              
                  <a href="javascript:void(0)" class="btn btn-primary" data-toggle="modal" data-target="#createModal" onclick="showModal()">
                    <i class="fas fa-plus"></i>
                </a>
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
                          <div style="display: flex;">
                          {{-- <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit</a> --}}
                          <a href="{{ route('products.show', $product->id) }}" class="btn btn-info">
                            <i class="fas fa-eye"></i> 
                          </a>
                          <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning" style="margin-left: 5px;">
                            <i class="fas fa-edit"></i> 
                          </a>


                          {{-- <button href="{{ route('products.destroy', $product->id) }}"  class="btn btn-danger">Delete</button> --}}
                          <form action="{{ route('categories.destroy', $product->id) }}"
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

      <!-- Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="createModalLabel">Create asvdaProduct</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <!-- Add your form elements here -->
              <form id="createForm">
                  <!-- Your form fields go here -->
              </form>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" onclick="submitForm()">Save changes</button>
          </div>
      </div>
  </div>
</div>
<script>
  // Function to show modal
  function showModal() {
      $('#createModal').modal('show');
  }

  // Function to submit form (you can customize this)
  function submitForm() {
      // Do your form submission logic here

      // Close the modal
      $('#createModal').modal('hide');
  }
</script>
@endsection
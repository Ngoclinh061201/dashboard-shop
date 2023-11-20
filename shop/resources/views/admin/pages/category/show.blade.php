@extends('admin.layouts.app')
@section('title', 'Create Category')
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
                <h1> Category Detail</h1>
                
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
            
                <a href="{{ route('categories.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
              </div>

              
              <table class="table table-hover">
                  <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Parent_name</th> 
                      <th>Action</th> 
                  </tr>
                 
                  <tr>
                      <td>{{$category->id}}</td>
                      
                      <td>{{$category->name}}</td>
                      <td>{{$category->parent_name}}</td>
                    
                      <td>
                        <div style="display: flex;">
                       
                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning" style="margin-left: 5px;">
                          <i class="fas fa-edit"></i> 
                        </a>

                        <form action="{{ route('categories.destroy', $category->id) }}"
                          id="form-delete{{$category->id}}" method="post">
                          @csrf
                          @method('delete')

                        </form>

                        <button class="btn btn-delete btn-danger" style = " margin-left: 5px;" data-id={{ $category->id }}>
                          <i class="fas fa-trash-alt"></i></button>

                      </div>
                      </td> 
                  </tr>
                  
              </table
              {{-- {{  $categories->links()  }} --}}
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
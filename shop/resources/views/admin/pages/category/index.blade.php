@extends('admin.layouts.app')
@section('title', 'Categories')
@section('content')
  
  <!-- Navbar -->
      <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
        <div class="container-fluid py-1 px-3">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
              <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
              <li class="breadcrumb-item text-sm text-dark active" aria-current="page">User</li>
            </ol>
            <h6 class="font-weight-bolder mb-0">User</h6>
          </nav>

        </div>
      </nav>
      <!-- End Navbar -->
      <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header" >
                <h1> Categoy list</h1>
                
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
              
                  <a href="{{ route('categories.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
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
                      <a href="{{ route('categories.index') }}" style="text-decoration: none; color: inherit;">
                          Reset
                      </a>
                    </button>
                  </div>
                </div>
                <table class="table table-hover">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Parent_name</th> 
                        <th>Action</th> 
                    </tr>
                   @foreach ($categories as $category)
                    <tr>
                        <td>{{$category->id}}</td>
                        
                        <td>{{$category->name}}</td>
                        <td>{{$category->parent_name}}</td>
                      
                        <td>
                          <div style="display: flex;">
                         
                          <a href="{{ route('categories.show', $category->id) }}" class="btn btn-info">
                            <i class="fas fa-eye"></i> 
                          </a>
                          <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning" style="margin-left: 5px;">
                            <i class="fas fa-edit"></i> 
                          </a>

                          <form method="POST" action="{{ route('categories.destroy',  $category->id) }}" onsubmit="return confirm('Are you sure you want to delete?')">
                            @method('DELETE')
                            @csrf
                            <button class="btn btn-danger" type="submit" style="margin-left: 5px;" data-toggle="tooltip" data-placement="top" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                          </form>
                        </div>
                        </td> 
                    </tr>
                    @endforeach 
                </table
                {{  $categories->links()  }}
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
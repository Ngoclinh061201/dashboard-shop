@extends('admin.layouts.app')

@section('content')
  
  <!-- Navbar -->
      <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
        <div class="container-fluid py-1 px-3">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
              <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
              <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Role</li>
            </ol>
            <h6 class="font-weight-bolder mb-0">Role</h6>
          </nav>

        </div>
      </nav>
      <!-- End Navbar -->
      <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header" >
                <h1> Role list</h1>
                
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
              
                  <a href="{{ route('roles.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                </div>
                <div class="row">
                  <div class="col-md-9">
                    <div class="input-group input-group-outline my-3">
                        <input name="search" type="text" class="form-control" id="searchInput" value="{{ isset($searchTerm) ? $searchTerm : '' }}">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <button type="button" class="btn btn-primary" style =" margin-left:5px; margin-top:15px" onclick="search()" >
                      <i class="fas fa-search"></i> 
                    </button>
                    <button type="button" class="btn btn-danger" style =" margin-left:5px ; margin-top:15px" onclick="resetSearch()" >
                      <i class="fas fa-trash-alt"></i> 
                    </button>
                  </div>
                </div>
                <table class="table table-hover">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Display-Name</th> 
                        <th>Actionn</th>
                    </tr>
                    @foreach ($roles as $role)
                    <tr>
                        <td>{{$role->id}}</td>
                        <td>{{$role->name}}</td>
                        <td>{{$role->display_name}}</td>
                        <td>
                          <div style="display: flex;">
                          {{-- <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning">Edit</a> --}}
                          <a href="{{ route('roles.show', $role->id) }}" class="btn btn-success">
                            <i class="fas fa-eye"></i> 
                          </a>
                          <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning" style="margin-left: 5px;">
                            <i class="fas fa-edit"></i> 
                          </a>


                          {{-- <button href="{{ route('roles.destroy', $role->id) }}"  class="btn btn-danger">Delete</button> --}}
                          <form method="POST" action="{{ route('roles.destroy',  $role->id) }}" onsubmit="return confirm('Are you sure you want to delete?')">
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
                  </table>
                {{ $roles->links() }}
            </div>
        </div>
      
      </div>
 
@endsection
@section('scripts')
<script src="{{asset ('admin/assets/base/base.js')}}" ></script>

@endsection
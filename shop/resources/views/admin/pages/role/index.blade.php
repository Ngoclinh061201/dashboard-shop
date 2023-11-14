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
                
                @if(session('message'))
                <h1 clas="text-primary"
                  {{ session('message') }}
                </h1>
                @endif
            </div>

            <div class="card-body">
                <div>
                    <a href="{{ route('roles.create') }}" class="btn btn-primary">Create</a>
                </div>
                <table class="table table-hover">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Display-Name</th> 
                        <th>Actionn</th>
                    </tr>
                    @foreach ($data as $role)
                    <tr>
                        <td>{{$role->id}}</td>
                        <td>{{$role->name}}</td>
                        <td>{{$role->display_name}}</td>
                        <td>
                          <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning">Edit</a>
                          <button href="{{ route('roles.destroy', $role->id) }}"  class="btn btn-danger">Delete</button>
                        </td> 
                    </tr>
                    @endforeach
                </table
            </div>
        </div>
      
      </div>
@endsection
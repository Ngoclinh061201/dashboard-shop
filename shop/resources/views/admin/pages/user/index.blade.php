@extends('admin.layouts.app')
@section('title', 'Users')
@section('titlePage', 'User')
@section('content')
      <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header" >
                <h2> User List</h2>
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
              
                  <a href="{{ route('users.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
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
                        <th>Image</th>
                        <th>Name</th>
                        <th>Email</th> 
                        <th>Phone</th> 
                        <th>Action</th>
                    </tr>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{$user->id}}</td>
                        <td>
                          @if($user->images->isNotEmpty())
                              <img src="{{ asset('upload/'.$user->images->first()->url) }}" alt="User Image" width="100px" height="100px">
                          @else
                            <img src="{{ asset('upload/default.png') }}" alt="User Image" width="100px" height="100px">
                          @endif
                      </td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->phone}}</td>
                        <td>
                          <div style="display: flex;">
                          <a href="{{ route('users.show', $user->id) }}" class="btn btn-success">
                            <i class="fas fa-eye"></i> 
                          </a>
                          <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning" style="margin-left: 5px;">
                            <i class="fas fa-edit"></i> 
                          </a>


                          {{-- <button href="{{ route('users.destroy', $user->id) }}"  class="btn btn-danger">Delete</button> --}}
                          <form method="POST" action="{{ route('users.destroy',  $user->id) }}" onsubmit="return confirm('Are you sure you want to delete?')">
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
                {{  $users->links()  }}
            </div>
        </div>
      </div>
@endsection
@section('scripts')
<script src="{{asset ('admin/assets/base/base.js')}}" ></script>
@endsection
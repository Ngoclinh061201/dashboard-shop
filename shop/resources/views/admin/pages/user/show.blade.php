@extends('admin.layouts.app')
@section('title', 'Create User')
@section('titlePage', 'User')
@section('content')
  <div class="container-fluid py-4">
    <div class="card">
        <div class="card-header" >
            <h2> User Detail</h2>
        </div>
        <div class="card-body">
            <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
              <a href="javascript:history.back()"}}" class="btn btn-info">
                <i class="fas fa-arrow-left"></i> 
              </a>
          
              <a href="{{ route('users.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
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
                  <td>{{$user->id}}</td>
                  <td>
                    @if($user->images->isNotEmpty())
                        <img src="{{ asset('upload/'.$user->images()->latest()->first()->url) }}" alt="User Image" width="200px" height="200px">
                    @else
                      <h4>#</h4>
                    @endif
                </td>
                  <td>{{$user->name}}</td>
                  <td>{{$user->email}}</td>
                  <td>{{$user->phone}}</td>
                  <td>
                    <div style="display: flex;">
                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-info">
                      <i class="fas fa-eye"></i> 
                    </a>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning" style="margin-left: 5px;">
                      <i class="fas fa-edit"></i> 
                    </a>
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
            </table>
        </div>
    </div>
  </div> 

@endsection
@section('scripts')
<script src="{{asset ('admin/assets/base/base.js')}}" ></script>
@endsection
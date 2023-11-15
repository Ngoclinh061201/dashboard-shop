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
                <h1> Edit Role</h1>
            </div>
            <div class="card-body">
                <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                    <a href="javascript:history.back()"}}" class="btn btn-info">
                      <i class="fas fa-arrow-left"></i> 
                    </a>
                
                    <a href="{{ route('roles.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                  </div>
                <form class="form-horizontal" action="{{route('roles.update', $role->id),}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="input-group input-group-static mb-4">
                            <label>Name</label>
                            <input type="text" value = "{{old('name') ?? $role->name }}"class="form-control"name="name" placeholder="Name">
                            @error('name')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                    </div>  
                    <div class="input-group input-group-static mb-4">
                            <label>Display Name</label>
                            <input type="text" value = "{{old('display_name') ?? $role->display_name }}"class="form-control"name="display_name" placeholder="Name">
                            @error('display_name')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                    </div>
                    <div class="input-group input-group-static mb-4">
                        <label name="group" class="ms-0">Group</label>
                        <select name="group"  class="form-control" value = "{{$role->group}}">
                          <option value="system">System</option>
                          <option value="user">User</option>
                         
                        </select>
                        @error('group')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                    </div>
                    <div class ="form-group"
                        <label class="" for="">Permissions</label>
                        <div class="row">
                        @foreach ($permissions as $group => $permissions)
                            <div class="col-5"
                                <strong>{{ ucfirst($group)}}</strong>
                             
                                <div>
                                    @foreach ($permissions as $permission)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{$permission->id}}" name="permission_ids[]" 
                                            {{ in_array($permission->id, $role->permissions->pluck('id')->toArray()) ? 'checked' : '' }} >
                                           
                                            
                                            <label class="custom-control-label" for="">{{$permission->display_name}}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>    
                        @endforeach
                        </div> 
                              
                    </div>
                
                    <button type="submit" class="btn btn-submit btn-primary">Submit</button> 
                
                </form>
            </div>
        </div>
    </div>
@endsection


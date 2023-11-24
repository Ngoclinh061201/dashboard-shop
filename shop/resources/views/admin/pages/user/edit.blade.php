@extends('admin.layouts.app')
@section('title', 'Update User')
@section('titlePage', 'User')
@section('content')
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header" >
                <h2> Edit User</h2>
            </div>
            <div class="card-body">
                <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                    <a href="javascript:history.back()" class="btn btn-info">
                      <i class="fas fa-arrow-left"></i> 
                    </a>
                </div>
                <form class="form-horizontal" action="{{route('users.update', $user->id),}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class ="row">
                        <div class="input-group-static col-5 mb-4">
                            <label>Image</label>
                            <input type="file" accept="image/*" class="form-control" name="image" id="image-input" placeholder="Image" onchange="previewImage('image-input', 'show-image')">
                            
                            @error('image')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-5">
                            <img class="img-fluid border-radius-lg" src="" id="show-image" alt="Image Preview">
                        </div>
                    </div>
                    
                    <div class="input-group input-group-static mb-4">
                            <label>Name</label>
                            <input type="text" value = "{{old('name')?? $user->name }}"class="form-control"name="name" placeholder="Name">
                            @error('name')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                    </div>  
                    <div class="input-group input-group-static mb-4">
                            <label>Phone</label>
                            <input type="text" value = "{{old('phone')?? $user->phone }}"class="form-control"name="phone" placeholder="Phone">
                            @error('phone')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                    </div>
                    <div class="input-group input-group-static mb-4">
                        <label>Email</label>
                        <input type="email" value="{{ old('email') ?? $user->email  }}" class="form-control" name="email" placeholder="Enter your email" required>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="input-group input-group-static mb-4">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Enter your password, skip if no change">
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="input-group input-group-static mb-4">
                        <label>Address</label>
                        <textarea type="text" class="form-control" name="address" placeholder="Enter your address">{{ old('address') ?? $user->address }}</textarea>
                        @error('address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="input-group input-group-static mb-4">
                        <label name="gender" class="ms-0">Gender</label>
                        <select name="gender"  class="form-control">
                          <option value="male">Male</option>
                          <option value="female">Female</option>
                         
                        </select>
                        @error('gender')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                    </div>
                    <div class ="form-group"
                        <label class="" for="">Role</label>
                        <div class="row">
                        @foreach ($roles as $group => $roles)
                            <div class="col-5"
                                <strong>{{ ucfirst($group)}}</strong>
                             
                                <div>
                                    @foreach ($roles as $role)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{$role->id }}" name="role_ids[]"
                                            {{ in_array($role->id, $user->roles->pluck('id')->toArray()) ? 'checked' : '' }} >
                                            <label class="custom-control-label" for="">{{$role->display_name}}</label>
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
@section('scripts')
<script src="{{asset ('admin/assets/base/base.js')}}" ></script>

@endsection


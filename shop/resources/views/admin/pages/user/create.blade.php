@extends('admin.layouts.app')
@section('title', 'Create User')
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
                <h1> Create User</h1>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="{{route('users.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class ="row">
                        <div class="input-group-static col-5 mb-4">
                            <label>Imageeee</label>
                            <input type="file" accept="image/*" class="form-control" name="image" id="image-input" placeholder="Image" onchange="previewImage()">
                            
                            @error('image')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-5">
                            <img src="" id="show-image" alt="Image Preview">
                        </div>
                    </div>
                    
                    <div class="input-group input-group-static mb-4">
                            <label>Name</label>
                            <input type="text" value = "{{old('name')}}"class="form-control"name="name" placeholder="Name">
                            @error('name')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                    </div>  
                    <div class="input-group input-group-static mb-4">
                            <label>Phone</label>
                            <input type="text" value = "{{old('phone')}}"class="form-control"name="phone" placeholder="Phone">
                            @error('phone')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                    </div>
                    <div class="input-group input-group-static mb-4">
                        <label>Email</label>
                        <input type="email" value="{{ old('email') }}" class="form-control" name="email" placeholder="Enter your email" required>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="input-group input-group-static mb-4">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Enter your password" required>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="input-group input-group-static mb-4">
                        <label>Address</label>
                        <textarea type="text" class="form-control" name="address" placeholder="Enter your address">{{ old('address') }}</textarea>
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
                                            <input class="form-check-input" type="checkbox" value="{{$role->id}}" name="role_ids[]">
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
    <script>
        function previewImage() {
            var input = document.getElementById('image-input');
            var img = document.getElementById('show-image');
            var reader = new FileReader();
    
            reader.onload = function(e) {
                img.src = e.target.result;
            };
    
            reader.readAsDataURL(input.files[0]);
        }
    </script>
@endsection


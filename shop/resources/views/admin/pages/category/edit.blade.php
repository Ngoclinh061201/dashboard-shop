@extends('admin.layouts.app')
@section('title', 'Update Categories')
@section('content')
  
<!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">category</li>
                </ol>
                <h6 class="font-weight-bolder mb-0">category</h6>
            </nav>
        </div>
    </nav>
<!-- End Navbar -->
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header" >
                <h1> Edit User</h1>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="{{route('categories.update', $category->id )}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <div class="input-group input-group-static mb-4">
                            <label>Name</label>
                            <input type="text" value = "{{old('name') ?? $category->name}}"class="form-control"name="name" placeholder="Name">
                            @error('name')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                    </div>  
                    @if ($category->childrens->count() < 1)
                        <div class="input-group input-group-static mb-4">
                            <label name="parent_id" class="ms-0">Parent Categories</label>
                            <select name="parent_id"  class="form-control" >
                                <option value="" {{old('parent_id') == null ? 'selected' : ''}}> Parent category</option>
                                @foreach ($parentCategories as $item)
                                    <option value="{{$item->id}}" {{old('parent_id') == $item->id ? 'selected' : ''}}>
                                        {{$item->name}}</option>
                                @endforeach
                            </select>
                            @error('parent_id')
                                    <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    @endif
                    <button type="submit" class="btn btn-submit btn-primary">Submit</button> 
                </form>
            </div>
        </div>
    </div>
    
   
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection


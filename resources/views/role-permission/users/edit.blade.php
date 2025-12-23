@extends('layouts.app')

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit User</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
       <div class="row">
          <!-- left column -->
          <div class="col-md-4">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit User</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="{{ route('users.update', $user->id) }}">
                @csrf
                @method('PUT')
                <div class="card-body">
                  <div class="form-group">
                    @error('name')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    @if(session('message'))
                        <script>
                          toastr.success("{{ session('success') }}");
                        </script>
                        {{-- <div class="alert alert-success">{{ session('message') }}</div> --}}
                    @endif
                    <label for="exampleInputEmail1">User Name (Full Name)</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Full name" name="name" value="{{ $user->name}}">
                  </div>
                   <div class="form-group">
                    @error('user_name')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label for="exampleInputEmail1">User Name</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="user name" name="user_name" value="{{ $user->user_name}}">
                  </div>
                  <div class="form-group">
                    @error('email')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label for="exampleInputEmail1">User Email</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter your email" name="email" value="{{ $user->email}}">
                  </div>
                  <div class="form-group">
                    @error('password ')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label for="exampleInputEmail1">Password</label>
                    <input type="password" class="form-control" id="exampleInputEmail1" name="password">
                  </div>
                   <div class="form-group">
                    <label for="exampleInputEmail1">Role</label>
                  </div>
                <div class="row">
                  @error('roles')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                 @foreach ($roles as $role)
                      <div class=" col-md-4 form-check"> 
                        <input class="form-check-input" 
                        type="checkbox" 
                        name="roles[]" 
                        id="flexCheckDefault" 
                        value="{{ $role->name }}" 
                        {{ in_array($role->name, $userRoles) ? 'checked' : '' }}
                        >
                          <label class="form-check-label" for="flexCheckDefault">
                          {{ $role->name }}
                          </label>
                      </div>
                       @endforeach
                       </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary toastrDefaultSuccess">Update User </button>  
                </div>
              </form>
            </div>
          </div>
          
       </div>
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection

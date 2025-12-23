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
              <li class="breadcrumb-item active">Add User</li>
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
                <h3 class="card-title">Create User</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="{{ route('users.store') }}">
                @csrf
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
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Full name" name="name">
                  </div>
                   <div class="form-group">
                    @error('user_name')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label for="exampleInputEmail1">User ID</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="user id" name="user_name">
                  </div>
                  <div class="form-group">
                    @error('email')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label for="exampleInputEmail1">User Email</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter your email" name="email">
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
                  
                 @foreach ($roles as $role)
                      <div class=" col-md-4 form-check"> 
                        <input class="form-check-input" 
                        type="checkbox" 
                        name="roles[]" 
                        id="flexCheckDefault" 
                        value="{{ $role->name }}" 
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
                  <button type="submit" class="btn btn-primary toastrDefaultSuccess">Add User </button>  
                </div>
              </form>
            </div>
          </div>
          <div class="col-md-8">
            <!-- /.card -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">User List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th style="width: 10px">SL No</th>
                      <th>User Name</th>
                      <th>User ID</th>
                      <th>Email Name</th>
                      <th>Role</th>
                      {{-- <th>Permissions Name</th> --}}
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ( $users as $user )
                    <tr>
                      <td>{{ $user->id }}</td>
                      <td>{{ $user->name }}</td>
                      <td>{{ $user->user_name }}</td>
                      <td>{{ $user->email }}</td>
                      <td>
                        @if( !empty($user->getRoleNames()) )
                          @foreach ( $user->getRoleNames() as $rolename )
                            <label class="badge bg-primary mx-1">{{$rolename}}</label>
                          @endforeach
                        @endif
                      </td>
                      {{-- <td>
                        <span class="badge bg-primary mx-1">
                          {{ $role->permissions->pluck('name')->implode(', ') }}
                        </span> 
                      </td> --}}
                      
                      <td>
                      </a>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-info"><i class="fa fa-edit"></i></a>
                        {{-- <a href="{{ route('role.delete', $role->id) }}" class="btn btn-danger" id="delete">Delete</a> --}}
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-danger" id="delete"><i class="fa fa-trash"></i></button>
                        </form>
                      </td>
                      
                    </tr>
                   @endforeach
                  
                  </tbody>
                  {{-- <tfoot>
                  <tr>
                      <th style="width: 10px">SL No</th>
                      <th>role Name</th>
                      <th>Action</th>
                    </tr>
                  </tfoot> --}}
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
       </div>
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection

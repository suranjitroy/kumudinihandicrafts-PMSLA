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
              <li class="breadcrumb-item active">Add Role</li>
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
          <div class="col-md-2">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Create Role</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="{{ route('role.store') }}">
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
                    <label for="exampleInputEmail1">Role Name</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="role name" name="name">
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary toastrDefaultSuccess">Add Role </button>  
                </div>
              </form>
            </div>
          </div>
          <div class="col-md-10">
            <!-- /.card -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Role List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th style="width: 10px">SL No</th>
                      <th>Role Name</th>
                      <th>Permissions Name</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ( $roles as $role )
                    <tr>
                      <td>{{ $role->id }}</td>
                      <td>{{ $role->name }}</td>
                      {{-- <td>
                        <span class="badge bg-primary mx-1">
                          {{ $role->permissions->pluck('name')->implode(', ') }}
                        </span> 
                      </td> --}}
                      <td>
                        @if( !empty($role->permissions) )
                          @foreach ( $role->permissions as $permission )
                            <label class="badge bg-primary mx-1">{{$permission->name}}</label>
                          @endforeach
                        @endif
                      </td>
                      <td>
                        <a href="{{ route('permission.give-permission', $role->id) }}" class="btn btn-success">Add/Edit Permission
                          
                        
                      </a>
                        <a href="{{ route('role.edit', $role->id) }}" class="btn btn-info"><i class="fa fa-edit"></i></a>
                        {{-- <a href="{{ route('role.delete', $role->id) }}" class="btn btn-danger" id="delete">Delete</a> --}}
                        <form action="{{ route('role.destroy', $role->id) }}" method="POST" class="d-inline">
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

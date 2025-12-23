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
        <h2>Role Name : {{ $role->name }}</h2>
          <!-- left column -->
          <div class="col-md-12">
            
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Give permission to role</h3>
              </div>
              
             
              <div class="card-body">
                <h4>Pemissions</h4>
                 <form method="POST" action="{{ route('permission.give-permission.update',  $role->id) }}">
                  @csrf
                  @method('PUT')
                  <div class="row">
                      @foreach ( $permissions as $permission)
                      <div class="col-md-2 col-2 col-sm-2 ml-4"> 
                        <input class="form-check-input" 
                        type="checkbox" 
                        name="permissions[]" 
                        id="flexCheckDefault" 
                        value="{{ $permission->name }}" 
                        {{ in_array( $permission->id, $rolePermissions) ? 'checked' : '' }} >
                          <label class="form-check-label" for="flexCheckDefault">
                          {{ $permission->name }}
                          </label>
                      </div>
                       @endforeach
                  </div>
                    
                </div>
                 
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary toastrDefaultSuccess">Give Permission </button>  
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

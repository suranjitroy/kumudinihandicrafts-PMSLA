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
              <li class="breadcrumb-item active">Edit Size</li>
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
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Size</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="{{ route('size.update', $size->id) }}">
                @csrf
                @method('PUT')
                <div class="card-body">
                  <div class="form-group">
                    @error('name')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    @if (session('message'))
                        <div class="alert alert-success">{{ session('message') }}</div>
                    @endif
                    <label for="exampleInputEmail1">Size</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="size name" name="size" value="{{ $size->size }}">
                  </div>
                  <div class="form-group">
                      @error('status')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                        <label>Status</label>
                        <select class="form-control" name="status">
                          <option>Select Status</option>
                          <option value="0" @if($size->status == 0) selected="selected" @endif>Active</option>
                          <option value="1" @if($size->status == 1) selected="selected" @endif>Inactive</option>
                         
                        </select>
                      </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update Size</button>  
                </div>
              </form>
            </div>
          </div>
          <div class="col-md-6">
            <!-- /.card -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Size List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th style="width: 10px">SL No</th>
                      <th>Size</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ( $sizes as $key => $size )
                    <tr>
                      <td>{{ $key + 1}}</td>
                      <td>{{ $size->size }}</td>
                       <td>
                        @if ($size->status == 0)
                          <label class="badge bg-success mx-1">Active</label>
                        @else
                          <label class="badge bg-danger mx-1">Inactive</label>
                        @endif
                      </td> 
                      <td>
                        <a href="{{ route('size.edit', $size->id) }}" class="btn btn-info"><i class="fa fa-edit"></i></a>
                        {{-- <a href="{{ route('size.delete', $size->id) }}" class="btn btn-danger" id="delete">Delete</a> --}}
                        <form action="{{ route('size.destroy', $size->id) }}" method="POST" class="d-inline">
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
                      <th>size Name</th>
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

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
              <li class="breadcrumb-item active">Edit Store Category</li>
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
                <h3 class="card-title">Edit Store Category</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="{{ route('store-category.update', $storeCategory->id) }}">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                      @error('store_id')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                        <label>Select Store</label>
                        <select class="form-control select2" name="store_id">
                          <option>Select Store</option>
                          @foreach ( $stores as $store)
                            <option value="{{ $store->id }}" @if($store->id == $storeCategory->store_id) selected="selected"  @endif>
                              {{ $store->name }}
                            </option>
                          @endforeach

                        </select>
                      </div>
                  <div class="form-group">
                    @error('category_name')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    @if(session('message'))
                        <script>
                          toastr.success("{{ session('success') }}");
                        </script>
                        {{-- <div class="alert alert-success">{{ session('message') }}</div> --}}
                    @endif
                    <label for="exampleInputEmail1">Store Category Name</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Store category name" name="category_name" value="{{ $storeCategory->category_name}}">
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update Store Category</button>  
                </div>
              </form>
            </div>
          </div>
          <div class="col-md-6">
            <!-- /.card -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Store Category List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="store" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th style="width: 10px">SL No</th>
                      <th>Store Name</th>
                      <th>Store Category Name</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ( $storeCategorys as $storeCategory )
                    <tr>
                      <td>{{ $storeCategory->id }}</td>
                      <td>{{ $storeCategory->store->name }}</td>
                      <td>{{ $storeCategory->category_name }}</td>
                      
                      <td>
                        @can('update store')
                          <a href="{{ route('store-category.edit', $storeCategory->id) }}" class="btn btn-info"><i class="fa fa-edit"></i>
                          </a>
                        @endcan
                        {{-- <a href="{{ route('store.delete', $store->id) }}" class="btn btn-danger" id="delete">Delete</a> --}}
                        @can('delete store')
                        <form action="{{ route('store-category.destroy', $storeCategory->id) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-danger" id="delete"><i class="fa fa-trash"></i></button>
                        </form>
                         @endcan
                      </td>
                      
                    </tr>
                   @endforeach
                  
                  </tbody>
                  {{-- <tfoot>
                  <tr>
                      <th style="width: 10px">SL No</th>
                      <th>store Name</th>
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

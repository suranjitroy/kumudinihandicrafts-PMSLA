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
              <li class="breadcrumb-item active">Add Supplier</li>
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
          @can('create store')
          <div class="col-md-3">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Create Supplier</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="{{ route('supplier.store') }}">
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
                    @endif
                    <label for="exampleInputEmail1">Supplier Name</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="supplier name" name="name">
                  </div>

                  <div class="form-group">
                    @error('address')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    @if(session('message'))
                        <script>
                          toastr.success("{{ session('success') }}");
                        </script>
                    @endif
                    <label for="exampleInputEmail1">Supplier Address</label>
                    <textarea rows="5" cols="5" class="form-control" name="address">
                    </textarea>
                  </div>

                  <div class="form-group">
                    @error('mobile_no')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    @if(session('message'))
                        <script>
                          toastr.success("{{ session('success') }}");
                        </script>
                    @endif
                    <label for="exampleInputEmail1">Supplier Mobile No</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Supplier mobile No" name="mobile_no">
                  </div>
                  <div class="form-group">
                    @error('email')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    @if(session('message'))
                        <script>
                          toastr.success("{{ session('success') }}");
                        </script>
                    @endif
                    <label for="exampleInputEmail1">Supplier Email</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Supplier email" name="email">
                  </div>
                  
                    <div class="form-group">
                      @error('store_id')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                        <label>Status</label>
                        <select class="form-control" name="status">
                          <option>Select Status</option>
                          <option value="0">Active</option>
                          <option value="1">Inactive</option>
                         
                        </select>
                    </div>
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary toastrDefaultSuccess">Add Supplier </button>  
                </div>
              </form>
            </div>
          </div>
          @endcan
          <div class="col-md-9">
            <!-- /.card -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Supplier list</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="store" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th style="width: 10px">SL No</th>
                      <th>Supplier Name</th>
                      <th>Supplier Address</th>
                      <th>Supplier Mobile No</th>
                      <th>Supplier Email</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ( $suppliers as $supplier )
                    <tr>
                      <td>{{ $supplier->id }}</td>
                      <td>{{ $supplier->name }}</td>
                      <td>{{ $supplier->address }}</td>
                      <td>{{ $supplier->mobile_no }}</td>
                      <td>{{ $supplier->email }}</td>
                      <td>
                        @if ($supplier->status == 0)
                          <label class="badge bg-success mx-1">Active</label>
                        @else
                          <label class="badge bg-danger mx-1">Inactive</label>
                        @endif
                      </td> 
                      <td>
                        @can('update store')
                          <a href="{{ route('supplier.edit', $supplier->id) }}" class="btn btn-info"><i class="fa fa-edit"></i>
                          </a>
                        @endcan
                        {{-- <a href="{{ route('store.delete', $store->id) }}" class="btn btn-danger" id="delete">Delete</a> --}}
                        @can('delete store')
                        <form action="{{ route('supplier.destroy', $supplier->id) }}" method="POST" class="d-inline">
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

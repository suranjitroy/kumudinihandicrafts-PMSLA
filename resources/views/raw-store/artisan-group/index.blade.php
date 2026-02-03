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
              <li class="breadcrumb-item active">Add Artisan Group</li>
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
                <h3 class="card-title">Create Artisan Group</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="{{ route('artisan-group.store') }}">
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
                    <label for="exampleInputEmail1">Group Name</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="group name" name="group_name">
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
                    <label for="exampleInputEmail1">Address</label>
                    <textarea rows="5" cols="5" class="form-control" name="group_address">
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
                    <label for="exampleInputEmail1">Group Mobile No</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Group Mobile No" name="mobile_no">
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
                    <label for="exampleInputEmail1">Remarks</label>
                    <textarea rows="5" cols="5" class="form-control" name="remark">
                    </textarea>
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
                  <button type="submit" class="btn btn-primary toastrDefaultSuccess">Add Artisan Group </button>  
                </div>
              </form>
            </div>
          </div>
          @endcan
          <div class="col-md-9">
            <!-- /.card -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Artisan Group list</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="store" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th style="width: 10px">SL No</th>
                      <th>Group Name</th>
                      <th>Group Address</th>
                      <th>Group Mobile No</th>
                      <th>Remarks</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ( $groups as $key => $group )
                    <tr>
                      <td>{{ $key + 1 }}</td>
                      <td>{{ $group->group_name }}</td>
                      <td>{{ $group->group_address }}</td>
                      <td>{{ $group->mobile_no }}</td>
                      <td>{{ $group->remark }}</td>
                      <td>
                        @if ($group->status == 0)
                          <label class="badge bg-success mx-1">Active</label>
                        @else
                          <label class="badge bg-danger mx-1">Inactive</label>
                        @endif
                      </td> 
                      <td>
                        @can('update store')
                          <a href="{{ route('artisan-group.edit', $group->id) }}" class="btn btn-info"><i class="fa fa-edit"></i>
                          </a>
                        @endcan
                        {{-- <a href="{{ route('store.delete', $store->id) }}" class="btn btn-danger" id="delete">Delete</a> --}}
                        @can('delete store')
                        <form action="{{ route('artisan-group.destroy', $group->id) }}" method="POST" class="d-inline">
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

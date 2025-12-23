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
              <li class="breadcrumb-item active">Worker Information</li>
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
          <div class="col-md-12">
            <!-- /.card -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Worker Information List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                
                  <a href="{{ route('worker-info.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Worker</a>
                
                
                <table id="store" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th style="width: 10px">SL No</th>
                      <th>Worker Name</th>
                      <th>Mobile No</th>
                      <th>Address</th>
                      <th>NID No</th>
                      <th>Joining Date</th>
                      <th>Grade</th>
                      <th>Emargency Contact No</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ( $alldata as $key => $data )
                    <tr>
                      <td>{{ $key + 1 }}</td>
                      <td>{{ $data->name }}</td>
                      <td>{{ $data->phn_no }}</td>
                      <td>{{ $data->address }}</td>
                      <td>{{ $data->nid_no }}</td>
                      <td>{{ $data->joining_date }}</td>
                      <td>{{ $data->grade }}</td>
                      <td>{{ $data->emargency_phn_no }}</td>
                      <td>
                         @role('Store Staff')
                          @if($data->status == !2)
                          <a href="{{ route('worker-info.edit', $data->id) }}" class="btn btn-info"><i class="fa fa-edit"></i>
                          </a>
                          <form action="{{ route('worker-info.destroy', $data->id) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-danger" id="delete"><i class="fa fa-trash"></i></button>
                        </form> 
                          @endif
                        @endrole

                        @role('manager')
                          <a href="{{ route('worker-info.edit', $data->id) }}" class="btn btn-info"><i class="fa fa-edit"></i>
                          </a>
                          <form action="{{ route('worker-info.destroy', $data->id) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-danger" id="delete"><i class="fa fa-trash"></i></button>
                        </form> 
                        @endrole

                         @role('admin')
                          <a href="{{ route('worker-info.edit', $data->id) }}" class="btn btn-info"><i class="fa fa-edit"></i>
                          </a>
                          <form action="{{ route('worker-info.destroy', $data->id) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-danger" id="delete"><i class="fa fa-trash"></i></button>
                        </form> 
                        @endrole

                        {{-- <a href="{{ route('store.delete', $store->id) }}" class="btn btn-danger" id="delete">Delete</a> --}}
                        {{-- @can('delete store')
                        @if($data->status !== 1)
                        <form action="{{ route('store-requsition.destroy', $data->id) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-danger" id="delete"><i class="fa fa-trash"></i></button>
                        </form>
                          @endif 
                         @endcan --}}
                      </td>
                    </tr>
                    @endforeach
                  {{-- @foreach ( $alldata as $key => $data )
                    <tr>
                      <td>{{ $key + 1 }}</td>
                      <td>{{ $data->store->name }}</td>
                      <td>{{ $data->storeCategory->category_name }}</td>
                      <td>{{ $data->material->material_name}}</td>
                      <td>{{ $data->unit->name  }}</td>
                      
                      <td>
                        @can('update store')
                          <a href="{{ route('material-setup.edit', $materialSetup->id) }}" class="btn btn-info"><i class="fa fa-edit"></i>
                          </a>
                        @endcan
                        @can('delete store')
                        <form action="{{ route('material-setup.destroy', $materialSetup->id) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-danger" id="delete"><i class="fa fa-trash"></i></button>
                        </form>
                         @endcan
                      </td> 
                    </tr>
                   @endforeach --}}
                  
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


  
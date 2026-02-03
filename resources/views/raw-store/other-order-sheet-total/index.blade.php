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
              <li class="breadcrumb-item active">Other Order Sheet Total</li>
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
                <h3 class="card-title">Other Order Total List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                
                  <a href="{{ route('other-order-sheet-total.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add Other Orderr</a>
                
                
                <table id="store" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>SL No</th>
                      <th>Other Order No</th>
                      <th>Other Order Entry Date</th>
                      <th>Section Name</th>
                      <th>Material Name</th>
                      <th>Quantity</th>
                      <th>Unit Yeard</th>
                      <th>Total</th>
                      <th>Remarks</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ( $alldata as $key => $data )
                    <tr>
                      <td>{{ $key + 1 }}</td>
                      <td>{{ $data->other_order_no_t }}</td>
                      <td>{{ $data->other_order_entry_date_t}}</td>
                      <td>{{ $data->section->name}}</td>
                      <td>{{ $data->materialSetup->material_name}}</td>
                      <td>{{ $data->quantity}} {{ $data->unit->name}} </td>
                      <td>{{ $data->unit_yeard}} {{ $data->unit->name}} </td>
                      <td>{{ $data->total}} </td>
                      <td>{{ $data->remarks}} </td>
                     <td>
                       @if($data->status == 0)
                      <label class="badge bg-danger p-2" style="font-size: 16px;">Pending</label>
                      @elseif($data->status == 2)
                      <label class="badge bg-warning p-2" style="font-size: 16px;">Recomended</label>
                      @else
                      <label class="badge bg-success p-2" style="font-size: 16px;">Approved</label>
                     </td>
                      @endif
                      
                      <td>
                         @role('Store Staff')
                          @if($data->status == !2)
                          <a href="{{ route('other-order-sheet-total.edit', $data->id) }}" class="btn btn-info"><i class="fa fa-edit"></i>
                          </a>
                          <form action="{{ route('other-order-sheet-total.destroy', $data->id) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-danger" id="delete"><i class="fa fa-trash"></i></button>
                        </form> 
                          @endif
                        @endrole

                        @role('manager')
                          @if($data->status == 0) 
                            <form action="{{ route('other-order-sheet-total.recommended', $data->id) }}" method="POST" class="d-inline">
                                  @csrf
                                  <button class="btn btn-warning"><i class="fa fa-check-circle"></i>Recommended</button> 
                            </form>
                          @endif
                          <a href="{{ route('other-order-sheet-total.edit', $data->id) }}" class="btn btn-info"><i class="fa fa-edit"></i>
                          </a>
                          <form action="{{ route('other-order-sheet-total.destroy', $data->id) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-danger" id="delete"><i class="fa fa-trash"></i></button>
                        </form> 
                        @endrole

                         @role('admin')
                          @if($data->status == 2)
                          <form action="{{ route('other-order-sheet-total.approve', $data->id) }}" method="POST" class="d-inline">
                              @csrf
                              <button class="btn btn-success"><i class="fa fa-check-circle"></i>Approve</button>
                          </form>
                          @endif
                          <a href="{{ route('other-order-sheet-total.edit', $data->id) }}" class="btn btn-info"><i class="fa fa-edit"></i>
                          </a>
                          <form action="{{ route('other-order-sheet-total.destroy', $data->id) }}" method="POST" class="d-inline">
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


  
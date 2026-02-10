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
              <li class="breadcrumb-item active">Embroidery Order Process List</li>
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
                <h3 class="card-title">Embroidery Order Process List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                
                  <a href="{{ route('embroidery-process.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Embroidery Order Process</a>
                
                
                <table id="store" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>SL No</th>
                      <th>Order Process Date</th>
                      <th>Embroidery Order No</th>
                      <th>Status</th>
                      <th>Dispatch Quantity</th>
                      <th>Remark</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ( $processings as $key => $data )
                    <tr>
                      <td>{{ $key + 1 }}</td>
                      <td>{{ $data->entry_date }}</td>
                      <td>{{ $data->embroideryOrder->emb_order_no }}</td>
                      <td>
                          @if($data->process_section_id == 2)
                          <label class="badge bg-primary p-2" style="font-size: 16px;">{{ $data->processSection->name }}</label>
                          @elseif ($data->process_section_id == 6)
                           <label class="badge bg-success p-2" style="font-size: 16px;">{{ $data->processSection->name }}</label>
                          @elseif ($data->process_section_id == 7)
                           <label class="badge bg-danger p-2" style="font-size: 16px;">{{ $data->processSection->name }}</label>
                       @endif
                     </td> 
                      </td>
                      
                      <td>{{ $data->dispatch_quantity }}</td>
                      <td>{{ $data->remark }}</td>
                     {{-- <td>
                       @if($data->status == 1)
                      <label class="badge bg-success p-2" style="font-size: 16px;">Received</label>
                     </td> 
                      @endif--}}
                      
                      {{-- <td>
                         @role('Store Staff')
                          <a href="{{ route('emb-order-sheet.show', $data->id) }}" class="btn btn-info"><i class="fa fa-eye"></i>
                          @if($data->status == !2)
                          <a href="{{ route('emb-order-sheet.edit', $data->id) }}" class="btn btn-info"><i class="fa fa-edit"></i>
                          </a>
                          <form action="{{ route('emb-order-sheet.destroy', $data->id) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-danger" id="delete"><i class="fa fa-trash"></i></button>
                        </form> 
                          @endif
                        @endrole

                        @role('manager')
                         <a href="{{ route('emb-order-sheet.show', $data->id) }}" class="btn btn-info"><i class="fa fa-eye"></i>
                          <a href="{{ route('emb-order-sheet.edit', $data->id) }}" class="btn btn-info"><i class="fa fa-edit"></i>
                          </a>
                          <form action="{{ route('emb-order-sheet.destroy', $data->id) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-danger" id="delete"><i class="fa fa-trash"></i></button>
                        </form> 
                        @endrole

                         @role('admin')
                          <a href="{{ route('emb-order-sheet.show', $data->id) }}" class="btn btn-info"><i class="fa fa-eye"></i>
                          <a href="{{ route('emb-order-sheet.edit', $data->id) }}" class="btn btn-info"><i class="fa fa-edit"></i>
                          </a>
                          <form action="{{ route('emb-order-sheet.destroy', $data->id) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-danger" id="delete"><i class="fa fa-trash"></i></button>
                        </form> 
                        @endrole

                       
                      </td> --}}
                      <td>
                        @can('update store')
                          <a href="{{ route('embroidery-process.edit', $data->id) }}" class="btn btn-info"><i class="fa fa-edit"></i>
                          </a>
                        @endcan
                        {{-- <a href="{{ route('store.delete', $store->id) }}" class="btn btn-danger" id="delete">Delete</a> --}}
                        @can('delete store')
                        <form action="{{ route('embroidery-process.destroy', $data->id) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-danger" id="delete"><i class="fa fa-trash"></i></button>
                        </form>
                         @endcan
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


  
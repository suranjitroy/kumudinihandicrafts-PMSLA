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
              <li class="breadcrumb-item active">Add Material Setup</li>
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
                <h3 class="card-title">Order Distribution List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                {{-- {{ dd($allData) }} --}}
                {{-- <a href="{{ route('order-distribution.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add Order Distribution</a> --}}
                <table id="store" class="table table-bordered table-striped">
                  <thead>
                     <tr>
                      <th style="width: 10px">SL No</th>
                      <th>Order No</th>
                      <th>Order Date</th>
                      <th>Order Delivary Date</th>
                      <th>Order To</th>
                      <th>Item</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ( $allData as $key => $data )
                    <tr>
                      <td>{{ $key + 1 }}</td>
                      <td>{{ $data->production_order_no }}</td>
                      <td>{{ $data->productionWorkOrder->order_entry_date}}</td>
                      <td>{{ $data->productionWorkOrder->order_delivery_date}}</td>
                      <td>{{ $data->productionWorkOrder->masterInfo->name }}</td>
                      <td>{{ $data->productionWorkOrder->item->name }}</td>
                     
                      {{-- <td>
                        @if($data->status == 0)
                        <label class="badge bg-danger p-2" style="font-size: 16px;">Pending</label>
                        @elseif($data->status == 2)
                        <label class="badge bg-warning p-2" style="font-size: 16px;">Recomended</label>
                        @else
                        <label class="badge bg-success p-2" style="font-size: 16px;">Approved</label>
                      </td>
                        @endif --}}

                      {{-- <td>
                          @if ($data->orderProcessing && $data->orderProcessing->status == 'Tailor')
                              <label class="badge bg-success p-2" style="font-size: 16px;">{{ $data->orderProcessing->status }} </label>
                          @elseif ($data->orderProcessing && $data->orderProcessing->status == 'Wash')
                              <label class="badge bg-primary p-2" style="font-size: 16px;">{{ $data->orderProcessing->status }}</label>
                          @elseif ($data->orderProcessing && $data->orderProcessing->status == 'Embroidery')
                              <label class="badge p-2" style="font-size: 16px; background-color:blueviolet">{{ $data->orderProcessing->status }}</label>
                          @else
                              
                              <label class="badge bg-danger p-2" style="font-size: 16px;">Not Processed</label>
                          @endif
                      </td> --}}
 
                      <td>
                         @role('Store Staff')
                          <a href="{{ route('order-dist.orderShow', $data->id) }}" class="btn btn-info">
                            <i class="fa fa-eye"></i>
                          </a>
                          {{-- @if($data->status == !2) --}}

                          <a href="{{ route('order-dist.receive', $data->id ) }}" 
                            class="btn" style="background-color:aquamarine"> Receive
                          </a>

                          <a href="{{ route('order-dist.receive', $data->id ) }}" 
                            class="btn" style="background-color:aquamarine"><i class="fa fa-edit"></i>
                          </a>

                          {{-- <form action="{{ route('production-work-order.destroy', $data->id) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-danger" id="delete"><i class="fa fa-trash"></i></button>
                          </form>  --}}
                          {{-- @endif --}}
                        @endrole

                        @role('manager')
                          <a href="{{ route('production-work-order.show', $data->id) }}" class="btn btn-info"><i class="fa fa-eye"></i>
                          </a>
                          <a href="{{ route('production-work-order.edit', $data->id) }}" class="btn btn-info"><i class="fa fa-edit"></i>
                          </a>
                          {{-- <form action="{{ route('production-work-order.destroy', $data->id) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-danger" id="delete"><i class="fa fa-trash"></i></button>
                        </form>  --}}
                        @endrole

                         @role('admin')
                          <a href="{{ route('production-work-order.show', $data->id) }}" class="btn btn-info"><i class="fa fa-eye"></i>
                          </a>
                          <a href="{{ route('orderpro', $data->id) }}" class="btn btn-info"><i class="fa fa-edit"></i>
                          </a>
                          {{-- <form action="{{ route('production-work-order.destroy', $data->id) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-danger" id="delete"><i class="fa fa-trash"></i></button>
                        </form>  --}}
                        @endrole

                      </td>
                    </tr>
                    @endforeach
                  
                  </tbody>
                 
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


  
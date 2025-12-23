@extends('layouts.app')

@section('content')
    @if(session('message'))
        <script>
        toastr.success("{{ session('success') }}");
        </script>
    @endif
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
              <li class="breadcrumb-item active">Order Receive </li>
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
          @canany(['create store','create store requsition', 'update store requsition', 'view store requsition', 'delete store requsition'])
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Order Receive</h3>
              </div>
              <!-- /.card-header -->
                <div class="card-body">
    
                <div class="row invoice-info my-5">
                    <div class="col-md-6 invoice-col">
                    <address>
                        <h5>
                            Order Entry Date : 
                            {{ $distribution->productionWorkOrder->order_entry_date }}
                        </h5>
                        <h5>Order Delivery Date : 
                            {{ $distribution->productionWorkOrder->order_delivery_date }}
                        </h5>
                        <h5>Order No : {{ $distribution->productionWorkOrder->production_order_no }}</h5>
                        <h5>Order To : {{ $distribution->productionWorkOrder->masterInfo->name }}</h5>
                    </address>
                    </div>
                
                    <div class="col-md-6 invoice-col">
                        <h5>Item Name : {{ $distribution->productionWorkOrder->item->name }}</h5>
                        <h5>Fabric Name : 
                            {{ $distribution->productionWorkOrder->productionWorkOrderFabricItem->first()->materialSetup->material_name }}
                            {{ $orderDistID->order_distribution_id }}
                            {{ $distribution->productionWorkOrder->id }}
                        </h5>
                        {{-- <h5>Bahar Name : {{ $bahar->bahar->bahar }}</h5> --}}
                    </div>
                </div>                    
                    
  
                </div>
                <!-- /.card-body -->
                    <div class="card-body"> 
                       <form method="POST" action="{{ route('order-receive.store') }}">
    @csrf

    <div class="row">
        <div class="col-md-12">
            <h3 class="text-center">Receive to Worker</h3>
        </div>
    </div>

    <div class="row mt-3">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        {{-- Main Hidden Fields --}}
        <input type="hidden" name="production_work_order_id" value="{{ $distribution->production_work_order_id }}">
        <input type="hidden" name="production_order_no" value="{{ $distribution->production_order_no }}">
        <input type="hidden" name="order_distribution_id" value="{{ $orderDistID->order_distribution_id }}">


        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>Bahar</th>
                    <th>Size</th>
                    <th>Quantity</th>
                    <th class="w-25">Worker</th>
                    <th>Assign Date</th>
                    <th>Delivery Date</th>
                    <th>Assign Qty</th>
                    <th>Receive Date</th>
                    <th>Receive Qty</th>
                    <th>Remarks</th>
                </tr>
            </thead>

            <tbody>
                @foreach($distributionItems as $item)

                <tr>
                    {{-- Hidden fields for each row --}}
                    <input type="hidden" name="worker_info_id[]" value="{{ $item->worker_info_id }}">
                    <input type="hidden" name="size_id[]" value="{{ $item->size_id }}">
                    <td>{{ $item->bahar->bahar }}</td>
                    <td>{{ $item->size->size }}</td>
                    <td>{{ intval($item->order_quantity) }}</td>

                    <td>

                        {{ $item->workerInfo->name }}
                        {{-- <select class="form-control select2" name="worker_info_id[]">
                            <option value="">Select Worker</option>
                            @foreach ($workers as $worker)
                                <option value="{{ $worker->id }}" @if($worker->id == $item->worker_info_id) selected="selected" @endif>{{ $worker->name }}</option>
                            @endforeach
                        </select> --}}
                         {{-- @foreach ($workers as $worker)
                             <p>{{ $worker->name }}</p>
                         @endforeach --}}

                    </td>

                     <td>
                        {{ $item->assing_entry_date }}
                    </td>

                    <td>
                        {{ $item->assing_delivery_date }}
                    </td>

                    <td>
                        {{ $item->assing_quantity }}
                    </td>

                     <td>
                        <input type="text" id="receive_entry_date" name="receive_entry_date[]" class="form-control">
                    </td>

                    <td>
                        <input type="text" name="receive_quantity[]" step="1" class="form-control text-right">
                    </td>

                    <td>
                        <textarea name="remarks[]" rows="2" class="form-control"></textarea>
                    </td>
                </tr>

                @endforeach
            </tbody>

        </table>

        <div class="text-center mt-3">
            {{-- <button type="submit" class="btn btn-primary w-25">Save</button> --}}
            <button type="submit" class="btn btn-primary toastrDefaultSuccess mt-4"> 
                Save 
            </button>
        </div>

    </div>
</form>

                    </div>
                    <div class="card-footer">
                    
                    </div>
               

            </div>
          </div>
          @endcanany
       </div>
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div> 

@endsection

@section('scripts')

<script>
    $(document).ready(function () {
        $('#assing_delivery_date,#receive_entry_date').datetimepicker({
            format: 'd-m-Y'  // Format compatible with MySQL DATETIME
             
        });
    });
</script>



@endsection 







  
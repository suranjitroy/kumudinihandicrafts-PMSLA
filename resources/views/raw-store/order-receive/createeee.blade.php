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
              <li class="breadcrumb-item active">Order Distribution </li>
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
                <h3 class="card-title">Order Distribution</h3>
              </div>
              <!-- /.card-header -->
                <div class="card-body">
    
                <div class="row invoice-info my-5">
                    <div class="col-md-6 invoice-col">
                    <address>
                        <h5>
                            Order Entry Date : 
                            {{ $productionOrder->order_entry_date }}
                        </h5>
                        <h5>Order Delivery Date : 
                            {{ $productionOrder->order_delivery_date }}
                        </h5>
                        <h5>Order No : {{ $productionOrder->production_order_no }}</h5>
                        <h5>Order To : {{ $productionOrder->masterInfo->name }}</h5>
                        <h5>Production work order id : {{ $productionOrder->id }}</h5>
                    </address>
                    </div>
                
                    <div class="col-md-6 invoice-col">
                        <h5>Item Name : {{ $item->item->name }}</h5>
                        <h5>Fabric Name : {{ $fabric->materialSetup->material_name }}</h5>
                        {{-- <h5>Bahar Name : {{ $bahar->bahar->bahar }}</h5> --}}
                        <h5>Purpose : {{ $productionOrder->purpose }}</h5>
                    </div>
                </div>                    
                    
  
                </div>
                <!-- /.card-body -->
                    <div class="card-body"> 
                       <form method="POST" action="{{ route('order-distribution.newstore') }}">
    @csrf

    <div class="row">
        <div class="col-md-12">
            <h3 class="text-center">Assign to Worker</h3>
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
        <input type="hidden" name="production_work_order_id" value="{{ $productionOrder->id }}">
        <input type="hidden" name="production_order_no" value="{{ $productionOrder->production_order_no }}">

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
                    <th>Remarks</th>
                </tr>
            </thead>

            <tbody>
                @foreach($productionOrderFbaricItems as $item)

                <tr>
                    {{-- Hidden fields for each row --}}
                    <input type="hidden" name="bahar_id[]" value="{{ $item->bahar_id }}">
                    <input type="hidden" name="size_id[]" value="{{ $item->size_id }}">
                    <input type="hidden" name="order_quantity[]" value="{{ $item->order_quantity }}">

                    <td>{{ $item->bahar->bahar }}</td>
                    <td>{{ $item->size->size }}</td>
                    <td>{{ intval($item->order_quantity) }}</td>

                    <td>
                        <select class="form-control select2" name="worker_info_id[]">
                            <option value="">Select Worker</option>
                            @foreach ($workers as $worker)
                                <option value="{{ $worker->id }}">{{ $worker->name }}</option>
                            @endforeach
                        </select>
                    </td>

                    <td>
                        <input type="text" id="assing_entry_date" name="assing_entry_date[]" class="form-control">
                    </td>

                    <td>
                        <input type="text" id="assing_delivery_date" name="assing_delivery_date[]" class="form-control">
                    </td>

                    <td>
                        <input type="text" name="assing_quantity[]" step="1" class="form-control text-right">
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

{{-- <script>
    $(function () {
       $('input[name="entry_date"]').datetimepicker({
        timepicker: false,   // only date
        format: 'd-m-Y'
    });
});
</script> --}}


{{-- <script id="document-template" type="text/x-handlebars-template"> 
    <tr class="delete_add_more_item" id="delete_add_more_item">
        <input type="hidden" name="order_entry_date" value="@{{ order_entry_date }}">
        <input type="hidden" name="order_delivery_date" value="@{{ order_delivery_date }}">
        <input type="hidden" name="production_order_no" value="@{{ production_order_no }}">
        <input type="hidden" name="master_info_id" value="@{{ master_info_id }}">
        <input type="hidden" name="item_id" value="@{{ item_id }}">
        <input type="hidden" name="material_setup_id[]" value="@{{ material_setup_id }}">
        <input type="hidden" name="bahar_id[]" value="@{{ bahar_id }}">
        <input type="hidden" name="size_id[]" value="@{{ size_id }}">
        <input type="hidden" name="unit_id[]" value="@{{ unit_id }}">
        <input type="hidden" name="unit_name[]" value="@{{ unit_name }}">
        <input type="hidden" name="unit_yeard[]" class="consumption_qty" value="@{{ consumption_qty }}">

        <td>@{{ item_name }}</td>
        <td>@{{ material_name }}</td>
        <td>@{{ bahar }}</td>
        <td>@{{ size }}</td>
        <td>
            <div class="input-group" style="width: 250px;">
            <input type="text" class="form-control text-right order_quantity" name="order_quantity[]" value="">
            <span class="input-group-text d-none"> @{{ unit_name }}</span>
            </div></td>
        <td>@{{ consumption_qty }} </td>
        <td><input type="text" class="form-control text-right total_yeard" name="total_yeard[]"></td>
        <td><i class="btn btn-danger btn-sm fa fa-window-close removeitem"></i></td>
    </tr>
</script>

<script id="document-template-ac" type="text/x-handlebars-template"> 
    <tr class="delete_add_more_item_acc" id="delete_add_more_item_acc">

        <input type="hidden" name="production_order_no" value="@{{ production_order_no }}">
        <input type="hidden" name="material_setup_id_ac[]" value="@{{ material_setup_id }}">
        <input type="hidden" name="size_id_ac[]" value="@{{ size_id }}">
        <input type="hidden" name="unit_id_ac[]" value="@{{ unit_id }}">
        <input type="hidden" name="unit_name_ac[]" value="@{{ unit_name }}">

        <td>@{{ material_name }}</td>
        <td>@{{ size }}</td>
        <td>
            <div class="input-group" style="width: 250px;">
            <input type="text" class="form-control text-right order_quantity_ac" name="order_quantity_ac[]" value="">
            <span class="input-group-text"> @{{ unit_name }}</span>
            </div>
        </td>
        <td><i class="btn btn-danger btn-sm fa fa-window-close removeitemac"></i></td>
    </tr>
</script> --}}

<script>
    $(document).ready(function () {
        $('#assing_entry_date,#assing_delivery_date').datetimepicker({
            format: 'd-m-Y'  // Format compatible with MySQL DATETIME
             
        });
    });
</script>

@endsection 







  
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
              <li class="breadcrumb-item active">Add New Challan</li>
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
                <h3 class="card-title">Production Challan</h3>
              </div>
              <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">

                            <div class="form-group">
                                <label>Challan Date </label>
                                <input type="text" id="pro_challan_date" name="pro_challan_date" class="form-control"
                                        value="{{ old('pro_challan_date', isset($proChallan) ? $proChallan->pro_challan_date ?? '' : '') }}">
                            </div>

                            {{-- <div class="form-group">
                                @error('category_name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                               
                                <label for="entry_date">Entry Date</label>
                                <input type="text" class="form-control datetimepicker" id="entry_date" placeholder="Materialname" name="entry_date">
                            </div> --}}
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                @error('category_name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <label for="exampleInputEmail1">Challan No</label>
                                <input type="text" class="form-control" readonly id="pro_challan_no"  name="pro_challan_no" value="{{ $proChallan->pro_challan_no }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                @error('store_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <label>Order No</label>
                                <select class="form-control select2" name="production_work_order_id" id="proID">
                                    <option>Select Order No</option>
                                    @foreach ( $proWorkOrders as $workOrder)
                                        <option value="{{ $workOrder->id }}" @if($workOrder->id == $proChallan->production_work_order_id) selected="selected" @endif>{{ $workOrder->production_order_no }}

                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">   
                                <label for="exampleInputEmail1">Item</label>
                                <input type="text" class="form-control" readonly="readonly" placeholder="Materialname" id="item_name" value="{{ $proChallan->item->name}}">
                            </div>
                        </div> 
                        <div class="col-md-3">
                            <div class="form-group">   
                                <label for="exampleInputEmail1">Fabric</label>
                                <input type="text" class="form-control" readonly="readonly" placeholder="Materialname" id="fabric_name" value="{{ $proChallan->materialSetup->material_name}}">
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">   
                                <label for="exampleInputEmail1">Total Quantity</label>
                                <input type="text" class="form-control" readonly="readonly" placeholder="Materialname" id="total_quantity" value="{{ $proChallan->total_quantity}}">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                @error('size_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <label>Size</label>
                                <select class="form-control select2" name="size_id" id="size_id">
                                    <option>Select Size</option>
                                    @foreach ( $sizes as $size)
                                        <option value="{{ $size->id }}" >{{ $size->size }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 d-none">
                            <div class="form-group">   
                                <label for="exampleInputEmail1">Item ID</label>
                                <input type="text" class="form-control" readonly="readonly" placeholder="Materialname" id="item_id" value="{{ $proChallan->item_id }}">
                            </div>
                        </div> 
                        <div class="col-md-3 d-none">
                            <div class="form-group">   
                                <label for="exampleInputEmail1">Material Setup ID</label>
                                <input type="text" class="form-control" readonly="readonly" placeholder="Materialname" id="material_setup_id" value="{{ $proChallan->material_setup_id }}">
                            </div>
                        </div> 
                        <div class="col-md-3 d-none">
                            <div class="form-group">   
                                <label for="exampleInputEmail1">Production ID</label>
                                <input type="text" class="form-control" readonly="readonly" placeholder="Materialname" id="production_work_order_id" value="{{ $proChallan->production_work_order_id }}">
                               
                            </div>
                        </div> 
                        
                        
                        
                    </div>
                    <a class="btn btn-success addItem"><i class="fa fa-plus-circle"></i>Add Item</a>
                    
                    
                </div>
                <!-- /.card-body -->
                
                    <div class="card-body"> 
                    <form method="POST" action="{{ route('production-challan.update', $proChallan->id) }}">
                            @csrf
                            @method('PUT')
                
                            <table class="table-sm table-bordered" width="100%">
                                <input type="hidden" name="pro_challan_date" id="pro_challan_datee" value="{{ $proChallan->pro_challan_date }}">
                                <input type="hidden" name="pro_challan_no" value="{{ $proChallan->pro_challan_no }}">
                               pr <input type="hidden" name="production_work_order_id" id="production_work_order_id_edit" 
                               value="{{ $proChallan->production_work_order_id }}">
                                It<input type="hidden" name="item_id" id="item_id_edit" 
                                value="{{ $proChallan->item_id }}">
                                Mt<input type="hidden" name="material_setup_id" id="material_setup_id_edit" 
                                value="{{ $proChallan->material_setup_id }}">
                                <input type="hidden" name="total_quantity" id="total_quantity_edit" value="{{ $proChallan->total_quantity }}">
                                {{-- <input type="text" name="description" id="description_edit" value="{{ $proChallan->description }}"> --}}
                                <thead>
                                    <th>Size</th>
                                    <th>Assign Qty</th>
                                    <th>Action</th>
                                </thead>
                                <tbody id="addRow" class="addRow">
                                    @foreach($productionChallanItems as $item)
                                        <tr class="delete_add_more_item_edit" id="delete_add_more_item_edit">
                                            {{-- <input type="hidden" name="requsition_no" value="{{ $item->requsition_no }}">
                                            <input type="hidden" name="material_setup_id[]" value="{{ $item->material_setup_id }}">--}}
                                                  
                                            <td>
                                                <input type="hidden" name="size_id[]" value="{{ $item->size_id }}">  
                                                {{ $item->size->size }}</td>
                                            <td>
                                                <div class="input-group" style="width: 250px;">
                                                <input type="text" class="form-control text-right assign_quantity" name="assign_quantity[]" value="{{$item->assign_quantity}}">
                                                </div>
                                            </td>
                                            <td>
                                                <i class="btn btn-danger btn-sm fa fa-window-close removeitem"></i>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tbody>
                                    <tr>
                                        <td colspan="1" class="text-right text-bold">Total Quantity</td>
                                         <td>
                                           <input type="text" name="assign_quantity_total" 
                                            id="assign_quantity_total" class="form-control text-right assign_quantity_total" readonly value="{{$proChallan->assign_quantity_total}}">
                                         </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="col-md-12">
                                <div class="form-group">   
                                    <label for="exampleInputEmail1">Description</label>
                                    <textarea class="form-control" name="description" rows="4" cols="50">
                                        {{ $proChallan->description }}
                                    </textarea>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary mt-4">Update</button>
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

<script id="document-template" type="text/x-handlebars-template"> 
    <tr class="delete_add_more_item" id="delete_add_more_item">
        <input type="hidden" name="pro_challan_date" value="@{{ pro_challan_date }}">
        <input type="hidden" name="pro_challan_no" value="@{{ pro_challan_no }}">
        <input type="hidden" name="production_work_order_id" value="@{{ production_work_order_id }}">
        <input type="hidden" name="item_id" value="@{{ item_id }}">
        <input type="hidden" name="material_setup_id" value="@{{ material_setup_id }}">
        <input type="hidden" name="total_quantity" value="@{{ total_quantity }}">
        <input type="hidden" name="size_id[]" value="@{{ size_id }}">

        <td>@{{ size }}</td>
        <td>
            <div class="input-group" style="width: 250px;">
            <input type="text" class="form-control text-right assign_quantity" name="assign_quantity[]" id="assign_quantity" value="">
            <span class="input-group-text d-none">Pcs</span>
            </div></td>
        <td><i class="btn btn-danger btn-sm fa fa-window-close removeitem"></i></td>
    </tr>
</script>

<script>
    $(document).ready(function(){
        $(document).on("click",".addItem", function(){

            var pro_challan_date         = $('#pro_challan_date').val();
            var pro_challan_no           = $('#pro_challan_no').val();
            var production_work_order_id = $('#proID').val();
            var production_order_no      = $('#proID').find('option:selected').text();
            var item_id                  = $('#item_id').val();
            var material_setup_id        = $('#material_setup_id').val();
            var total_quantity           = $('#total_quantity').val();
            var size_id                  = $('#size_id').val();
            var size                     = $('#size_id').find('option:selected').text();
            var assign_quantity          = $('#assign_quantity').val();
            var assign_quantity_total    = $('#assign_quantity_total').val();
            var description              = $('#description').val();

            var source   = $("#document-template").html();
            var template = Handlebars.compile(source);

            var data = {

            pro_challan_date         : pro_challan_date,
            pro_challan_no           : pro_challan_no,
            production_work_order_id : production_work_order_id,
            production_order_no      : production_order_no,
            item_id                  : item_id,
            material_setup_id        : material_setup_id,
            size_id                  : size_id,
            size                     : size,
            total_quantity           : total_quantity,
            assign_quantity          : assign_quantity,
            assign_quantity_total    : assign_quantity_total,
        
            }

            var html = template(data);
            $("#addRow").append(html);

        });

        $(document).on("click",".removeitem", function(event){

            $(this).closest(".delete_add_more_item_edit").remove();
            $(this).closest(".delete_add_more_item").remove();

            totalQuantity();

        });

        $(document).on('keyup click','.assign_quantity', function(){

            // var assign_quantity = $(this).closest("tr").find("input.assign_quantity").val();

            // var total = assign_quantity + assign_quantity;

            // $(this).closest("tr").find("input.assign_quantity_total").val(total);

            totalQuantity();
        });

        function totalQuantity(){
            var sum = 0;
            $(".assign_quantity").each(function(){
                var value = $(this).val();
                if(!isNaN(value) && value.length !=0){
                    sum += parseFloat(value);
                }
            });

            $('#assign_quantity_total').val(sum);
        }

    });
</script>

<script>
    $(document).ready(function(){
        $('#proID').change(function(event){
        var idPro = this.value;
        
            $.ajax({
                        url: "{{ url('/get-work-order') }}/" + idPro,
                        type: 'GET',
                        dataType: 'json',
                        data: {
                        production_work_order_id: idPro,
                        _token: "{{ csrf_token() }}"
                        },
                        success:function(data){ 
                        
                        let material = data;
                        $('#production_work_order_id').val(idPro);
                        $('#production_work_order_id_edit').val(idPro);
                        $('#item_id').val(material.item_id);
                        $('#item_id_edit').val(material.item_id);
                        $('#material_setup_id').val(material.fabric[0].material_setup_id);
                        $('#material_setup_id_edit').val(material.fabric[0].material_setup_id);
                        $('#item_name').val(material.item);
                        $('#fabric_name').val(material.fabric[0].name);
                        $('#total_quantity').val(material.total_quantity);
                        $('#total_quantity_edit').val(material.total_quantity);
                        
                        }

                    });
        
        });

    });
</script>

{{-- <script>
    $('#proID').change(function () {
    
        let id = $(this).val();
        if (!id) return;
    
        $.ajax({
            url: '/get-work-order/' + id,
            type: 'GET',
            success: function (data) {
    
                // Basic fields
                $('#item_name').val(data.item ?? '');
                $('#total_quantity').val(data.total_quantity ?? '');
                $('#item_id').val(data.item_id ?? '');
                $('#production_work_order_id').val(id);
    
                let fabricHtml = 'No Fabric Found';
                $('#material_setup_id').val('');
    
                // ✅ Take only first fabric
                if (data.fabric && data.fabric.length > 0) {
    
                    let firstFabric = data.fabric[0];
    
                    // Show only one fabric name
                    fabricHtml = firstFabric.name;
    
                    // Auto set single material_setup_id
                    $('#material_setup_id').val(firstFabric.material_setup_id);
                }
    
                $('#fabric_name').val(fabricHtml);
            }
        });
    });
</script>  --}}


<script>
    $(document).ready(function () {
        $('#pro_challan_date').datetimepicker({
            format: 'd-m-Y'  // Format compatible with MySQL DATETIME
             
        });
    });
    window.addEventListener('click', function () {
    var source = document.getElementById('pro_challan_date');
    var target = document.getElementById('pro_challan_datee');
    target.value = source.value;
});
</script>
{{-- <script>
    $('#proID').on('change', function () {
        $('#production_work_order_id_edit').val($(this).val());
    });

    $('#item_id').on('change', function () {
        $('#item_id_edit').val($(this).val());
    });

    $('#material_setup_id').on('change', function () {
        $('#material_setup_id_edit').val($(this).val());
    });
</script> --}}


@endsection 





  
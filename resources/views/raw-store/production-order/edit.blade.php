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
              <li class="breadcrumb-item active">Edit Production Order</li>
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
                <h3 class="card-title">Production Order Edit</h3>
              </div>
              <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Order Entry Date </label>
                                    <input type="text" id="order_entry_date" name="order_entry_date" class="form-control"
                                    value="{{ old('order_entry_date', isset($productionOrder) ? $productionOrder->order_entry_date ?? '' : '') }}">
                                </div>
                            </div>

                             <div class="col-md-3">
                                <div class="form-group">
                                    <label>Order Delivery Date </label>
                                    <input type="text" id="order_delivery_date" name="order_delivery_date" class="form-control"
                                    value="{{ old('order_entry_date', isset($productionOrder) ? $productionOrder->order_delivery_date ?? '' : '') }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    @error('category_name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <label for="exampleInputEmail1">Production Order No</label>
                                    <input type="text" class="form-control" readonly id="production_order_no" placeholder="Materialname" name=" " value={{ $productionOrder->production_order_no}}>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    @error('master_info_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <label>Order To</label>
                                    <select class="form-control select2" name="master_info_id" id="master_info_id">
                                        <option>Select Master</option>
                                        @foreach ($allMaster as $master)
                                            {{-- <option value="{{ $master->id }}">{{ $master->name }}</option> --}}
                                            <option value="{{ $master->id }}" @if($master->id == $productionOrder->master_info_id) selected="selected" @endif>{{ $master->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    @error('store_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <label>Type</label>
                                    <select class="form-control" name="store_id" id="store_id">
                                        <option>Select Type</option>
                                        @foreach ($allStoreCategorie as $categorie)
                                            <option value="{{ $categorie->id }}" >{{ $categorie->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group d-none">   
                                    <label for="exampleInputEmail1">Unit ID</label>
                                    <input type="text" class="form-control" readonly="readonly" placeholder="Materialname" name="unit_id" id="unitID">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group d-none">   
                                    <label for="exampleInputEmail1">Unit Name</label>
                                    <input type="text" class="form-control" readonly="readonly" placeholder="Materialname" name="unit_name" id="unitName">
                                </div>
                            </div>

                                <div class="col-md-3">
                                <div class="form-group d-none">   
                                    <label for="exampleInputEmail1">Unit ID</label>
                                    <input type="text" class="form-control" readonly="readonly" placeholder="Materialname" name="unit_id_ac" id="unitIDAc">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group d-none">   
                                    <label for="exampleInputEmail1">Unit Name</label>
                                    <input type="text" class="form-control" readonly="readonly" placeholder="Materialname" name="unit_name_ac" id="unitNameAc">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group d-none">   
                                    <label for="exampleInputEmail1">Consumtion</label>
                                    <input type="text" id="consumption_qty" name="unit_yeard" class="form-control" placeholder="Consumption Qty" readonly>

                                </div>
                            </div>
                           
                        {{-- <div class="col-md-3">
                            <div class="form-group">
                                @error('store_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <label>Select Material</label>
                                <select class="form-control" name="material_setup_id" id="matID">
                                    <option>Select Material</option>
                                    @foreach ( $allMaterial as $material)
                                        <option value="{{ $material->id }}">{{ $material->material_name }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">   
                                <label for="exampleInputEmail1">Stock</label>
                                <input type="text" class="form-control" readonly="readonly" placeholder="Materialname" name="stock" id="stock">
                            </div>
                        </div> 
                        <div class="col-md-3 d-none">
                            <div class="form-group">   
                                <label for="exampleInputEmail1">Unit ID</label>
                                <input type="text" class="form-control" readonly="readonly" placeholder="Materialname" name="unit_id" id="unitID">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">   
                                <label for="exampleInputEmail1">Before Date</label>
                                <input type="text" class="form-control" readonly="readonly" placeholder="Materialname" name="entry_date" id="entryDate">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">   
                                <label for="exampleInputEmail1">Before Quantity</label>
                                <input type="text" class="form-control" readonly="readonly" placeholder="Materialname" name="buying_qty" id="buyingQty">
                            </div>
                        </div>
                         <div class="col-md-3">
                            <div class="form-group">   
                                <label for="exampleInputEmail1">Unit Name</label>
                                <input type="text" class="form-control" readonly="readonly" placeholder="Materialname" name="unit_name" id="unitName">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">   
                                <label for="exampleInputEmail1">Before Unit Price</label>
                                <input type="text" class="form-control" readonly="readonly" placeholder="Materialname" name="unit_price" id="unitPrice">
                            </div>
                        </div>
                         --}}
                    </div>
                    <div id="fabric" style="display:none">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    @error('store_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <label>Item</label>
                                    <select class="form-control select2" id="itemID" name="item_id">
                                        <option>Select Item</option>
                                        @foreach ($allItem as $item)
                                            <option value="{{ $item->item_id }}">{{ $item->item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                               <div class="form-group">
                                    @error('store_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <label>Fabirc</label>
                                    <select id="material" name="material_setup_id" class="form-control select2">
                                        <option value="">Select Material</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                               <div class="form-group">
                                    @error('store_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <label>Bahar</label>
                                    <select id="bahar" name="bahar_id" class="form-control select2">
                                        <option value="">Select Bahar</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                               <div class="form-group">
                                    @error('store_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <label>Size</label>
                                    <select id="size" name="size_id" class="form-control select2">
                                        <option value="">Select Size</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <a class="btn btn-success addItem"><i class="fa fa-plus-circle"></i>Add Fabric</a>
                    </div> 
                    <div id="accessories" style="display:none">
                        <div class="row">
                            <div class="col-md-3">
                               <div class="form-group">
                                    @error('store_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <label>Accessories</label>
                                    <select class="form-control select2" id="materialAc" name="material_setup_id_ac">
                                        <option>Select Accessories</option>
                                        @foreach ($allAccessories as $accessories)
                                            <option value="{{ $accessories->id }}">{{ $accessories->material_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                               <div class="form-group">
                                    @error('store_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <label>Size</label>
                                    <select class="form-control select2" id="sizeAc" name="size_id_ac">
                                        <option>Select Size</option>
                                        @foreach ($allSizeAccessories as $size)
                                            <option value="{{ $size->id }}">{{ $size->size }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <a class="btn btn-success addItemAc"><i class="fa fa-plus-circle"></i>Add Accessories</a>
                    </div>                    
                    
  
                </div>
                <!-- /.card-body -->
                
                    <div class="card-body"> 
                        <form method="POST" action="{{ route('production-work-order.update', $productionOrder->id) }}" >
                            @csrf
                            @method('PUT') 
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="text-center">Production Order</h3>
                                </div>
                            </div>
                            <div class="row" style="border:0px solid black">
                                    <div class="col-md-8" style="border:0px solid white">
                                        <div id="addItemFabric">

                                        </div>
                                        <table class="table-sm table-bordered" width="100%">
                                            <h4 class="text-left">Fabric</h4>
                                            {{-- <h2 class="text-left">Item Name</h2>
                                            <h3 class="text-left">Bahar</h3> --}}
                                            <input type="hidden" name="order_entry_date" id="order_entry_datee" value="{{ $productionOrder->order_entry_date }}">
                                            <input type="hidden" name="order_delivery_date" id="order_delivery_datee" value="{{ $productionOrder->order_delivery_date }}">
                                            <input type="hidden" name="production_order_no" value="{{ $productionOrder->production_order_no }}">
                                            <input type="hidden" name="master_info_id" id="master_info_id_edit" value="{{ $productionOrder->master_info_id }}">
                                            <input type="hidden" name="item_id" value="{{ $productionOrder->item_id }}">
                                            <thead>
                                                <th>Item Name</th>
                                                <th>Fabric Name</th>
                                                <th>Bahar</th>
                                                <th>Size</th>
                                                <th>Quantity</th>
                                                <th>Unit Yeard</th>
                                                <th>Yeards</th>
                                                <th>Action</th>
                                            </thead>
                                            <tbody id="addRow" class="addRow">
                                            @foreach($productionOrderFbaricItems as $item)  
                                            <tr class="delete_add_more_item_edit" id="delete_add_more_item_edit">
                                                <input type="hidden" name="production_order_no"  value="{{ $item->production_order_no }}">
                                                <input type="hidden" name="item_id" value="{{ $item->item_id }}">
                                                <input type="hidden" name="material_setup_id[]" value="{{ $item->material_setup_id }}">
                                                <input type="hidden" name="bahar_id[]" value="{{ $item->bahar_id }}">
                                                <input type="hidden" name="size_id[]" value="{{ $item->size_id }}">
                                                <input type="hidden" name="unit_id[]" value="{{ $item->unit_id }}">

                                                    <td>{{ $item->item->name }}</td>
                                                    <td>{{ $item->materialSetup->material_name }}</td>
                                                    <td>{{ $item->bahar->bahar }}</td>
                                                    <td>{{ $item->size->size }}</td>
                                                    <td>
                                                        <div class="input-group" style="width: 250px;">
                                                        <input type="text" class="form-control text-right order_quantity" name="order_quantity[]" value="{{$item->order_quantity}}">
                                                        <span class="input-group-text d-none"> {{$item->unit->name}}</span>
                                                        </div>
                                                    </td>
                                                    
                                                   <td><input type="text" readonly class="form-control text-right consumption_qty" name="unit_yeard[]" value="{{ $item->unit_yeard }}"></td>
                                                    <td><input type="text" class="form-control text-right total_yeard" name="total_yeard[]" value="{{ $item->total_yeard }}"></td>
                                                    <td><i class="btn btn-danger btn-sm fa fa-window-close removeitem"></i></td>
                                            </tr> 
                                            @endforeach                
                                            </tbody>
                                            <tbody>
                                                <tr>
                                                    <td colspan="4" class="text-right text-bold">Total Quantity</td>
                                                    <td>
                                                    <input type="text" name="grand_total_quantity" 
                                                    id="grand_total_quantity" class="form-control text-right grand_total_quantity" readonly style="" value="{{ $productionOrder->grand_total_quantity }}">
                                                    </td>
                                                    <td class="text-right text-bold">Total Yeards</td>
                                                    <td>
                                                    <input type="text" name="grand_total_yeard" id="grand_total_yeard" class="form-control text-right grand_total_yeard" readonly style="" value="{{ $productionOrder->grand_total_yeard }}">
                                                    </td>
                                                </tr>
                                                
                                                                    
                                                {{-- <tr>
                                                    <td colspan="6" class="text-right text-bold">Total Quantity</td>
                                                    <td>
                                                    <input type="text" name="grand_total_quantity" 
                                                    id="grand_total_quantity" class="form-control text-right grand_total_quantity" readonly style="" value="0">
                                                    </td>
                                                </tr> --}}
                                            </tbody>
                                        </table>
                                    </div>                 
                                    <div class="col-md-4" style="border:0px solid white">
                                        <table class="table-sm table-bordered" width="100%">
                                            <h4 class="text-left">Accessoris</h4>
                                            <thead>
                                                <th>Accessories Name</th>
                                                <th>Size</th>
                                                <th>Quantity</th>
                                                <th>Action</th>
                                            </thead>
                                            <tbody id="addRowAc" class="addRowAc">
                                                @foreach($productionOrderAccItems as $item) 
                                                <tr class="delete_add_more_item_acc_edit" id="delete_add_more_item_acc_edit">

                                                    <input type="hidden" name="production_order_no" value="{{ $item->production_order_no }}">
                                                    <input type="hidden" name="material_setup_id_ac[]" value="{{ $item->material_setup_id }}">
                                                    <input type="hidden" name="size_id_ac[]" value="{{ $item->size_id }}">
                                                    <input type="hidden" name="unit_id_ac[]" value="{{ $item->unit_id }}">
                                                    <input type="hidden" name="unit_name_ac[]" value="{{ $item->unit_name }}">

                                                    <td>{{ $item->materialSetup->material_name }}</td>
                                                    <td>{{ $item->size->size }}</td>
                                                    <td>
                                                    <div class="input-group" style="width: 250px;">
                                                    <input type="text" class="form-control text-right order_quantity_ac" name="order_quantity_ac[]" value="{{ $item->order_quantity }}">
                                                    <span class="input-group-text"> {{ $item->unit->name }}</span>
                                                    </div>
                                                    </td>
                                                    <td><i class="btn btn-danger btn-sm fa fa-window-close removeitemac"></i></td>
                                                </tr> 
                                                @endforeach              
                                            </tbody>
                                        </table>
                                    </div>
                              <div class="col-md-12">
                                    <div class="form-group">   
                                        <label for="exampleInputEmail1">Purpose</label>
                                        {{-- <input type="text" class="form-control" placeholder="purpose" name="purpose" id="purpose" value="{{ $productionOrder->purpose }}"> --}}
                                        <textarea class="form-control" name="purpose" rows="4" cols="50" id="purpose">
                                            {{ $productionOrder->purpose }}
                                        </textarea>
                                    </div>
                                </div>   
                                    <button type="submit" class="btn btn-primary toastrDefaultSuccess mt-4"> 
                                        Update 
                                    </button>
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


<script id="document-template" type="text/x-handlebars-template"> 
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
</script>

<script>
    $(document).ready(function(){
        $(document).on("click",".addItem", function(){

            var order_entry_date      = $('#order_entry_date').val();
            var order_delivery_date   = $('#order_delivery_date').val();
            var production_order_no   = $('#production_order_no').val();
            var master_info_id        = $('#master_info_id').val();
            var item_id               = $('#itemID').val();
            var item_name             = $('#itemID').find('option:selected').text();
            var material_setup_id     = $('#material').val();
            var material_name         = $('#material').find('option:selected').text();
            var bahar_id              = $('#bahar').val();
            var bahar                 = $('#bahar').find('option:selected').text();
            var size_id               = $('#size').val();
            var size                  = $('#size').find('option:selected').text();
            var unit_id               = $('#unitID').val();
            var unit_name             = $('#unitName').val();
            var consumption_qty       = $('#consumption_qty').val();
            // var purpose               = $('#purpose').val();

            var source   = $("#document-template").html();
            var template = Handlebars.compile(source);

            var data = {

            order_entry_date      : order_entry_date,
            order_delivery_date   : order_delivery_date,
            production_order_no   : production_order_no,
            master_info_id        : master_info_id,
            item_id               : item_id,
            item_name             : item_name,
            material_setup_id     : material_setup_id,
            bahar_id              : bahar_id,
            bahar                 : bahar,
            size_id               : size_id,
            size                  : size,
            material_name         : material_name,
            unit_id               : unit_id,
            unit_name             : unit_name,
            consumption_qty       : consumption_qty,
            // purpose               : purpose
        
            }
            var html = template(data);
            $("#addRow").append(html);

        });

        $(document).on("click",".removeitem", function(event){

            $(this).closest(".delete_add_more_item_edit").remove();
            $(this).closest(".delete_add_more_item").remove();

            totalYeard();
            totalQuantity();

        });

        $(document).on("click",".addItemAc", function(){

            var production_order_no       = $('#production_order_no').val();
            var item_id               = $('#itemID').val();
            var item_name             = $('#itemID').find('option:selected').text();
            var material_setup_id     = $('#materialAc').val();
            var material_name         = $('#materialAc').find('option:selected').text();
            var size_id               = $('#sizeAc').val();
            var size                  = $('#sizeAc').find('option:selected').text();
            var unit_id               = $('#unitIDAc').val();
            var unit_name             = $('#unitNameAc').val();

            var source   = $("#document-template-ac").html();
            var template = Handlebars.compile(source);

            var data = {

            production_order_no       : production_order_no,
            item_id               : item_id,
            item_name             : item_name,
            material_setup_id     : material_setup_id,
            size_id               : size_id,
            size                  : size,
            material_name         : material_name,
            unit_id               : unit_id,
            unit_name             : unit_name
        
            }

            var html = template(data);
            $("#addRowAc").append(html);

        });

        $(document).on("click"," .removeitemac ", function(event){

            $(this).closest(".delete_add_more_item_acc_edit").remove();
            $(this).closest(".delete_add_more_item_acc").remove();

        });

        $(document).on('keyup click','.order_quantity,.consumption_qty', function(){

            var order_quantity = $(this).closest("tr").find("input.order_quantity").val();
            var consumption_qty = $(this).closest("tr").find("input.consumption_qty").val();

            var total = order_quantity * consumption_qty;

            $(this).closest("tr").find("input.total_yeard").val(total);

            totalYeard();

            totalQuantity();
        });


        function totalYeard(){
            var sum = 0;
            $(".total_yeard").each(function(){
                var value = $(this).val();
                if(!isNaN(value) && value.length !=0){
                    sum += parseFloat(value);
                }
            });

            $('#grand_total_yeard').val(sum);
        }

        function totalQuantity(){
            var sum = 0;
            $(".order_quantity").each(function(){
                var value = $(this).val();
                if(!isNaN(value) && value.length !=0){
                    sum += parseFloat(value);
                }
            });

            $('#grand_total_quantity').val(sum);
        }


    });
</script>

<script>
    document.getElementById('store_id').addEventListener('change', function() {

        let value = this.value;

        // hide both first
        document.getElementById('fabric').style.display = 'none';
        document.getElementById('accessories').style.display = 'none';

        // then show based on selection
        if (value === "1") {
            document.getElementById('accessories').style.display = 'block';
        } else if (value === "2") {
            document.getElementById('fabric').style.display = 'block';
        }
    });
</script>

<script>

$('#master_info_id').on('change', function () {
        $('#master_info_id_edit').val($(this).val());
});

window.addEventListener('click', function () {
    var source = document.getElementById('order_entry_date');
    var target = document.getElementById('order_entry_datee');
    var source = document.getElementById('order_delivery_date');
    var target = document.getElementById('order_delivery_datee');
    target.value = source.value;
});
</script>

<script>
    $(document).ready(function () {
        $('#order_entry_date , #order_delivery_date').datetimepicker({
            format: 'd-m-Y'  // Format compatible with MySQL DATETIME
             
        });
    });
</script>

<script>

    $('#itemID').change(function () {
        let item_id = $(this).val();
        $('#material').html('<option value="">Select Material</option>');
        if (item_id) {
            $.get('/get-materials/' + item_id, function (data) {
                $.each(data, function (i, material) {
                    $('#material').append('<option value="' + material.material_setup_id + '">' + material.material_setup.material_name + '</option>');
                });
            });
        }
    });

    $('#material').change(function () {
        let material_setup_id = $(this).val();
        $('#bahar').html('<option value="">Select Bahar</option>');
        if (material_setup_id) {
            $.get('/get-bahars/' + material_setup_id, function (data) {
                $.each(data, function (i, bahar) {
                    $('#bahar').append('<option value="' + bahar.bahar_id + '">' + bahar.bahar.bahar + '</option>');
                });
            });
        }
    });

    // $('#bahar').change(function () {
    //     let bahar_id = $(this).val();
    //     $('#size').html('<option value="">Select Size</option>');
    //     if (bahar_id) {
    //         $.get('/get-sizes/' + bahar_id, function (data) {
    //             $.each(data, function (i, size) {
    //                 $('#size').append('<option value="' + size.size_id + '">' + size.size.size + '</option>');
    //             });
    //         });
    //     }
    // });


    $('#bahar').change(function () {
        let bahar_id = $(this).val();
        let material_setup_id = $('#material').val();
        $('#size').html('<option value="">Select Size</option>');
        if (bahar_id && material_setup_id) {
            $.get('/get-sizes/' + bahar_id + '/' + material_setup_id, function (data) {
                $.each(data, function (i, size) {
                    $('#size').append('<option value="' + size.size_id + '">' + size.size.size + '</option>');
                });
            });
        }
    });

    $('#size').change(function () {
        let size_id = $(this).val();
        let item_id = $('#itemID').val();
        let material_setup_id = $('#material').val();
        let bahar_id = $('#bahar').val();

        if (size_id) {
            $.ajax({
                url: '/get-consumption-qty',
                type: 'GET',
                data: {
                    item_id: item_id,
                    material_setup_id: material_setup_id,
                    bahar_id: bahar_id,
                    size_id: size_id
                },
                success: function (response) {
                    $('#consumption_qty').val(response.consumption_qty);
                    $('#unitID').val(response.unit_id);
                    $('#unitName').val(response.name);
                }
            });
        } else {
            $('#consumption_qty').val('');
            $('#unitID').val('');
            $('#unitName').val('');
        }
    });

    $('#materialAc').change(function () {
        let id = $(this).val();
        
        if (id) {
            $.ajax({
                url: '/get-unit',
                type: 'GET',
                data: {
                    id: id,
                },
                success: function (response) {
                    $('#unitIDAc').val(response.unit_id);
                    $('#unitNameAc').val(response.name);
                }
            });
        } else {
            $('#unitIDAc').val('');
            $('#unitNameAc').val('');
        }
    });

</script>



@endsection 







  
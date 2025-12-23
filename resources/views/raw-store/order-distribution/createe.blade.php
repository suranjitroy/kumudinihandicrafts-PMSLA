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
              <li class="breadcrumb-item active">Add Order Distribution</li>
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
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Order Distribution</h3>
              </div>
              <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-group">
                                @error('store_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <label>Work Order No</label>
                                <select class="form-control" name="production_work_order_id" id="proOrderID">
                                    <option>Order No</option>
                                    @foreach ( $allProdOrderNo as $prodOrderNo)
                                        <option value="{{ $prodOrderNo->id }}">{{ $prodOrderNo->production_order_no }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                         
                        <div class="col-md-3">
                            <div class="form-group">   
                                <label for="exampleInputEmail1">Master</label>
                                <input type="text" class="form-control" readonly="readonly" placeholder="Materialname" name="master_info_id" id="masterID">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">   
                                <label for="exampleInputEmail1">Item</label>
                                <input type="text" class="form-control" readonly="readonly" placeholder="Materialname" name="item_id" id="itemID">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">   
                                <label for="exampleInputEmail1">Total Quantity</label>
                                <input type="text" class="form-control" readonly="readonly" placeholder="Materialname" name="item_id" id="qtyID">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">   
                                <label for="exampleInputEmail1">Total Yeard</label>
                                <input type="text" class="form-control" readonly="readonly" placeholder="Materialname" name="item_id" id="totalYD">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">   
                                <label for="exampleInputEmail1">Purpose</label>
                                <input type="text" class="form-control" readonly="readonly" placeholder="Materialname" name="item_id" id="purpose">
                            </div>
                        </div>


                        {{-- <p>Master Name : <span id="masterID"></span></p>
                        <p>Item Name : <span id="itemID"></span></p>
                        <p>Total Quantity : <span id="qtyID"></span></p>
                        <p>Total Yeard : <span id="totalYD"></span></p>
                        <p>Purpose : <span id="purpose"></span></p> --}}
                        


                      
                        
                        
                    </div>
                    <a class="btn btn-success addItem"><i class="fa fa-plus-circle"></i> Add Item</a>
                    
                    
                </div>
                <!-- /.card-body -->
                
                    <div class="card-body"> 
                        <form method="POST" action="{{ route('purchase-store') }}">
                            @csrf                   
                        <table class="table-sm table-bordered" width="100%">
                            <thead>
                                <th>Supplier Name</th>
                                <th>Material Name</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Description</th>
                                <th>Purpose</th>
                                <th>Challan No/Bill No</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </thead>
                            <tbody id="addRow" class="addRow">
                                
                            </tbody>
                            <tbody>
                                <td colspan="7" class="text-right text-bold">Total</td>
                                <td>
                                    <input type="text" name="total" id="total" class="form-control text-right total" readonly
                                    style="" value="0">
                                </td>
                                
                                <td></td>
                            </tbody>
                        </table>

                    <button type="submit" class="btn btn-primary toastrDefaultSuccess">Save </button>  
                    </form>
                    </div>
                    <div class="card-footer">
                    
                    </div>
               

            </div>
          </div>
          @endcan
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

<script>
    $(document).ready(function () {
        $('#entry_date').datetimepicker({
            format: 'Y-m-d H:i:s',   // Format compatible with MySQL DATETIME
            step: 30,               // minute step
        });
    });
</script>

<script id="document-template" type="text/x-handlebars-template"> 
    <tr class="delete_add_more_item" id="delete_add_more_item">
        <input type="hidden" name="entry_date"  value="@{{ entry_date }}">
        <input type="hidden" name="purchase_no" value="@{{ purchase_no }}">
        <input type="hidden" name="supplier_id[]" value="@{{ supplier_id }}">
        <input type="hidden" name="production_work_order_id[]" value="@{{ production_work_order_id }}">
        <input type="hidden" name="unit_id[]" value="@{{ unit_id }}">
        <input type="hidden" name="unit_name[]" value="@{{ unit_name }}">
        <input type="hidden" name="store_id[]" value="@{{ store_id }}">
        <input type="hidden" name="store_category_id[]" value="@{{ store_category_id }}"> 
        <td>@{{ supplier_name }}</td>
        <td>@{{ material_name }}</td>
        <td>
            <div class="input-group" style="width: 250px;">
            <input type="text" class="form-control text-right buying_qty" name="buying_qty[]" value="1">
            <span class="input-group-text"> @{{ unit_name }}</span>
            </div></td>
        <td><input type="text" class="form-control text-right unit_price" name="unit_price[]"></td>
        <td><input type="text" class="form-control" name="description[]"></td>
        <td><input type="text" class="form-control" name="purpose[]"></td>
        <td><input type="text" class="form-control" name="challan_no[]"></td>
        <td><input type="text" class="form-control text-right buying_price" name="buying_price[]"></td>
        <td><i class="btn btn-danger btn-sm fa fa-window-close removeitem"></i></td>
    </tr> 
</script>

<script>
    $(document).ready(function(){
        $(document).on("click",".addItem", function(){

            var entry_date        = $('#entry_date').val();
            var purchase_no       = $('#purchase_no').val();
            var supplier_id       = $('#supplier_id').val();
            var supplier_name     = $('#supplier_id').find('option:selected').text();
            var production_work_order_id = $('#proOrderID').val();
            var material_name     = $('#proOrderID').find('option:selected').text();
            var unit_id           = $('#unitID').val();
            var unit_name         = $('#unitName').val();
            var store_id          = $('#masterID').val();
            var store_category_id = $('#itemID').val();
            var grand_total_quantity = $('#qtyID').val();
            var grand_total_yeard = $('#totalYD').val();
            var purpose = $('#purpose').val();

            var source   = $("#document-template").html();
            var template = Handlebars.compile(source);

            var data = {

            entry_date        : entry_date,
            purchase_no       : purchase_no,
            supplier_id       : supplier_id,
            supplier_name     : supplier_name,
            production_work_order_id : production_work_order_id,
            material_name     : material_name,
            unit_id           : unit_id,
            unit_name         : unit_name,
            store_id          : store_id,
            store_category_id : store_category_id,
            grand_total_quantity: grand_total_quantity,
            grand_total_yeard: grand_total_yeard,
            purpose : purpose

            }

            var html = template(data);
            $("#addRow").append(html);

        });

        $(document).on("click",".removeitem", function(event){

        $(this).closest(".delete_add_more_item").remove();
        totalAmountPrice();
        });

        $(document).on('keyup click','.buying_qty,.unit_price', function(){

            var buying_qty = $(this).closest("tr").find("input.buying_qty").val();
            var unit_price = $(this).closest("tr").find("input.unit_price").val();

            var total = buying_qty * unit_price;

            $(this).closest("tr").find("input.buying_price").val(total);
            totalAmountPrice();
        });

        function totalAmountPrice(){
            var sum = 0;
            $(".buying_price").each(function(){
                var value = $(this).val();
                if(!isNaN(value) && value.length !=0){
                    sum += parseFloat(value);
                }
            });
            $('#total').val(sum);
        }
    });
</script>

<script>
    $(document).ready(function(){
        $('#proOrderID').change(function(event){
        var idMat = this.value;
        $.ajax({
            url: "{{ url('/get-work-order-no') }}",
            type: 'GET',
            dataType: 'json',
            data: {
            production_work_order_id: idMat,
            _token: "{{ csrf_token() }}"
            },
            success:function(data){ 

            let material = data;

            $('#masterID').val(material.master_info.name);
            $('#itemID').val(material.item.name);
            $('#qtyID').val(material.grand_total_quantity);
            $('#totalYD').val(material.grand_total_yeard);
            $('#purpose').val(material.purpose);
            }

        });
        });

    });
  

</script>

<script>
    $(document).ready(function () {
        $('#entry_date').datetimepicker({
            format: 'd-m-Y'  // Format compatible with MySQL DATETIME
             
        });
    });
</script>

@endsection 





  
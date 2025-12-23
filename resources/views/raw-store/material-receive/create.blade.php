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
             <!-- left column -->
          @can('create store')
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Purchase Receive</h3>
              </div>
              <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            {{-- <div class="form-group">
                                @error('category_name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                
                                
                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                            <div class="input-group-append" data-target="#reservationdate" data-toggle="daterangepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                                </div>
                            </div> --}}
                            {{-- <div class="form-group">
                                <label>Date:</label>
                                <div class="input-group date" id="entry_date" data-target-input="nearest">
                                    <input type="text" name="entry_date" id="entry_date" class="form-control datetimepicker-input" 
                                        data-target="#entry_date"/>
                                    <div class="input-group-append" data-target="#entry_date" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="form-group">
                                <label>Entry Date </label>
                                <input type="text" id="entry_date" name="entry_date" class="form-control"
                                        value="{{ old('entry_date', isset($purchase) ? $purchase->even_date ?? '' : '') }}">
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
                                <label for="exampleInputEmail1">Purchase No</label>
                                <input type="text" class="form-control" readonly id="purchase_no" placeholder="Materialname" name="purchase_no" value="{{ $purchaseNo }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                @error('store_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <label>Select Supplier</label>
                                <select class="form-control select2" name="supplier_id" id="supplier_id">
                                    <option>Select Supplier</option>
                                    @foreach ( $allSupplier as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                @error('store_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <label>Select Material</label>
                                <select class="form-control select2" name="material_setup_id" id="matID">
                                    <option>Select Material</option>
                                    @foreach ( $allMaterial as $material)
                                        <option value="{{ $material->id }}">{{ $material->material_name }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                         
                        <div class="col-md-3">
                            <div class="form-group">   
                                <label for="exampleInputEmail1">Store ID</label>
                                <input type="text" class="form-control" readonly="readonly" placeholder="Materialname" name="store_id" id="storeID">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">   
                                <label for="exampleInputEmail1">Store Category ID</label>
                                <input type="text" class="form-control" readonly="readonly" placeholder="Materialname" name="store_category_id" id="storeCatID">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">   
                                <label for="exampleInputEmail1">Unit ID</label>
                                <input type="text" class="form-control" readonly="readonly" placeholder="Materialname" name="unit_id" id="unitID">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">   
                                <label for="exampleInputEmail1">Unit Name</label>
                                <input type="text" class="form-control" readonly="readonly" placeholder="Materialname" name="unit_name" id="unitName">
                            </div>
                        </div>
                        
                        
                    </div>
                    <a class="btn btn-success addItem"><i class="fa fa-plus-circle"></i>Add Item</a>
                    
                    
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

                    <button type="submit" class="btn btn-primary toastrDefaultSuccess mt-5">Save </button>  
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
        <input type="hidden" name="material_setup_id[]" value="@{{ material_setup_id }}">
        <input type="hidden" name="unit_id[]" value="@{{ unit_id }}">
        <input type="hidden" name="unit_name[]" value="@{{ unit_name }}">
        <input type="hidden" name="store_id[]" value="@{{ store_id }}">
        <input type="hidden" name="store_category_id[]" value="@{{ store_category_id }}"> 
        <td>@{{ supplier_name }}</td>
        <td>@{{ material_name }}</td>
        <td>
            <div class="input-group" style="width: 250px;">
            <input type="text" class="form-control text-right buying_qty" name="buying_qty[]" value="">
            <span class="input-group-text"> @{{ unit_name }}</span>
            </div>
        </td>
        <td>
            <input type="text" class="form-control text-right unit_price" name="unit_price[]">
        </td>
        <td>
            <textarea class="form-control" name="description[]" rows="4" cols="50">
            
            </textarea>
        </td>
        <td>
            <textarea class="form-control" name="purpose[]" rows="4" cols="50">
            
            </textarea>
        </td>
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
            var material_setup_id = $('#matID').val();
            var material_name     = $('#matID').find('option:selected').text();
            var unit_id           = $('#unitID').val();
            var unit_name         = $('#unitName').val();
            var store_id          = $('#storeID').val();
            var store_category_id = $('#storeCatID').val();

            var source   = $("#document-template").html();
            var template = Handlebars.compile(source);

            var data = {

            entry_date        : entry_date,
            purchase_no       : purchase_no,
            supplier_id       : supplier_id,
            supplier_name     : supplier_name,
            material_setup_id : material_setup_id,
            material_name     : material_name,
            unit_id           : unit_id,
            unit_name         : unit_name,
            store_id          : store_id,
            store_category_id : store_category_id

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
        $('#matID').change(function(event){
        var idMat = this.value;
        $.ajax({
            url: "{{ url('/get-material') }}",
            type: 'GET',
            dataType: 'json',
            data: {
            material_setup_id: idMat,
            _token: "{{ csrf_token() }}"
            },
            success:function(data){ 

            let material = data.materialID[0];

            $('#unitID').val(material.unit_id);
            $('#unitName').val(material.unit.name);
            $('#storeID').val(material.store_id);
            $('#storeCatID').val(material.store_category_id);
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





  
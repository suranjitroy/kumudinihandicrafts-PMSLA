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
              <li class="breadcrumb-item active">Add Embroidery Order</li>
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
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Embroidery Order Entry</h3>
              </div>
              <!-- /.card-header -->
                <form method="POST" action="{{ route('emb-order-sheet.store') }}">
                @csrf
                <div class="card-body">
                   <div class="form-group">
                    @error('phn_no')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label for="exampleInputEmail1">Embroidery Order No</label>
                    <input type="text" class="form-control" placeholder="Embroidery Order No" name="emb_order_no" id="emb_order_no" value="{{ $orderNo }}">
                  </div>
                  <div class="form-group">
                    @error('name')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    @if(session('message'))
                        <script>
                          toastr.success("{{ session('success') }}");
                        </script>
                        {{-- <div class="alert alert-success">{{ session('message') }}</div> --}}
                    @endif
                    <label for="exampleInputEmail1">Order Entry Date</label>
                    <input type="text" class="form-control" placeholder="entry date" id="order_entry_date" name="order_entry_date">
                  </div>
                  <div class="form-group">
                    @error('name')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    @if(session('message'))
                        <script>
                          toastr.success("{{ session('success') }}");
                        </script>
                        {{-- <div class="alert alert-success">{{ session('message') }}</div> --}}
                    @endif
                    <label for="exampleInputEmail1">Order Delivery Date</label>
                    <input type="text" class="form-control" placeholder="delivery date" id="order_delivery_date" name="order_delivery_date">
                  </div>
                 
                  <div class="form-group">
                    @error('store_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label>Select Group</label>
                    <select class="form-control select2" name="artisan_group_id" id="artisan_group_id">
                      <option>Select Group</option>
                      @foreach ( $artisanGroups as $artisanGroup)
                        <option value="{{ $artisanGroup->id }}">{{ $artisanGroup->group_name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    @error('store_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label>Select Challan</label>
                    <select class="form-control select2" name="production_challan_id" id="production_challan_id">
                      <option>Select Challan </option>
                    @foreach ( $challans as $challan)
                      <option value="{{ $challan->id }}">{{ $challan->pro_challan_no }}</option>
                    @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    @error('phn_no')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label for="exampleInputEmail1">Product Name</label>
                    <input type="text" class="form-control" placeholder="product name" name="product_name">
                  </div>
                  <div class="form-group">
                    @error('phn_no')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label for="exampleInputEmail1">Design Name</label>
                    <input type="text" class="form-control" placeholder="design name" name="design_name">
                  </div>
                  <div class="form-group">
                    @error('phn_no')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label for="exampleInputEmail1">Color Name</label>
                    <input type="text" class="form-control" placeholder="color name" name="color_name">
                  </div>
                  
                  <div class="form-group">
                    @error('phn_no')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label>Description</label>
                    <textarea class="form-control" name="description" rows="4" cols="50">
            
                    </textarea>
                  </div>
                  <div class="form-group">
                    @error('phn_no')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label for="exampleInputEmail1">Quantity</label>
                    <input type="text" class="form-control" placeholder="quantity" name="quantity" id="quantity">
                  </div>
                  <div class="form-group">
                    @error('phn_no')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label for="exampleInputEmail1">Unit Price</label>
                    <input type="text" class="form-control" placeholder="unit price" name="unit_price" id="unit_price">
                  </div>
                  <div class="form-group">
                    @error('phn_no')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label for="exampleInputEmail1">Total</label>
                    <input type="text" class="form-control total" placeholder="total" name="total" id="total">
                  </div>
                  <div class="form-group">
                    @error('phn_no')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label>Remarks</label>
                    <textarea class="form-control" name="remark" rows="4" cols="50">
            
                    </textarea>
                  </div>
                </div>
                
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary toastrDefaultSuccess">Save</button>  
                </div>
              </form>
                <!-- /.card-body -->
                
                    
                    <div class="card-footer">
                    
                    </div>
               

            </div>
          </div>
          <div class="col-md-6">
            <table class="table table-bordered mt-3">
              <thead>
                  <tr>
                      <th>Size</th>
                      <th>Assign Quantity</th>
                  </tr>
                  <tr>
                    <th>Total Quantity</th>
                    <th><span id="assign_total">0</span></th>
                  </tr>
              </thead>
              <tbody id="challanData"></tbody>
              {{-- <p>Total: <span id="assign_total">0</span></p> --}}
          </table>
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
        $('#order_entry_date').datetimepicker({
            format: 'd-m-Y'  // Format compatible with MySQL DATETIME
             
        });
    });
</script>
<script>
  $(document).ready(function () {
        $('#order_delivery_date').datetimepicker({
            format: 'd-m-Y'  // Format compatible with MySQL DATETIME
             
        });
    });
</script>

<script>
    $(document).ready(function(){
        $('#matID').change(function(event){
        var idMat = this.value;
        
            $.ajax({
                        url: "{{ url('/get-material-requsition') }}",
                        type: 'GET',
                        dataType: 'json',
                        data: {
                        material_setup_id: idMat,
                        _token: "{{ csrf_token() }}"
                        },

                        success:function(data){ 
                        
                        let material = data;
                        $('#stock').val(material.quantity);
                        $('#unitName').val(material.unit.name);
                        $('#unitID').val(material.unit_id);
                        if (material.purchase_item.length > 0) {
                        $('#entryDate').val(material.purchase_item[0].entry_date);
                        $('#buyingQty').val(material.purchase_item[0].buying_qty);
                        }else{
                            $("#entryDate").val('00-00-0000');
                            $("#buyingQty").val(0);
                        }

                        }

                    });
        
        });

    });
</script>

{{-- <script>
  $('#production_challan_id').change(function () {
      let challanId = $(this).val();
      $('#challanData').html('');

      if (!challanId) return;

      $.get("{{ url('get-production-challan-details') }}/" + challanId, function (data) {
          data.forEach(item => {
              $('#challanData').append(`
                  <tr>
                      <td>${item.size.size}</td>
                      <td>${item.assign_quantity}</td>
                  </tr>                  
              `);
          });
          $('#assign_total').html(data.challan[0].assign_quantity_total);
          

      });
  });
</script> --}}

<script>
$('#production_challan_id').change(function () {

    let challanId = $(this).val();
    $('#challanData').html('');
    $('#assign_total').html(0);

    if (!challanId) return;

    $.get("{{ url('get-production-challan-details') }}/" + challanId, function (data) {

        data.items.forEach(item => {
            $('#challanData').append(`
                <tr>
                    <td>${item.size.size}</td>
                    <td>${item.assign_quantity}</td>
                </tr>
            `);
        });

        // ✅ Show total
        $('#assign_total').html(data.assign_total);

    });
});
</script>


<script>
    $(document).ready(function () {
    
        function calculateTotal() {
            let quantity   = parseFloat($('#quantity').val()) || 0;
            let unitPrice  = parseFloat($('#unit_price').val()) || 0;
    
            let total = quantity * unitPrice;
    
            $('#total').val(total.toFixed(2)); // 2 decimal places
        }
    
        // Recalculate when quantity or unit yeard changes
        $('#quantity, #unit_price').on('input', function () {
            calculateTotal();
        });
    
    });
</script>



{{-- <script>
$('#quantity, #unit_price').keyup(function () {
    let qty = $('#quantity').val() || 0;
    let price = $('#unit_price').val() || 0;
    $('#total').val(qty * price);
});
</script> --}}




@endsection 





  
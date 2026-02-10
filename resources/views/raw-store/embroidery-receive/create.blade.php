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
              <li class="breadcrumb-item active">Add Embroidery Order Receive</li>
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
                <h3 class="card-title">Embroidery Order Receive Entry</h3>
              </div>
              <!-- /.card-header -->
                <form method="POST" action="{{ route('embroidery-receive.store') }}">
                @csrf
                <div class="card-body">
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
                    <label for="exampleInputEmail1">Order Receive Date</label>
                    <input type="text" class="form-control" placeholder="receive date" id="receive_date" name="receive_date">
                  </div>
                  <div class="form-group">
                    @error('store_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label>Select Order No</label>
                    <select class="form-control select2" name="embroidery_order_id" id="embroidery_order_id">
                      <option>Select Order</option>
                    @foreach ( $embOrders as $embOrder)
                      <option value="{{ $embOrder->id }}">{{ $embOrder->emb_order_no }}</option>
                    @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    @error('phn_no')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label for="exampleInputEmail1">Receive Quantity</label>
                    <input type="text" class="form-control" placeholder="quantity" name="receive_quantity">
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
            <div id="orderDetails" style="display:none;">

              <div class="mb-2">
                  <label>Order Date</label>
                  <input type="text" id="order_entry_date" class="form-control" readonly>
              </div>

              <div class="mb-2">
                  <label>Group Name</label>
                  <input type="text" id="group_name" class="form-control" readonly>
              </div>

              <div class="mb-2">
                  <label>Order Quantity</label>
                  <input type="text" id="order_qty" class="form-control" readonly>
              </div>

              <div class="mb-2">
                  <label>Unit Price</label>
                  <input type="text" id="unit_price" class="form-control" readonly>
              </div>

              <div class="mb-2">
                  <label>Total</label>
                  <input type="text" id="total" class="form-control" readonly>
              </div>

              <div class="mb-2">
                  <label>Description</label>
                  {{-- <input type="text" class="form-control" readonly> --}}
                  <textarea class="form-control" id="description" name="remark" rows="4" cols="50" readonly>
            
                  </textarea>
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
        $('#receive_date').datetimepicker({
            format: 'd-m-Y'  // Format compatible with MySQL DATETIME
             
        });
    });
</script>

{{-- <script>
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
</script> --}}

{{-- <script>
$('#embroidery_order_id').change(function () {

    let orderId = $(this).val();
    $('#orderData').html('');

    if (!orderId) return;

    $.get("{{ url('get-embroidery-order-details') }}/" + orderId, function (data) {

        data.items.forEach(item => {
            $('#orderData').append(`
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
</script> --}}

<script>
$(document).ready(function () {

    $('#embroidery_order_id').change(function () {
        let orderId = $(this).val();

        if (!orderId) {
            $('#orderDetails').hide();
            return;
        }

        $.ajax({
            url: '/get-embroidery-order/' + orderId,
            type: 'GET',
            success: function (data) {
                $('#orderDetails').show();

                $('#group_name').val(data.artisan_group.group_name);
                $('#order_qty').val(data.quantity);
                $('#order_entry_date').val(data.order_entry_date);
                $('#description').val(data.description);
                $('#unit_price').val(data.unit_price);
                $('#total').val(data.total);
            },
            error: function () {
                alert('Order not found!');
                $('#orderDetails').hide();
            }
        });
    });

});
</script>


@endsection 





  
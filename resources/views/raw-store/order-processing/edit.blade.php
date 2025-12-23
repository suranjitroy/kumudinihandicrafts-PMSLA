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
              <li class="breadcrumb-item active">Order Processing</li>
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
                <h3 class="card-title">Order Processing </h3>
              </div>
              <!-- /.card-header -->

                <!-- /.card-body -->
                
                    <div class="card-body"> 
                        <form method="POST" action="{{ route('order.processing.store.update', $productionOrder->id) }}" >
                             @csrf
                             {{-- @method('PUT') --}}
                            <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    @error('category_name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <label for="exampleInputEmail1">Production Order No</label>
                                    <input type="hidden" name="production_work_order_id" value={{ $productionOrder->id }}>
                                    <input type="text" class="form-control" readonly  placeholder="Materialname" value={{ $productionOrder->production_order_no}}>
                                   
                                </div>
                            </div>
                            
                            {{-- <div class="col-md-3">
                                <div class="form-group">
                                    @error('master_info_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <label>Assign To</label>
                                    <select class="form-control" name="status" >
                                        <option>Select Assign</option>
                                        @foreach ($allProcessList as $list)
                                            <option value="{{ $list-> }}" @if($master->id == $productionOrder->master_info_id) selected="selected" @endif>{{ $master->name }}</option>
                                        @endforeach
                                        <option value="Tailor" @if($data->status == "Tailor") selected="selected" @endif>
                                            Tailor
                                        </option>
                                        <option value="Embroidery" @if($data->status == "Embroidery") selected="selected" @endif>Embroidery</option>
                                        <option value="Wash" @if($data->status == "Wash") selected="selected" @endif>Wash</option>
                                    </select>
                                </div>
                            </div> --}}
                            {{-- {{ dd($data) }} --}}
                              <div class="col-md-3">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="process_section_id">
                                        <option value="">Select Section</option>
                                         @foreach($processSections as $processSection)
                                            <option value="{{ $processSection->id }}" 
                                                {{$processSection->id  ==  optional($data)->process_section_id ? 'selected' : '' }}
                                                {{-- @if($processSection->id == $data->process_section_id) selected="selected" @endif --}}
                                                
                                                >
                                                {{ $processSection->name }}
                                            </option>
                                        @endforeach
                                        {{-- <option value="Tailor" @if(!empty($data) && $data->status == "Tailor") selected @endif>Tailor</option>
                                        <option value="Embroidery" @if(!empty($data) && $data->status == "Embroidery") selected @endif>Embroidery</option>
                                        <option value="Wash" @if(!empty($data) && $data->status == "Wash") selected @endif>Wash</option> --}}
                                    </select>
                                </div>
                            </div>

                    </div>
 
                           
                            <div class="row" style="border:0px solid black">
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
            <input type="text" class="form-control text-right order_quantity" name="order_quantity[]" value="1">
            <span class="input-group-text"> @{{ unit_name }}</span>
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
            <input type="text" class="form-control text-right order_quantity_ac" name="order_quantity_ac[]" value="1">
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
    // document.getElementById('order_entry_date').addEventListener('click', function () {
    //     document.getElementById('order_entry_datee').value = this.value;
    // });
    document.getElementById('master_info_id').addEventListener('change', function () {
    document.getElementById('master_info_id_edit').value = this.value;
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

    $('#bahar').change(function () {
        let bahar_id = $(this).val();
        $('#size').html('<option value="">Select Size</option>');
        if (bahar_id) {
            $.get('/get-sizes/' + bahar_id, function (data) {
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





  
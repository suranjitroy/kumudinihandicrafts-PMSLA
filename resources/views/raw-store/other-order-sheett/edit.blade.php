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
              <li class="breadcrumb-item active">Other Order Sheet Edit</li>
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
                <h3 class="card-title">Other Order Sheet Edit</h3>
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
                                <input type="text" id="other_order_entry_date" name="other_order_entry_date" class="form-control"
                                        value="{{ old('other_order_entry_date', isset($otherordersheet) ? $otherordersheet->other_order_entry_date ?? '' : '') }}">
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
                                <label for="exampleInputEmail1">Other Order No</label>
                                <input type="text" class="form-control" readonly id="other_order_no" placeholder="Materialname" name="other_order_no" value={{ $otherordersheet->other_order_no}}>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                @error('section_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <label>Select Section</label>
                                <select class="form-control select2" name="section_id" id="section_id">
                                    <option>Select Section</option>
                                    @foreach ( $allSection as $section)
                                        <option value="{{ $section->id }}" @if($section->id == $otherordersheet->section_id) selected="selected" @endif>{{ $section->name }}</option>
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
                        {{-- <div class="col-md-3">
                            <div class="form-group">   
                                <label for="exampleInputEmail1">Stock</label>
                                <input type="text" class="form-control" readonly="readonly" placeholder="Materialname" name="stock" id="stock">
                            </div>
                        </div>  --}}
                        <div class="col-md-3 d-none">
                            <div class="form-group">   
                                <label for="exampleInputEmail1">Unit ID</label>
                                <input type="text" class="form-control" readonly="readonly" placeholder="Materialname" name="unit_id" id="unitID">
                            </div>
                        </div>
                        {{-- <div class="col-md-3">
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
                        </div> --}}
                        <div class="col-md-3">
                            <div class="form-group">   
                                <label for="exampleInputEmail1">Unit Name</label>
                                <input type="text" class="form-control" readonly="readonly" placeholder="Materialname" name="unit_name" id="unitName">
                            </div>
                        </div>
                        
                        
                    </div>
                    <a class="btn btn-success addItem"><i class="fa fa-plus-circle"></i> Add Item</a>
                    
                    
                </div>
                <!-- /.card-body -->
                
                    <div class="card-body"> 
                        <form method="POST" action="{{ route('other-order-sheet.update', $otherordersheet->id) }}" >
                            @csrf
                            @method('PUT')                  
                            <table class="table-sm table-bordered" width="100%">
                                <input type="hidden" name="other_order_entry_date" id="other_order_entry_datee" value="{{ $otherordersheet->other_order_entry_date }}">
                                <input type="hidden" name="other_order_no" value="{{ $otherordersheet->other_order_no }}">
                                <input type="hidden" name="section_id" id="section_id_edit" value="{{ $otherordersheet->section_id }}">
                                <thead>
                                    <th>Material Name</th>
                                    <th>Quantity</th>
                                    <th>Action</th>
                                </thead>
                                <tbody id="addRow" class="addRow">
                                    @foreach($otherordersheetitems as $item)
                                        <tr class="delete_add_more_item_edit" id="delete_add_more_item_edit">
                                            <input type="hidden" name="other_order_no" value="{{ $item->other_order_no }}">
                                            <input type="hidden" name="material_setup_id[]" value="{{ $item->material_setup_id }}">
                                            <input type="hidden" name="unit_id[]" value="{{ $item->unit_id }}">
                                            <input type="hidden" name="unit_name[]" value="{{ $item->unit_name }}">
                                            <td>
                                                {{ $item->materialSetup->material_name }}</td>
                                            <td>
                                                <div class="input-group" style="width: 250px;">
                                                <input type="text" class="form-control text-right quantity" name="quantity[]" value="{{$item->quantity}}">
                                                <span class="input-group-text"> {{ $item->unit->name  }}</span>
                                                </div></td>
                                            <td><i class="btn btn-danger btn-sm fa fa-window-close removeitem"></i></td>
                                        </tr> 
                                    @endforeach
                                </tbody>
                            </table>

                            <button type="submit" class="btn btn-primary toastrDefaultSuccess mt-5">Update </button>  
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
        <input type="hidden" name="other_order_entry_date" value="@{{ other_order_entry_date }}">
        <input type="hidden" name="other_order_no" value="@{{ other_order_no }}">
        <input type="hidden" name="section_id" value="@{{ section_id }}">
        <input type="hidden" name="material_setup_id[]" value="@{{ material_setup_id }}">
        <input type="hidden" name="unit_id[]" value="@{{ unit_id }}">
        <input type="hidden" name="unit_name[]" value="@{{ unit_name }}">
        <td>@{{ material_name }}</td>
        <td>
            <div class="input-group" style="width: 250px;">
            <input type="text" class="form-control text-right quantity" name="quantity[]" value="">
            <span class="input-group-text"> @{{ unit_name }}</span>
            </div></td>
        <td><i class="btn btn-danger btn-sm fa fa-window-close removeitem"></i></td>
    </tr> 
</script>

<script>
    $(document).ready(function(){
        $(document).on("click",".addItem", function(){

            var other_order_entry_date = $('#other_order_entry_date').val();
            var other_order_no     = $('#other_order_no').val();
            var section_id        = $('#section_id').val();
            var material_setup_id = $('#matID').val();
            var material_name     = $('#matID').find('option:selected').text();
            var unit_id           = $('#unitID').val();
            var unit_name         = $('#unitName').val();

            var source   = $("#document-template").html();
            var template = Handlebars.compile(source);

            var data = {

            other_order_entry_date   : other_order_entry_date,
            other_order_no     : other_order_no,
            section_id        : section_id,
            material_setup_id : material_setup_id,
            material_name     : material_name,
            unit_id           : unit_id,
            unit_name         : unit_name

            }

            var html = template(data);
            $("#addRow").append(html);

        });

        $(document).on("click",".removeitem", function(event){

        $(this).closest(".delete_add_more_item_edit").remove();
        $(this).closest(".delete_add_more_item").remove();
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


<script>
    $(document).ready(function () {
        $('#other_order_entry_date').datetimepicker({
            format: 'd-m-Y'  // Format compatible with MySQL DATETIME
             
        });
    });
</script>

<script>


// document.getElementById('section_id_edit').addEventListener('change', function () {
//     document.getElementById('section_id_edit').value = this.value;
// });

  $('#section_id').on('change', function () {
        $('#section_id_edit').val($(this).val());
    });

// document.getElementById('section_id').addEventListener('change', function () {
//     document.getElementById('section_id_edit').value = this.value;
//     //console.log("Hello");
    
// });

window.addEventListener('click', function () {
    var source = document.getElementById('other_order_entry_date');
    var target = document.getElementById('other_order_entry_datee');
    target.value = source.value;
});
</script>

@endsection 





  
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
              <li class="breadcrumb-item active">Edit Consumption Setup</li>
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
                <h3 class="card-title">Consumption Setup Edit</h3>
              </div>
              <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                @error('item_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <label>Select Item</label>
                                <select class="form-control select2" name="item_id" id="itemID">
                                    <option>Select Item</option>
                                    @foreach ( $allItem as $item)
                                        <option value="{{ $item->id }}" @if($item->id == $consumption->item_id) selected="selected" @endif>{{ $item->name }}</option>
                                    @endforeach
                                   
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                @error('material_setup_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <label>Select Material</label>
                                <select class="form-control select2" name="material_setup_id" id="material_setup_id">
                                    <option>Select Material</option>
                                    @foreach ( $allMaterial as $material)
                                        <option value="{{ $material->id }}" @if($material->id == $consumption->material_setup_id) selected="selected" @endif>{{ $material->material_name }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                @error('bahar_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <label>Bahar</label>
                                <select class="form-control select2" name="bahar_id" id="baharID">
                                    <option>Select Bahar</option>
                                    @foreach ( $allBahar as $bahar)
                                        <option value="{{ $bahar->id }}" @if($bahar->id == $consumption->bahar_id) selected="selected" @endif>{{ $bahar->bahar }}</option>
                                    @endforeach

                                </select>
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
                                    @foreach ( $allSize as $size)
                                        <option value="{{ $size->id }}">{{ $size->size }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 d-none">
                            <div class="form-group">   
                                <label for="exampleInputEmail1">Unit ID</label>
                                <input type="text" class="form-control" readonly="readonly" placeholder="Materialname" name="unit_id" id="unitID">
                            </div>
                        </div>
                         <div class="col-md-3 d-none">
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
                        <form method="POST" action="{{ route('consumption-setup.update', $consumption->id) }}" >
                            @csrf
                            @method('PUT')                  
                            <table class="table-sm table-bordered" width="100%">
                                 <input type="hidden" name="item_id" id="item_id_edit" value="{{ $consumption->item_id }}">
                                 <input type="hidden" name="material_setup_id" id="material_setupp_id_edit" value="{{ $consumption->material_setup_id }}">
                                 <input type="hidden" name="bahar_id" id="baharr_id" value="{{ $consumption->bahar_id }}">
                                <thead>
                                    <th>Size</th>
                                    <th>Consumption</th>
                                    <th>Action</th>
                                </thead>
                                <tbody id="addRow" class="addRow">
                                    @foreach($consumptionItems as $key => $item)
                                        <tr class="delete_add_more_item_edit"> 
                                            
                                            <input type="hidden" name="size_id[]" value="{{ $item->size_id }}">
                                            <input type="hidden" name="unit_id[]" value="{{ $item->unit_id }}">
                                            <input type="hidden" name="unit_name[]" value="{{ $item->unit->name }}">
                                            <td>
                                                {{ $item->size->size }}</td>
                                            <td>
                                                <div class="input-group" style="width: 250px;">
                                                <input type="text" class="form-control text-right consumption_qty" name="consumption_qty[]" value="{{$item->consumption_qty}}">
                                                <span class="input-group-text"> {{ $item->unit->name  }}</span>
                                                </div></td>
                                            <td><i class="btn btn-danger btn-sm fa fa-window-close removeitem"></i></td>
                                        </tr> 
                                    @endforeach
                                </tbody>
                            </table>

                            <button type="submit" class="btn btn-primary toastrDefaultSuccess mt-5">Update</button>  
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
        <input type="hidden" name="item_id" value="@{{ item_id }}">
        <input type="hidden" name="material_setup_id" value="@{{ material_setup_id }}">
        <input type="hidden" name="bahar_id" value="@{{ bahar_id }}">
        <input type="hidden" name="size_id[]" value="@{{ size_id }}">
        <input type="hidden" name="unit_id[]" value="@{{ unit_id }}">
        <input type="hidden" name="unit_name[]" value="@{{ unit_name }}">
        <td>@{{ size }}</td>
        <td>
            <div class="input-group" style="width: 250px;">
            <input type="text" class="form-control text-right quantity" name="consumption_qty[]">
            <span class="input-group-text"> @{{ unit_name }}</span>
            </div></td>
        <td><i class="btn btn-danger btn-sm fa fa-window-close removeitem"></i></td>
    </tr> 
</script>

<script>
    $(document).ready(function(){
        $(document).on("click",".addItem", function(){

            var item_id           = $('#itemID').val();
            var material_setup_id = $('#material_setup_id').val();
            var bahar_id          = $('#baharID').val();
            var size_id           = $('#size_id').val();
            var size              = $('#size_id').find('option:selected').text();
            var unit_id           = $('#unitID').val();
            var unit_name         = $('#unitName').val();

            var source   = $("#document-template").html();
            var template = Handlebars.compile(source);

            var data = {

            item_id             : item_id,
            material_setup_id   : material_setup_id,
            bahar_id            : bahar_id,
            size_id             : size_id,
            size                : size,
            unit_id             : unit_id,
            unit_name           : unit_name

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
// document.getElementById('itemID').addEventListener('change', function () {
//     document.getElementById('item_id').value = this.value;
// });
// document.getElementById('material_setup_id').addEventListener('change', function () {
//     document.getElementById('material_setupp_id').value = this.value;
// });
// document.getElementById('baharID').addEventListener('change', function () {
//     document.getElementById('baharr_id').value = this.value;
// });
</script>

<script>
    $(document).ready(function(){
        $('#material_setup_id').change(function(event){
        var idMat = this.value;
        
            $.ajax({
                        url: "{{ url('/get-material-consumption') }}",
                        type: 'GET',
                        dataType: 'json',
                        data: {
                        material_setup_id: idMat,
                        _token: "{{ csrf_token() }}"
                        },
                        success:function(data){ 
                        let material = data.materialID[0];
                        $('#unitName').val(material.unit.name);
                        $('#unitID').val(material.unit_id);
                    
                        }

                    });
        
        });

    });
</script>

<script>
    $(document).ready(function(){
        $('#size_id').change(function(event){
        var idSize = this.value;
        
            $.ajax({
                        url: "{{ url('/get-size-consumption') }}",
                        type: 'GET',
                        dataType: 'json',
                        data: {
                        size_id: idSize,
                        _token: "{{ csrf_token() }}"
                        },
                        success:function(data){ 
                        let material = data.sizeID[0];
                        $('#unitName').val(material.unit.name);
                        $('#unitID').val(material.unit_id);
                        }

                    });
        
        });

    });
</script>
 
<script>
  $('#itemID').on('change', function () {
        $('#item_id_edit').val($(this).val());
    });
  $('#material_setup_id').on('change', function () {
        $('#material_setupp_id_edit').val($(this).val());
    });
  $('#baharID').on('change', function () {
        $('#baharr_id').val($(this).val());
    });

</script>
@endsection 





  
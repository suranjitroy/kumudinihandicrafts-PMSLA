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
              <li class="breadcrumb-item active">Add New Worker</li>
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
                <h3 class="card-title">Other Order Entry</h3>
              </div>
              <!-- /.card-header -->
                <form method="POST" action="{{ route('other-order-sheet.store') }}">
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
                    <label for="exampleInputEmail1">Entry Date</label>
                    <input type="text" class="form-control" placeholder="entry date" id="other_order_entry_date" name="other_order_entry_date">
                  </div>
                  <div class="form-group">
                    @error('phn_no')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label for="exampleInputEmail1">Other Order No</label>
                    <input type="text" class="form-control" placeholder="Other order no" name="other_order_no" id="other_order_no" value="{{ $otherOrderNo }}">
                  </div>
                  <div class="form-group">
                    @error('store_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label>Select Section</label>
                    <select class="form-control select2" name="section_id" id="section_id">
                      <option>Select Section</option>
                      @foreach ( $allSection as $section)
                        <option value="{{ $section->id }}">{{ $section->name }}</option>
                      @endforeach
                    </select>
                  </div>
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
                  <div class="form-group">
                    @error('phn_no')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label for="exampleInputEmail1">Quantity</label>
                    <input type="text" class="form-control" placeholder="quantity" name="quantity">
                  </div>
                  <div class="form-group">
                    @error('phn_no')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label for="exampleInputEmail1">Unit</label>
                    <input type="hidden" id="unitID" name="unit_id" placeholder="unit" class="form-control"
                      value="">
                     <input type="text" id="unitName"  placeholder="unit" class="form-control"
                      value="">
                  </div>
                  <div class="form-group">
                    @error('phn_no')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label>Remarks</label>
                    <textarea class="form-control" name="remarks" rows="4" cols="50">
            
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
        $('#other_order_entry_date').datetimepicker({
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

@endsection 





  
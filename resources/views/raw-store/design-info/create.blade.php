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
              <li class="breadcrumb-item active">Design Information Entry</li>
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
                <h3 class="card-title">Design Information Entry</h3>
              </div>
              <!-- /.card-header -->
              <form method="POST" action="{{ route('design-info.store') }}" enctype="multipart/form-data">
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
                    <label>Entry Date </label>
                        <input type="text" id="design_entry_date" name="design_entry_date" class="form-control"
                        value="{{ old('design_entry_date', isset($purchase) ? $requsition->requsition_date ?? '' : '') }}">
                  </div>
                  <div class="form-group">
                    @error('phn_no')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label for="exampleInputEmail1">Design No</label>
                    <input type="text" readonly class="form-control" placeholder="Phone no" name="design_no" value="{{ $designNo }}" >
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
                    <label for="exampleInputEmail1">Product Name</label>
                    <input type="text" class="form-control" placeholder="product name" name="product_name">
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
                    <label for="exampleInputEmail1">Design Name</label>
                    <input type="text" class="form-control" placeholder="design name" name="design_name">
                  </div>
                  
                  <div class="form-group">
                    @error('phn_no')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label for="exampleInputEmail1">Description</label>
                    {{-- <input type="text" class="form-control" placeholder="address" name="address"> --}}
                    <textarea class="form-control" name="description" rows="4" cols="50">
                   
                    </textarea>
                  </div>
                   <div class="form-group">
                    @error('store_id')
                      <div class="alert alert-danger">{{ $message }}</div>
                     @enderror
                    <label>Select Material</label>
                    <select class="form-control select2" name="material_setup_id">
                      <option>Select Material</option>
                      @foreach ( $allMaterial as $material)
                      <option value="{{ $material->id }}">{{ $material->material_name }}</option>
                      @endforeach
                      </select>
                      </div>
                   {{-- <div class="form-group">
                    @error('phn_no')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label for="exampleInputEmail1">Image</label>
                   <input type="file" name="design_image" class="form-control">
                  </div> --}}


                    <div class="form-group">
                    
                    <label for="design_image">Design Image</label>

                    <div class="d-flex gap-2">
                      <label class="btn btn-outline-primary">
                          <i class="bi bi-upload"></i> Upload Image
                          <input type="file"
                                name="design_image"
                                id="design_image"
                                accept="image/*"
                                onchange="previewImage(event)"
                                hidden>
                      </label>
                    </div>
                   
                    <div class="mt-2">


                        <img
                            id="imagePreview"
                            src="{{ isset($data) && $data->design_image
                                    ? asset('storage/'.$data->design_image)
                                    : asset('images/no-image.png') }}"
                            alt="Preview"
                            style="max-width: 200px; display: block; border: 1px solid #ddd; padding: 5px; border-radius: 6px;"
                        >
                    </div>
                </div>










                  <div class="form-group">
                    @error('phn_no')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label for="exampleInputEmail1">Remarks</label>
                    {{-- <input type="text" class="form-control" placeholder="address" name="address"> --}}
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
        $('#design_entry_date').datetimepicker({
            format: 'd-m-Y'  // Format compatible with MySQL DATETIME
             
        });
    });
</script>

<script>
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('imagePreview');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function (e) {
            preview.src = e.target.result;
        };

        reader.readAsDataURL(input.files[0]);
    }
}

function removePreview() {
    const input = document.getElementById('design_image');
    const preview = document.getElementById('imagePreview');
    const wrapper = document.getElementById('previewWrapper');

    input.value = '';          // clear file input
    preview.src = '';          // remove image
    wrapper.style.display = 'none';
}
</script>

@endsection 





  
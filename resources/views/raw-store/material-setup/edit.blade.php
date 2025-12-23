@extends('layouts.app')

@section('content')
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
              <li class="breadcrumb-item active">Edit Store Category</li>
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
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Store Category</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="{{ route('material-setup.update', $materialSetup->id) }}">
                @csrf
                @method('PUT')
                {{-- {{ dd($storeCategoryID) }} --}}
                   <div class="card-body">
                    <div class="form-group">
                      @error('store_id')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                        <label>Select Store</label>
                        <select class="form-control select2" name="store_id" id="storeID">
                          <option>Select Store</option>
                          @foreach ( $stores as $store)
                            <option value="{{ $store->id }}" @if($store->id == $materialSetup->store_id) selected="selected"  @endif>{{ $store->name }}</option>
                          @endforeach

                        </select>
                      </div>
                          
                    <div class="form-group">
                        <label>Select Store Category</label>
                        <select class="form-control select2" id="storeCatID" name="store_category_id" placeholder="Select Store Category">
                           @foreach ( $storeCategories as $storeCategory)
                          <option value="{{ $storeCategory->id }}" @if($storeCategory->id == $storeCategoryID) selected="selected" @endif>{{ $storeCategory->category_name }}</option>
                          @endforeach
                        </select>
                    </div>

                  <div class="form-group">
                    @error('category_name')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    @if(session('message'))
                        <script>
                          toastr.success("{{ session('success') }}");
                        </script>
                        {{-- <div class="alert alert-success">{{ session('message') }}</div> --}}
                    @endif
                    <label for="exampleInputEmail1">Material Name</label>
                    <input type="text" class="form-control" id="exampleInputEmail1"  name="material_name" value="{{ $materialSetup->material_name }}">
                  </div>
                  <div class="form-group">
                      @error('store_id')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                        <label>Select Unit</label>
                        <select class="form-control select2" name="unit_id">
                          <option>Select Unit</option>
                          @foreach ( $units as $unit)
                            <option value="{{ $unit->id }}" @if($unit->id == $unitID) selected="selected" @endif>{{ $unit->name }}</option>
                          @endforeach
                        </select>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary toastrDefaultSuccess">Update Material</button>  
                </div>
              </form>
            </div>
          </div>
          <div class="col-md-6">
            <!-- /.card -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Material Setup List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="store" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th style="width: 10px">SL No</th>
                      <th>Store Name</th>
                      <th>Store Category Name</th>
                      <th>Material Name</th>
                      <th>Unit Name</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ( $materialSetups as $materialSetup )
                    <tr>
                      <td>{{ $materialSetup->id }}</td>
                      <td>{{ $materialSetup->store->name }}</td>
                      <td>{{ $materialSetup->storeCategory->category_name }}</td>
                      <td>{{ $materialSetup->material_name}}</td>
                      <td>{{ $materialSetup->unit->name  }}</td>
                      
                      <td>
                        @can('update store')
                          <a href="{{ route('material-setup.edit', $materialSetup->id) }}" class="btn btn-info"><i class="fa fa-edit"></i>
                          </a>
                        @endcan
                        {{-- <a href="{{ route('store.delete', $store->id) }}" class="btn btn-danger" id="delete">Delete</a> --}}
                        @can('delete store')
                        <form action="{{ route('material-setup.destroy', $materialSetup->id) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-danger" id="delete"><i class="fa fa-trash"></i></button>
                        </form>
                         @endcan
                      </td> 
                    </tr>
                   @endforeach
                  
                  </tbody>
                  {{-- <tfoot>
                  <tr>
                      <th style="width: 10px">SL No</th>
                      <th>store Name</th>
                      <th>Action</th>
                    </tr>
                  </tfoot> --}}
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
       </div>
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection

@section('scripts')
<script>
  $(function(){
      $(document).on('change','#storeID', function(){
        var store_id = $(this).val();
        $.ajax({
          url:  "{{ route('get-store-cat') }}",
          type: "GET",
          data: {store_id:store_id},
          success: function(data){
            var html = '<option value="">Select Store Category</option>';
            $.each(data, function(key, v){
              html +='<option value="'+v.id+'">'+v.category_name+'</option>'
            });
            $('#storeCatID').html(html);
          }
        });
      })
  });
</script>
@endsection
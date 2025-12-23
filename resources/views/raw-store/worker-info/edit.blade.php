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
              <li class="breadcrumb-item active">Edit Worker Information</li>
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
                <h3 class="card-title">Worker Information Edit</h3>
              </div>
              <!-- /.card-header -->
              <form method="POST" action="{{ route('worker-info.update', $worker->id ) }}">
                @csrf

                @method('PUT')
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
                    <label for="exampleInputEmail1">Worker Name</label>
                    <input type="text" class="form-control" placeholder="worker name" name="name" value="{{ $worker->name }}">
                  </div>
                  <div class="form-group">
                    @error('phn_no')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label for="exampleInputEmail1">Phone No</label>
                    <input type="text" class="form-control" placeholder="Phone no" name="phn_no" value="{{ $worker->phn_no }}">
                  </div>
                   <div class="form-group">
                    @error('phn_no')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label for="exampleInputEmail1">Address</label>
                    <input type="text" class="form-control" placeholder="address" name="address" value="{{ $worker->address }}">
                  </div>
                   <div class="form-group">
                    @error('phn_no')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label for="exampleInputEmail1">NID No</label>
                    <input type="text" class="form-control" placeholder="NID No" name="nid_no" value="{{ $worker->nid_no }}">
                  </div>
                   <div class="form-group">
                    @error('phn_no')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label for="exampleInputEmail1">Joining Date</label>
                     <input type="text" id="joining_date" name="joining_date" class="form-control"
                      value="{{ $worker->joining_date }}">
                  </div>
                  <div class="form-group">
                    @error('phn_no')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label for="exampleInputEmail1">Grade</label>
                    <input type="text" class="form-control" placeholder="Grade" name="grade" value="{{ $worker->grade }}">
                  </div>
                   <div class="form-group">
                    @error('phn_no')
                         <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label for="exampleInputEmail1">Emargency Contact No</label>
                    <input type="text" class="form-control" placeholder="Emargency Contact no" name="emargency_phn_no" value="{{ $worker->emargency_phn_no }}">
                  </div>
                </div>
                
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary toastrDefaultSuccess">Update</button>  
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
        $('#joining_date').datetimepicker({
            format: 'd-m-Y'  // Format compatible with MySQL DATETIME
             
        });
    });
</script>

@endsection 





  
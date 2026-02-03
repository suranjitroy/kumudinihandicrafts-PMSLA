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
              <li class="breadcrumb-item active">Fabric Stock</li>
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
          <div class="col-md-12">
            <!-- /.card -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Fabric Stock</h3>
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
                      <th>In Stock</th>
                      <th>Out Stock</th>
                      <th>Stock</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ( $materialSetups as $materialSetup )
                    <tr>
                      <td>{{ $materialSetup->id }}</td>
                      <td>{{ $materialSetup->store->name }}</td>
                      <td>{{ $materialSetup->storeCategory->category_name }}</td>
                      <td>{{ $materialSetup->material_name}}</td>
                      @php
                        $buying_total = App\Models\PurchaseItem::where('store_category_id', $materialSetup->store_category_id)->where('material_setup_id', $materialSetup->id)->where('status', 1)->sum('buying_qty');

                        $sample_total = App\Models\SampleWorkOrderFabricItem::where('material_setup_id', $materialSetup->id)->where('status', 1)->sum('total_yeard');

                        $production_total = App\Models\ProductionWorkOrderFabricItem::where('material_setup_id',$materialSetup->id)->where('status', 1)->sum('total_yeard');

                        $out_total = $sample_total + $production_total;

                      @endphp
                      <td>{{ $buying_total }} {{ $materialSetup->unit->name  }}</td>
                      <td>{{ $out_total }} {{ $materialSetup->unit->name  }}</td>
                      <td>{{ $materialSetup->quantity}} {{ $materialSetup->unit->name  }}</td>
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


  
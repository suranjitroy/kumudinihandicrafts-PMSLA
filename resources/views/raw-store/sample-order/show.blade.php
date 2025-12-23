@extends('layouts.app')

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Sample Order Details</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Manage Work Order</a></li>
              <li class="breadcrumb-item active">Sample Order</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            {{-- <div class="callout callout-info">
              <h5><i class="fas fa-info"></i> Note:</h5>
              This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
            </div> --}}


            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fas fa-globe"></i> Kumudini Handicrafts
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info my-5">
                <div class="col-sm-4 invoice-col">
                  <address>
                    <strong>Order Date : {{ $sampleOrder->order_entry_date }}</strong><br>
                    <strong>Order No : {{ $sampleOrder->sample_order_no }}</strong><br>
                    <strong>Order To : {{ $sampleOrder->masterInfo->name }}</strong><br>
                  </address>
                </div>
                <!-- /.col -->
                {{-- <div class="col-sm-4 invoice-col">
                  To
                  <address>
                    <strong>John Doe</strong><br>
                    795 Folsom Ave, Suite 600<br>
                    San Francisco, CA 94107<br>
                    Phone: (555) 539-1037<br>
                    Email: john.doe@example.com
                  </address>
                </div> --}}
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <strong>Item Name : {{ $item->item->name }}</strong><br>
                  <strong>Fabric Name : {{ $fabric->materialSetup->material_name }}</strong><br>
                  <strong>Bahar Name : {{ $bahar->bahar->bahar }}</strong><br>
                  <strong>Purpose : {{ $sampleOrder->purpose }}</strong><br>
                  
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-md-6 table-responsive">
                  <h3 class="text-center">Fabrics</h3>
                  <table class="table table-striped">
                    <thead>
                      <th>SL No</th>
                      <th>Size</th>
                      <th>Quantity</th>
                      <th>Unit Yeard</th>
                      <th>Yeards</th>

                    </thead>
                    <tbody>
                      @foreach ( $sampleWorkorderFabricItems as $key => $item )
                      <tr>
                            <td>{{ $key + 1}}</td>
                            <td>{{ $item->size->size }}</td>
                            <td>{{ $item->sample_quantity }}</td>
                            <td>{{ $item->unit_yeard  }} {{ $item->unit->name  }}</td>
                            <td>{{ $item->total_yeard  }}</td>
                      </tr> 

                      @endforeach
                    </tbody>
                  </table>
                </div>
                <div class="col-md-6 table-responsive">
                  <h3 class="text-center">Accessories</h3>
                  <table class="table table-striped">
                    <thead>
                      <th>SL No</th>
                      <th>Accessories Name</th>
                      <th>Size</th>
                      <th>Quantity</th>
                    </thead>
                    <tbody>
                      @foreach( $sampleWorkorderAcItems as $key => $item )
                      <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->materialSetup->material_name }}</td>
                        <td>{{ $item->size->size }}</td>
                        <td>{{ $item->sample_quantity }} {{ $item->unit->name }}</td>
                      </tr> 
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">
                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <td style="border:0px solid white;"></td>
                        <td colspan="2" style="border: 0px solid white; width:23%; text-align:right">
                          <strong>Total quantity:</strong>
                        </td>
                        <td class="text-left" style="border: 0px solid white;">
                          <strong>{{ $sampleOrder->grand_total_quantity }}</strong>
                        </td>
                        <td style="border: 0px solid white; width:38%; text-align:right">
                          <strong>Total Yeard:</strong>
                        </td>
                        <td style="border: 0px solid white;">
                          <strong>{{ $sampleOrder->grand_total_yeard }}</strong>
                        </td>
                      </tr>
                      
                      {{-- <tr>
                        <th style="width:40%; border: 1px solid white">Total quantity:</th>
                        <td style="width:60%; border: 1px solid white" class="text-center" >
                          <strong>{{ $sampleOrder->grand_total_quantity }}</strong>
                        </td>
                      </tr>
                      <tr>
                         <th style="width:40%">Total Yeard:</th>
                         <td style="width:60%" class="text-center" >
                          <strong>{{ $sampleOrder->grand_total_yeard }}</strong>
                        </td>
                      </tr> --}}
                     
                    </table>
                  </div>
                </div>
                <div class="col-6">

                </div>
                <!-- /.col -->
               
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  @role('admin')
                    @if($sampleOrder->status == 2 )
                      <form action="{{ route('sample-work-order.approve', $sampleOrder->id) }}" method="POST" class="d-inline">
                          @csrf
                          <button class="btn btn-success"><i class="fa fa-check-circle"></i>Approve</button>
                      </form>
                    @endif
                  @endrole
                  @role('manager')
                  @if($sampleOrder->status == 0) 
                    <form action="{{ route('sample-work-order.recommended', $sampleOrder->id) }}" method="POST" class="d-inline">
                          @csrf
                          <button class="btn btn-warning"><i class="fa fa-check-circle"></i>Recommended</button> 
                    </form>
                  @endif
                  @endrole
                  {{-- <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                    Payment
                  </button>
                  <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                    <i class="fas fa-download"></i> Generate PDF
                  </button> --}}
                </div>
              </div>
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

@endsection
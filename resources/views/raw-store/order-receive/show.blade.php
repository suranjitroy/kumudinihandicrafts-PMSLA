@extends('layouts.app')

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Order Receive Details</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Material Receive</a></li>
              <li class="breadcrumb-item active">Approve</li>
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
                    <small class="float-right"></small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info my-5">
                <div class="col-sm-4 invoice-col">
                  {{-- {{ dd($distribution->OrderDistributionItem->production_work_order_id ) }} --}}
                  <address>
                    <strong>Order Entry Date : {{ $distribution->productionWorkOrder->order_entry_date }}</strong><br>
                    <strong>Order No : {{ $distribution->productionWorkOrder->production_order_no }}</strong><br>
                    <strong>Item : {{ $distribution->productionWorkOrder->item->name }}</strong><br>
                    <strong>Fabric : {{ $distribution->productionWorkOrder->productionWorkOrderFabricItem->first()->materialSetup->material_name  }}</strong><br>
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
                {{-- <div class="col-sm-4 invoice-col">
                  <b>Invoice #007612</b><br>
                  <br>
                  <b>Order ID:</b> 4F3S8J<br>
                  <b>Payment Due:</b> 2/22/2014<br>
                  <b>Account:</b> 968-34567
                </div> --}}
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th>SL No</th>
                      <th>Worker Name</th>
                      <th>Bahar</th>
                      <th>Size</th>
                      <th>Order Quantity</th>
                      <th>Assign Date</th>
                      <th>Delivery Date</th>
                      <th>Assign Quantity</th>
                      <th>Remarks</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ( $distributionItems as $key => $item )
                        <tr>
                            <td>{{ $key + 1}}</td>
                            <td>{{ $item->workerInfo->name }}</td>
                            <td>{{ $item->bahar->bahar }}</td>
                            <td>{{ $item->size->size }}</td>
                            <td>{{ $item->order_quantity }}</td>
                            <td>{{ $item->assing_entry_date }}</td>
                            <td>{{ $item->assing_delivery_date }}</td>
                            <td>{{ $item->assing_quantity }}</td>
                            <td>{{ $item->remarks }}</td>
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
                 
                </div>
                <!-- /.col -->
                <div class="col-6">

                  {{-- <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th style="width:60%">Total:</th>
                        <td style="width:20%" class="text-center" ><strong>{{ $purchase->total}}</strong></td>
                      </tr>
                      <tr>
                        <th></th>
                        <td></td>
                      </tr>
                     
                    </table>
                  </div> --}}
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  {{-- <a href="{{  }}" rel="noopener" target="_blank" class="btn btn-success"><i class="fa fa-check-circle"></i> Approve</a> --}}

                   <form action="{{ route('purchase-receive.approve', $distribution->id) }}" method="POST" class="d-inline">
                        @csrf
                        @role('super-admin|admin')
                        <button class="btn btn-success"><i class="fa fa-check-circle"></i>Approve</button>
                        @endrole
                    </form>
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
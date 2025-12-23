@extends('layouts.app')

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Purchase Requsition Details</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Purchase Requsition</a></li>
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
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info my-5">
                <div class="col-sm-4 invoice-col">
                  <address>
                    <strong>Requsition Date : {{ $purRequsition->pur_requsition_date }}</strong><br>
                    <strong>Requsition No : {{ $purRequsition->pur_requsition_no }}</strong><br>
                    <strong>Requsition From : {{ $purRequsition->section->name }}</strong><br>
                   
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
                      <th>SL No</th>
                      <th>Material Name</th>
                      <th>Quantity</th>
                      <th>Unit Price</th>
                      <th>Amount</th>

                    </thead>
                    <tbody>
                      @foreach ( $purRequsitionItems as $key => $item )
                      <tr>
                            <td>{{ $key + 1}}</td>
                            <td>{{ $item->materialSetup->material_name }}</td>
                            <td>{{ $item->pur_quantity }} {{ $item->unit->name  }}</td>
                            <td>{{ $item->unit_price  }}</td>
                            <td>{{ $item->purchase_req_price  }}</td>
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
                <div class="col-6">

                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th style="width:40%">Total:</th>
                        <td style="width:60%" class="text-center" ><strong>{{ $purRequsition->total}}</strong></td>
                      </tr>
                      <tr>
                        <th></th>
                        <td></td>
                      </tr>
                     
                    </table>
                  </div>
                </div>
                <!-- /.col -->
               
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  @role('admin')
                    @if($purRequsition->status == 2 )
                      <form action="{{ route('purchase-requsition.approve', $purRequsition->id) }}" method="POST" class="d-inline">
                          @csrf
                          <button class="btn btn-success"><i class="fa fa-check-circle"></i>Approve</button>
                      </form>
                    @endif
                  @endrole
                  @role('manager')
                  @if($purRequsition->status == 0) 
                    <form action="{{ route('purchase-requsition.recommended', $purRequsition->id) }}" method="POST" class="d-inline">
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
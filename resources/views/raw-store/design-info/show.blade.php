@extends('layouts.app')

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Design Information</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Manage Design</a></li>
              <li class="breadcrumb-item active">Design Information</li>
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
                    <strong>Design Entry Date : {{ $designInfo->design_entry_date }}</strong><br>
                    <strong>Design No : {{ $designInfo->design_no }}</strong><br>
                    <strong>Product Name : {{ $designInfo->product_name }}</strong><br>
                    <strong>Design Name : {{ $designInfo->design_name }}</strong><br>
                    <strong>Design Code : {{ $designInfo->design_code }}</strong><br>
                    <strong>Fabric Name : {{ $designInfo->materialSetup->material_name }}</strong><br>
                    <strong>Description : {{ $designInfo->description }}</strong><br>
                    <strong>Remarks : {{ $designInfo->remarks }}</strong><br>

                    <img
                        id="imagePreview"
                        src="{{ isset($designInfo) && $designInfo->design_image
                                ? asset('storage/'.$designInfo->design_image)
                                : asset('images/no-image.png') }}"
                        alt="Preview"
                    >
                   
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
              {{-- <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <th>SL No</th>
                      <th>Material Name</th>
                      <th>Quantity</th>
                    </thead>
                    <tbody>
                      @foreach ( $designinfoItems as $key => $item )
                      <tr>
                            <td>{{ $key + 1}}</td>
                            <td>{{ $item->materialSetup->material_name }}</td>
                            <td>{{ $item->quantity }} {{ $item->unit->name  }}</td>
                      </tr>  
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div> --}}
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">
                 
                </div>
                <!-- /.col -->
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  {{-- @role('admin')
                    @if($designinfo->status == 2 || $designinfo->status == 0)
                      <form action="{{ route('store-requsition.approve', $designinfo->id) }}" method="POST" class="d-inline">
                          @csrf
                          <button class="btn btn-success"><i class="fa fa-check-circle"></i>Approve</button>
                      </form>
                    @endif
                  @endrole
                  @role('manager')
                  @if($designinfo->status == 0) 
                    <form action="{{ route('store-requsition.recommended', $designinfo->id) }}" method="POST" class="d-inline">
                          @csrf
                          <button class="btn btn-warning"><i class="fa fa-check-circle"></i>Recommended</button> 
                    </form>
                  @endif
                  @endrole --}}
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
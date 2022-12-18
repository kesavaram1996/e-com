@extends('admin.layouts.main')

@section('main-content')
<section class="section">
    <div class="section-header mt">
        <div class="row">
            <div class="col-6 col-md-6 col-lg-6">
                <h3>{{ __('orders.invoice') }}</h3>
            </div>
            <div class="col-6 col-md-6 col-lg-6">
                {{ Breadcrumbs::render('orders/show/invoice') }}
            </div>
        </div>
    </div>
    <div class="section-body mt">
        @foreach($data as $datas)
        <div class="row" id="print-data">
            <div class="col-md-12">
                <div class="panel panel-default card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">Invoice</h6>
                        </div>
                        <div class="pull-right">
                            <h6 class="txt-dark">Order # {{$datas->id}}</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="row mb-50" style="border-bottom:2px solid #dedede">
                                <div class="col-xs-6">
                                    <img width="150px" src="{{asset('images/adesha_logo.jpg')}}" alt="logo">
                                </div>
                                <div class="col-xs-6 text-right">
                                    <h2 class=""> ADESHA </h2><br>
                                    Phone No: +91 9952979844  Email: nathan@spiderindia.com<br>
                                    GSTIN: <br>
                                    FSSAI Licence:                     
                                </div>
                            </div>
                            <!-- Address Section -->
                            <div class="row">
                                <div class="col-xs-6">
                                    <span class="txt-dark head-font inline-block capitalize-font mb-5">Billed to:</span>
                                    <address class="mb-15">
                                        <span class="address-head mb-5">{{$datas->getuser->name}}</span>
                                        {{$datas->getaddress->address}} <br>
                                        {{$datas->getaddress->getarea->name}}, {{$datas->getaddress->getcity->name}} <br>
                                        {{$datas->getaddress->getstate->name}} - {{$datas->getaddress->pincode}} <br>
                                        Mobile: {{$datas->getaddress->phone}} <br>
                                        Email: {{$datas->getaddress->getbuyer->email}}
                                    </address>
                                </div>
                                <div class="col-xs-6">
                                    <span class="address-head txt-dark">Order ID: </span>{{$datas->id}} <br>
                                    <span class="address-head txt-dark">Date: </span>{{$datas->created_at}} <br>
                                </div>
                            </div>
                            <!-- Table Section -->
                            <div class="invoice-bill-table">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>HSN/SAC</th>
                                                <th>Unit</th>
                                                <th>Qty</th>
                                                <th>Price/Unit</th>
                                                <th>Taxable amount</th>
                                                <th>SGST</th>
                                                <th>CGST</th>
                                                <th>IGST</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php 
                                                $total=0;
                                                $quantity=0; 
                                                $taxable_amount=0; 
                                                $total_sgst_amount=0; 
                                                $total_cgst_amount=0; 
                                                $total_igst_amount=0;
                                                $total_sgst=0;
                                                $total_cgst=0;
                                                $total_igst=0;
                                                $loop_count=0;
                                            @endphp
                                            @foreach($datas->getorderitem as $getorderitems)
                                            @php $taxable_price = $getorderitems->price * $getorderitems->quantity; @endphp
                                            <tr>
                                                <!-- order_id -->
                                                <td width="50px">{{$getorderitems->product_variant_id}}</td>
                                                <!-- Product Name -->
                                                <td width="150px">{{$getorderitems->getorderproductvariant->getproduct->name}}</td>
                                                <!-- hsn_code -->
                                                <td>{{$getorderitems->getorderproductvariant->getproduct->hsn_code}}</td>
                                                <!-- measurement_unit -->
                                                <td>{{$getorderitems->getorderproductvariant->getmeasurementunit->measurement_unit}}</td>
                                                <!-- quantity -->
                                                <td>{{$getorderitems->quantity}}</td>
                                                <!-- Per Product Price -->
                                                @php $price = explode(",",$getorderitems->getorderproductvariant->price); @endphp
                                                <td>₹ {{$price[$datas->getslab->slab_id - 1]}}</td>
                                                <!-- Taxable Price -->
                                                <td>₹ {{$taxable_price}}</td>
                                                <!-- sgst -->
                                                @php $sgst=$taxable_price * ($getorderitems->getorderproductvariant->getproduct->sgst / 100) @endphp
                                                <td>
                                                    @if($datas->invoice_type)
                                                        ₹ {{$sgst}}({{$getorderitems->getorderproductvariant->getproduct->sgst}}%)
                                                    @else
                                                        -
                                                    @endif  
                                                </td>
                                                <!-- cgst -->
                                                @php $cgst=$taxable_price * ($getorderitems->getorderproductvariant->getproduct->cgst / 100) @endphp
                                                <td>
                                                    @if($datas->invoice_type)
                                                        ₹ {{$cgst}}({{$getorderitems->getorderproductvariant->getproduct->cgst}}%)
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <!-- igst -->
                                                @php $igst=$taxable_price * ($getorderitems->getorderproductvariant->getproduct->igst / 100) @endphp
                                                <td>
                                                    @if($datas->invoice_type)
                                                        ₹ {{$igst}}({{$getorderitems->getorderproductvariant->getproduct->igst}}%)
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <!-- sub_total -->
                                                @php $sub_total = $taxable_price + $sgst + $cgst + $igst  @endphp
                                                <td>
                                                    @if($datas->invoice_type)
                                                        {{$sub_total}}
                                                    @else
                                                        {{$taxable_price}}
                                                    @endif
                                                </td>
                                                <!-- Final Total, Total Quantity, Taxable Amount Calculation -->
                                                @php 
                                                    if($datas->invoice_type){
                                                        $total += $sub_total;  
                                                    }else{
                                                        $total += $taxable_price;
                                                    }
                                                    $quantity +=$getorderitems->quantity;
                                                    $taxable_amount +=$taxable_price;
                                                    $total_sgst += $getorderitems->getorderproductvariant->getproduct->sgst;
                                                    $total_cgst += $getorderitems->getorderproductvariant->getproduct->cgst;
                                                    $total_igst += $getorderitems->getorderproductvariant->getproduct->igst;
                                                    $total_sgst_amount += $sgst;
                                                    $total_cgst_amount += $cgst;
                                                    $total_igst_amount += $igst;
                                                    $loop_count = $loop->count;
                                                @endphp
                                            </tr>
                                            @endforeach
                                            <tr class="txt-dark">
                                                <td colspan="4" class="text-right">Total </td>
                                                <td>{{$quantity}}</td>
                                                <td></td>
                                                <td>{{$taxable_amount}}</td>
                                                <td>
                                                    @if($datas->invoice_type)
                                                        ₹ {{$total_sgst_amount}}
                                                    @else
                                                        
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($datas->invoice_type)
                                                        ₹ {{$total_cgst_amount}}
                                                    @else
                                                        
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($datas->invoice_type)
                                                        ₹ {{$total_igst_amount}}
                                                    @else
                                                        
                                                    @endif
                                                </td>
                                                <td>{{$total}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- Final Result section -->
                            <div class="row">
                                <div class="col-xs-6 mt-25" style="vertical-align:center;">
                                    <div class="col-xs-2">
                                        <div class="text-right">
                                            <span class="txt-dark">Type</span><br>
                                            <span>SGST</span><br>
                                            <span>CGST</span><br>
                                            <span>IGST</span><br>
                                        </div>
                                    </div>
                                    <div class="col-xs-5">
                                        <div class="text-right">
                                            <span class="txt-dark">Taxable Amount</span><br>
                                            <span>₹ {{$taxable_amount}}</span><br>
                                            <span>₹ {{$taxable_amount}}</span><br>
                                            <span>₹ {{$taxable_amount}}</span><br>
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <div class="text-right">
                                            <span class="txt-dark">Rate(%)</span><br>
                                            <span>
                                                @if($datas->invoice_type)
                                                    {{$total_sgst/$loop_count}} %
                                                @else
                                                    -
                                                @endif
                                            </span><br>
                                            <span>
                                                @if($datas->invoice_type)
                                                    {{$total_cgst/$loop_count}} %
                                                @else
                                                    -
                                                @endif
                                            </span><br>
                                            <span>
                                                @if($datas->invoice_type)
                                                    {{$total_igst/$loop_count}} %
                                                @else
                                                    -
                                                @endif
                                            </span><br>
                                        </div>
                                    </div>
                                    <div class="col-xs-3">
                                        <div class="text-right">
                                            <span class="txt-dark">Tax Amount</span><br>
                                            <span>
                                                @if($datas->invoice_type)
                                                    ₹ {{$total_sgst_amount}}
                                                @else
                                                    -
                                                @endif
                                            </span><br>
                                            <span>
                                                @if($datas->invoice_type)
                                                    ₹ {{$total_cgst_amount}}
                                                @else
                                                    -
                                                @endif
                                            </span><br>
                                            <span>
                                                @if($datas->invoice_type)
                                                    ₹ {{$total_igst_amount}}
                                                @else
                                                    -
                                                @endif
                                            </span><br>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6" style="vertical-align:center;">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <div class="text-right txt-dark">   
                                                <span>Total Order Price : </span><br>
                                                <span>Delivery Charge :	</span><br>
                                                <span>Discount : </span><br>
                                                <span>Promo Discount : </span><br>
                                                <span>Wallet Used : </span><br>
                                                <span>Final Total : </span>
                                            </div>
                                        </div>
                                        <div class="col-xs-3">
                                            <div class="text-right">
                                                <span>+₹{{$total}}</span><br>
                                                <span>
                                                    @if(!blank($datas->delivery_charge))
                                                        +₹{{$datas->delivery_charge}}
                                                    @else
                                                        -
                                                    @endif
                                                </span><br>
                                                <span>
                                                    @if(!blank($datas->discount))
                                                        -₹{{$datas->discount}}
                                                    @else
                                                        -
                                                    @endif
                                                </span><br>
                                                <span>
                                                    @if(!blank($datas->promo_discount))
                                                        -₹{{$datas->promo_discount}}
                                                    @else
                                                        -
                                                    @endif
                                                </span><br>
                                                <span>
                                                    @if(!blank($datas->credit_paid))
                                                        -₹{{$datas->credit_paid}}
                                                    @else
                                                        -
                                                    @endif
                                                </span><br>
                                                @php $final_total = ($total + $datas->delivery_charge) - ($datas->discount + $datas->promo_discount + $datas->credit_paid); @endphp
                                                <span>= ₹{{$final_total}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Footer Section -->
                            <div class="row mt-20" style="border: 1px solid #dedede;padding:20px;">
                                <div class="col-xs-9">
                                    <div class="txt-dark mt-25">
                                        <span>Terms And Condition:</span>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="text-center">
                                        <span>for, ADESHA</span><br>
                                        <img width="100px" src="{{asset('images/adesha_logo.jpg')}}" alt="logo"><br>
                                        <span>Authorized Signatory</span>
                                    </div>
                                </div>
                            </div>
                            <div class="button-list pull-right">
                                <button type="button" class="btn btn-primary btn-outline btn-icon left-icon" id="print" onclick='javascript:window.print();'> 
                                    <i class="fa fa-print"></i><span> Print</span> 
                                </button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endsection
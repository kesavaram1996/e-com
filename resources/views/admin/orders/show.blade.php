@extends('admin.layouts.main')

@section('main-content')
<style>
        .timeline-steps {
            display: flex;
            justify-content: center;
            flex-wrap: wrap
        }

        .timeline-steps .timeline-step {
            align-items: center;
            display: flex;
            flex-direction: column;
            position: relative;
            margin: 1rem
        }

        @media (min-width:768px) {
            .timeline-steps .timeline-step:not(:last-child):after {
                content: "";
                display: block;
                border-top: .25rem dotted #3b82f6;
                width: 3.46rem;
                position: absolute;
                left: 7.5rem;
                top: .3125rem
            }
            .timeline-steps .timeline-step:not(:first-child):before {
                content: "";
                display: block;
                border-top: .25rem dotted #3b82f6;
                width: 3.8125rem;
                position: absolute;
                right: 7.5rem;
                top: .3125rem
            }
        }

        .timeline-steps .timeline-content {
            width: 10rem;
            text-align: center
        }

        .timeline-steps .timeline-content .inner-circle {
            border-radius: 1.5rem;
            height: 1rem;
            width: 1rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: #a1a3a7
        }

        .timeline-steps .timeline-content .inner-circle:before {
            content: "";
            background-color: #a1a3a7;
            display: inline-block;
            height: 1rem;
            width: 1rem;
            min-width: 1rem;
            border-radius: 2rem;
            opacity: .5
        }
    </style>
<section class="section">
    <div class="section-header mt">
        <div class="row">
            <div class="col-6 col-md-6 col-lg-6">
                <h3>{{ __('orders.show_order') }}</h3>
            </div>
            <div class="col-6 col-md-6 col-lg-6">
                {{ Breadcrumbs::render('orders/show') }}
            </div>
        </div>
    </div>
    <div class="section-body mt">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">{{ __('orders.order_details') }}</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col">
                                    <div class="timeline-steps aos-init aos-animate" data-aos="fade-up">
                                        <div class="timeline-step">
                                            <div class="timeline-content" data-toggle="" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2003">
                                                @if($status_count>=1)
                                                    <div class="inner-circle" style="background-color: #667add;"></div>
                                                    <p class="h6 mt-3 mb-1">{{$data[0]->getstatuses[0]->status}}</p>
                                                    <p class="h6 text-muted mb-0 mb-lg-0">{{date('d-m-Y, h.m.s', strtotime($data[0]->getstatuses[0]->created_at))}}</p>
                                                @else
                                                    <div class="inner-circle"></div>
                                                    <p class="h6 mt-3 mb-1"></p>
                                                    <p class="h6 text-muted mb-0 mb-lg-0"></p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="timeline-step">
                                            <div class="timeline-content" data-toggle="" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2004">
                                                @if($status_count>=2)
                                                    <div class="inner-circle" style="background-color: blue;"></div>
                                                    <p class="h6 mt-3 mb-1">{{$data[0]->getstatuses[1]->status}}</p>
                                                    <p class="h6 text-muted mb-0 mb-lg-0">{{date('d-m-Y, h.m.s', strtotime($data[0]->getstatuses[1]->created_at))}}</p>
                                                @else
                                                    <div class="inner-circle"></div>
                                                    <p class="h6 mt-3 mb-1"></p>
                                                    <p class="h6 text-muted mb-0 mb-lg-0"></p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="timeline-step">
                                            <div class="timeline-content" data-toggle="" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2005">
                                                @if($status_count>=3)
                                                    <div class="inner-circle" style="background-color: pink;"></div>
                                                    <p class="h6 mt-3 mb-1">{{$data[0]->getstatuses[2]->status}}</p>
                                                    <p class="h6 text-muted mb-0 mb-lg-0">{{date('d-m-Y, h.m.s', strtotime($data[0]->getstatuses[2]->created_at))}}</p>
                                                @else
                                                    <div class="inner-circle"></div>
                                                    <p class="h6 mt-3 mb-1"></p>
                                                    <p class="h6 text-muted mb-0 mb-lg-0"></p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="timeline-step">
                                            <div class="timeline-content" data-toggle="" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2010">
                                                @if($status_count>=4)
                                                    <div class="inner-circle" style="background-color: #4aa23c;"></div>
                                                    <p class="h6 mt-3 mb-1">{{$data[0]->getstatuses[3]->status}}</p>
                                                    <p class="h6 text-muted mb-0 mb-lg-0">{{date('d-m-Y, h.m.s', strtotime($data[0]->getstatuses[3]->created_at))}}</p>
                                                @else
                                                    <div class="inner-circle"></div>
                                                    <p class="h6 mt-3 mb-1"></p>
                                                    <p class="h6 text-muted mb-0 mb-lg-0"></p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="timeline-step mb-0">
                                            <div class="timeline-content" data-toggle="" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2020">
                                                @if($status_count>=5)
                                                    <div class="inner-circle" style="background-color: #f8b32d;"></div>
                                                    <p class="h6 mt-3 mb-1">{{$data[0]->getstatuses[4]->status}}</p>
                                                    <p class="h6 text-muted mb-0 mb-lg-0">{{date('d-m-Y, h.m.s', strtotime($data[0]->getstatuses[4]->created_at))}}</p>
                                                @else
                                                    <div class="inner-circle"></div>
                                                    <p class="h6 mt-3 mb-1"></p>
                                                    <p class="h6 text-muted mb-0 mb-lg-0"></p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-9 col-xs-12">
                                    <div class="form-wrap">
                                        @foreach($data as $datas)
                                        <table class="table table-bordered data-table table-hover ml-20">
                                            <thead>
                                                <tr>
                                                    <th width="200px">{{ __('orders.id') }}</th>
                                                    <td id="order_id" >{{$datas->id}}</td>
                                                </tr>
                                                <tr>
                                                    <th width="200px">{{ __('orders.buyer') }}</th>
                                                    <td>{{$datas->getuser->name}}</td>
                                                </tr>
                                                <tr>
                                                    <th width="200px">{{ __('orders.email') }}</th>
                                                    <td>{{$datas->getaddress->getbuyer->email}}</td>
                                                </tr>
                                                <tr>
                                                    <th width="200px">{{ __('orders.contact') }}</th>
                                                    <td>{{$datas->getaddress->phone}}</td>
                                                </tr>
                                                <tr>
                                                    <th width="200px">{{ __('orders.order_by') }}</th>
                                                    <td>{{$datas->getorderbyuser->name}}</td>
                                                </tr>
                                                <tr>
                                                    <th width="200px">{{ __('orders.items') }}</th>
                                                    <td>
                                                        <table class="table table-bordered data-table table-hover">
                                                            <thead>
                                                                <th>{{ __('orders.product_id') }}</th>
                                                                <th>{{ __('orders.name') }}</th>
                                                                <th>{{ __('orders.hsn') }}</th>
                                                                <th>{{ __('orders.unit') }}</th>
                                                                <th>{{ __('orders.qty') }}</th>
                                                                <th>{{ __('orders.price') }}</th>
                                                                <th>{{ __('orders.taxable_amount') }}</th>
                                                                <th>{{ __('orders.sgst') }}</th>
                                                                <th>{{ __('orders.cgst') }}</th>
                                                                <th>{{ __('orders.igst') }}</th>
                                                                <th>{{ __('orders.sub_total') }}</th>
                                                                <th>{{ __('orders.status') }}</th>
                                                                <th>{{ __('orders.actions') }}</th>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    $total=0;
                                                                    $sgst=0;
                                                                    $cgst=0;
                                                                    $igst=0;
                                                                @endphp
                                                                @foreach($datas->getorderitem as $getorderitems)
                                                                    @php $taxable_price = $getorderitems->price * $getorderitems->quantity; @endphp
                                                                    <tr>
                                                                        <!-- id -->
                                                                        <td>{{$getorderitems->product_variant_id}}</td>
                                                                        <!-- Product Name -->
                                                                        <td>{{$getorderitems->getorderproductvariant->getproduct->name}}</td>
                                                                        <!-- HSN Code -->
                                                                        <td>{{$getorderitems->getorderproductvariant->getproduct->hsn_code}}</td>
                                                                        <!-- Measurement with Unit -->
                                                                        <td>{{$getorderitems->getorderproductvariant->measurement}} {{$getorderitems->getorderproductvariant->getmeasurementunit->measurement_unit}}</td>
                                                                        <!-- Quantity -->
                                                                        <td>{{$getorderitems->quantity}}</td>
                                                                        <!-- Per Product Price -->
                                                                        <!-- @php $price = explode(",",$getorderitems->getorderproductvariant->price); @endphp -->
                                                                        <!-- <td>{{$price[$datas->getslab->slab_id - 1]}}</td> -->
                                                                        <td>{{$getorderitems->price}}</td>
                                                                        <!-- Taxable Price -->
                                                                        <td>{{$taxable_price}}</td>
                                                                        <!-- SGST -->
                                                                        @php $sgst=$taxable_price * ($getorderitems->getorderproductvariant->getproduct->sgst / 100); @endphp                                                
                                                                        <td>
                                                                            @if($datas->invoice_type)
                                                                                {{$sgst}}({{$getorderitems->getorderproductvariant->getproduct->sgst}}%)
                                                                            @else
                                                                                -
                                                                            @endif
                                                                        </td>
                                                                        <!-- CGST -->
                                                                        @php $cgst=$taxable_price * ($getorderitems->getorderproductvariant->getproduct->cgst / 100) @endphp
                                                                        <td>
                                                                            @if($datas->invoice_type)
                                                                                {{$cgst}}({{$getorderitems->getorderproductvariant->getproduct->cgst}}%)
                                                                            @else
                                                                                -
                                                                            @endif
                                                                        </td>
                                                                        <!-- IGST -->
                                                                        @php $igst=$taxable_price * ($getorderitems->getorderproductvariant->getproduct->igst / 100) @endphp
                                                                        <td>
                                                                            @if($datas->invoice_type)
                                                                                {{$igst}}({{$getorderitems->getorderproductvariant->getproduct->igst}}%)
                                                                            @else
                                                                                -
                                                                            @endif
                                                                        </td>
                                                                        <!-- Sub Total -->
                                                                        @php $sub_total = ($taxable_price) + $sgst + $cgst + $igst  @endphp
                                                                        <td>
                                                                            @if($datas->invoice_type)
                                                                                {{$sub_total}}
                                                                            @else
                                                                                {{$taxable_price}}
                                                                            @endif
                                                                        </td>
                                                                        <!-- Product Total Calculation -->
                                                                        @php
                                                                            if($datas->invoice_type){
                                                                                $total += $sub_total;  
                                                                            }else{
                                                                                $total += $taxable_price;
                                                                            }
                                                                        @endphp
                                                                        <!-- Active Status -->
                                                                        <td>
                                                                            @if($getorderitems->active_status == 'received')
                                                                                <label class="label label-primary">received</label> 
                                                                            @elseif($getorderitems->active_status == 'processed')
                                                                                <label class="label label-primary">Processed</label>
                                                                            @elseif($getorderitems->active_status == 'shipped')
                                                                                <label class="label label-info">Shipped</label>
                                                                            @elseif($getorderitems->active_status == 'delivered')
                                                                                <label class="label label-success">Delivered</label>
                                                                            @elseif($getorderitems->active_status == 'cancelled')
                                                                                <label class="label label-danger">Cancelled</label>
                                                                            @elseif($getorderitems->active_status == 'returned')
                                                                                <label class="label label-warning">Returned</label>
                                                                            @endif
                                                                        </td>
                                                                        <td><a href="" style="color:red;margin-left:20px" title="delete"><i class="fa-solid fa-trash"></i></a></td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th width="200px">{{ __('orders.total') }} (₹)</th>
                                                    <td>{{$total}}</td>
                                                </tr>
                                                <!-- <tr>
                                                    <th width="200px">{{ __('orders.delivery_charge') }} (₹)</th>
                                                    <td>{{$datas->delivery_charge}}</td>
                                                </tr> -->
                                                <!-- <tr>
                                                    <th width="200px">{{ __('orders.discount') }} ₹ (%)</th>
                                                    <td>{{$datas->discount}}</td>
                                                </tr> -->
                                                <tr>
                                                    <th width="200px">{{ __('orders.promo_code') }}</th>
                                                    <td>{{$datas->promo_code}}</td>
                                                </tr>
                                                <tr>
                                                    <th width="200px">{{ __('orders.promo_discount') }} (₹)</th>
                                                    <td>{{$datas->promo_discount}}</td>
                                                </tr>
                                                <!-- <tr>
                                                    <th width="200px">{{ __('orders.wallet_used') }}</th>
                                                    <td>{{$datas->credit_paid}}</td>
                                                </tr>
                                                <tr>
                                                    <th width="200px">{{ __('orders.discount') }} (%)</th>
                                                    <td><input class="form-control" type="number"><button class="btn btn-primary mt-20" style="margin-left:45%">{{ __('orders.apply') }}</button></td>
                                                </tr> -->
                                                <tr>
                                                    <th width="200px">{{ __('orders.payable_total') }}</th>
                                                    @php $final_total = ($total + $datas->delivery_charge) - ($datas->discount + $datas->promo_discount + $datas->credit_paid)  @endphp
                                                    <td>{{($total + $datas->delivery_charge) - ($datas->discount + $datas->promo_discount + $datas->credit_paid)}}</td>
                                                </tr>
                                                <!-- <tr>
                                                    <th width="200px">{{ __('orders.deliver_by') }}</th>
                                                    <td><select class="form-control" name="" id=""><option value="">Select Delivery Boy</option></select></td>
                                                </tr> -->
                                                <tr>
                                                    <th width="200px">{{ __('orders.payment_method') }}</th>
                                                    <td>{{$datas->payment_method}}</td>
                                                </tr>
                                                
                                                <tr>
                                                    <th width="200px">{{ __('orders.address') }}</th>
                                                    <td>{{$datas->getaddress->address}}</td>
                                                </tr>
                                                <tr>
                                                    <th width="200px">{{ __('orders.order_date') }}</th>
                                                    <td>{{date('d-m-Y', strtotime($datas->created_at))}}</td>
                                                </tr>
                                                <tr>
                                                    <th width="200px">{{ __('orders.status') }}</th>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-xs-9">
                                                                <select id='active_status' class="form-control">
                                                                    <option value="">All Orders</option>
                                                                    <option value="received" {{ $datas->active_status=='received' ? 'selected' : '' }}>Received</option>
                                                                    <option value="processed" {{ $datas->active_status=='processed' ? 'selected' : '' }}>Processed</option>
                                                                    <option value="shipped" {{ $datas->active_status=='shipped' ? 'selected' : '' }}>Shipped</option>
                                                                    <option value="delivered" {{ $datas->active_status=='delivered' ? 'selected' : '' }}>Delivered</option>
                                                                    <option value="cancelled" {{ $datas->active_status=='cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                                    <option value="returned" {{ $datas->active_status=='returned' ? 'selected' : '' }}>Returned</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-xs-3">
                                                                <button class="btn btn-primary" id="change_status">Save</button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                
                                            </thead>
                                            <tbody>
                                        
                                            </tbody>
                                        </table>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-6 col-lg-6">
                                </div>
                                <div class="col-6 col-md-6 col-lg-6">
                                    <a href="#" data-toggle="modal" data-target="#myModal" class="btn btn-primary">Generate Invoice</a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>	
            </div>
        </div>
    </div>
</section>
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Select Invoice Type</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <form action="{{route('orders.get_invoice')}}" method="POST">
                @csrf   
                <input type="hidden" name="order_id" value="{{$datas->id}}">  
                <input type="hidden" name="total" value="{{$total}}">                                                   
                <input type="hidden" name="final_total" value="{{$final_total}}">  
                <div class="col-6 col-md-6 col-lg-6 text-center">
                    <div id="status" class="btn-group">
                        <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                            <input type="radio" name="invoice_type" id="gstinvoice" value="1" {{ $datas->invoice_type==1 ? 'checked':'' }}>  GST 
                        </label>
                    </div>
                </div>
                <div class="col-6 col-md-6 col-lg-6 text-center">
                    <div id="status" class="btn-group">
                        <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                            <input type="radio" name="invoice_type" id="gstinvoice" value="0" {{ $datas->invoice_type==0 ? 'checked':'' }}>  Non-GST 
                        </label>
                    </div>
                </div>
                
          </div>
        </div>
        <div class="modal-footer">
            <div class="text-center">
                <input type="submit" class="btn btn-success" value="Generate Invoice">
            </div>
        </div>
        </form>
      </div>
    </div>
</div>

<script>
    $(document).on("click", "#change_status", function () {
        var status = $('#active_status').val();
        var id = $("#order_id").text();
        $.ajax({
            type:"get",
            url:"/change_status",
            data: { id: id, status: status },
            success:function(res)
            {     
                alert(res)
            }

        });
    });
</script>
@endsection
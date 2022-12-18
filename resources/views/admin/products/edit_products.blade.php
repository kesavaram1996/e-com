@extends('admin.layouts.main')

@section('main-content')
@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif
<style>
    input{
        border: none;
        width : 100px;
        height : 50px;
    }
    select{
        color:inherit !important;
    }
</style>
<section class="section">
    <div class="section-header mt">
        <div class="row">
            <div class="col-6 col-md-6 col-lg-6">
                <h3>{{ __('products.products') }}</h3>
            </div>
            <div class="col-6 col-md-6 col-lg-6">
                {{ Breadcrumbs::render('products/edit_products') }}
            </div>
        </div>
    </div>
    <div class="section-body">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt">
                <div class="panel panel-default card-view panel-refresh">
                    <div class="refresh-container">
                        <div class="la-anim-1"></div>
                    </div>
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">{{ __('products.product_manegement') }}</h6>
                        </div>
                        <div class="pull-right">
                            <p class="">(Once you change value it will update automatically)</p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body row pa-0">
                            <div class="table-wrap">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th>{{ __('products.product_name') }}</th>
                                                <th>{{ __('products.category') }}</th>
                                                <th>{{ __('products.sub_category') }}</th>
                                                <th>{{ __('products.measurement') }}</th>
                                                <th>{{ __('products.measurement_unit') }}</th>
                                                @foreach($prices as $price)
                                                <th>{{$price->title}}</th>
                                                @endforeach
                                                <th>{{ __('products.disc_price') }}</th> 
                                                <th>{{ __('products.stock_unit') }}</th>
                                                <th>{{ __('products.availability') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($data as $keyes => $datas)
                                            <tr>
                                                <td><input type="text" data-id="{{ $datas->getproduct->id }}" value="{{ $datas->getproduct->name }}" name="name" id="name"></td>
                                                <td>
                                                    <select data-id="{{ $datas->getproduct->id }}" name="category_id" id="category_id" class="form-control">
                                                        @foreach($categories as $category)
                                                        <option value="{{$category->id}}" @if($datas->getproduct->getcategory->id==$category->id) selected @endif>{{$category->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select data-id="{{ $datas->getproduct->id }}" name="sub_category_id" id="sub_category_id" class="form-control">
                                                        @foreach($sub_categories as $sub_category)
                                                        <option value="{{$sub_category->id}}" @if($datas->getproduct->getsubcategory->id==$sub_category->id) selected @endif>{{$sub_category->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td><input type="text" data-id="{{ $datas->id }}" value="{{ $datas->measurement }}" name="measurement" id="measurement"></td>
                                                <td>
                                                    <select data-id="{{ $datas->id }}" class="form-control" name="packate_measurement_unit_id" id="packate_measurement_unit_id">
                                                        <option value="1" @if($datas->measurement_unit_id==1) selected @endif>kg</option>
                                                        <option value="2" @if($datas->measurement_unit_id==2) selected @endif>gm</option>
                                                        <option value="3" @if($datas->measurement_unit_id==3) selected @endif>ltr</option>
                                                        <option value="4" @if($datas->measurement_unit_id==4) selected @endif>ml</option>
                                                        <option value="5" @if($datas->measurement_unit_id==5) selected @endif>pack</option>
                                                        <option value="6" @if($datas->measurement_unit_id==6) selected @endif>pc</option>
                                                        <option value="7" @if($datas->measurement_unit_id==7) selected @endif>m</option>
                                                    </select>
                                                </td>
                                                @foreach($prices as $key=> $price)
                                                @php 
                                                    $price_array = explode(",",$datas->price);
                                                @endphp
                                                <td><input data-id="{{ $datas->id }}" data-class="price{{$keyes}}" class="price{{$keyes}}" id="price" type="text" value="{{ $price_array[$key] }}" name="price" id="price{{$key}}"></td>
                                                @endforeach
                                                <td><input data-id="{{ $datas->id }}" type="text" value="@if($datas->discounted_price !=null) {{ $datas->discounted_price}} @else 0.00 @endif" name="discounted_price" id="discounted_price"></td>
                                                <td><input data-id="{{ $datas->id }}" type="text" value="{{ $datas->stock }}" name="stock" id="stock"></td>
                                                <td>
                                                    <select  data-id="{{ $datas->id }}" name="packate_serve_for" id="packate_serve_for" class="form-control" required="">
                                                        <option value="Available" @if($datas->serve_for=="Available") selected @endif>Available</option>
                                                        <option value="Sold Out" @if($datas->serve_for=="Sold Out") selected @endif>Sold Out</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {!! $data->render() !!}
                                </div>
                            </div>	
                        </div>	
                    </div>
                </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function() {
        // Product Name
        $(document).on("change","#name",function() {
            let name = $(this).val();
            let id = $(this).attr("data-id");
            let _token   = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
               type:'POST',
               url:'update_products',
               data : {name:name,_token: _token, id:id},
               success:function(data) {
                location.reload();
               }
            });
        });

        // Category
        $(document).on("change","#category_id",function() {
            let category_id = $(this).val();
            let id = $(this).attr("data-id");
            let _token   = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
               type:'POST',
               url:'update_products',
               data : {category_id:category_id,_token: _token, id:id},
               success:function(data) {
                location.reload();
               }
            });
        });

        //Sub Category
        $(document).on("change","#sub_category_id",function() {
            let sub_category_id = $(this).val();
            let id = $(this).attr("data-id");
            let _token   = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
               type:'POST',
               url:'update_products',
               data : {sub_category_id:sub_category_id,_token: _token, id:id},
               success:function(data) {
                location.reload();
               }
            });
        });

        // Measurement
        $(document).on("change","#measurement",function() {
            let measurement = $(this).val();
            let id = $(this).attr("data-id");
            let _token   = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
               type:'POST',
               url:'update_products',
               data : {measurement:measurement,_token: _token, id:id},
               success:function(data) {
                location.reload();
               }
            });
        });

        // Packate Measurement Unit id
        $(document).on("change","#packate_measurement_unit_id",function() {
            let packate_measurement_unit_id = $(this).val();
            let id = $(this).attr("data-id");
            let _token   = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
               type:'POST',
               url:'update_products',
               data : {packate_measurement_unit_id:packate_measurement_unit_id,_token: _token, id:id},
               success:function(data) {
                location.reload();
               }
            });
        });

        // Price
        $(document).on("change","#price",function() {
            // let class = $(this).attr("data-id");
            // let price = $('class').map((_,el) => el.value).get();
            var priceClass = $(this).attr("data-class");
            let price = $("."+priceClass).map((_,el) => el.value).get();
            console.log(price);
            let id = $(this).attr("data-id");
            let _token   = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
               type:'POST',
               url:'update_products',
               data : {price:price,_token: _token, id:id},
               success:function(data) {
                location.reload();
               }
            });
        });

        // Discounted Price
        $(document).on("change","#discounted_price",function() {
            let discounted_price = $(this).val();
            let id = $(this).attr("data-id");
            let _token   = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
               type:'POST',
               url:'update_products',
               data : {discounted_price:discounted_price,_token: _token, id:id},
               success:function(data) {
                location.reload();
               }
            });
        });

        // Stock
        $(document).on("change","#stock",function() {
            let stock = $(this).val();
            let id = $(this).attr("data-id");
            let _token   = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
               type:'POST',
               url:'update_products',
               data : {stock:stock,_token: _token, id:id},
               success:function(data) {
                location.reload();
               }
            });
        });

        // Packate Serve for
        $(document).on("change","#packate_serve_for",function() {
            let packate_serve_for = $(this).val();
            let id = $(this).attr("data-id");
            let _token   = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
               type:'POST',
               url:'update_products',
               data : {packate_serve_for:packate_serve_for,_token: _token, id:id},
               success:function(data) {
                location.reload();
               }
            });
        });
    });
</script>
@endsection


@extends('admin.layouts.main')

@section('main-content')
@if (count($errors) > 0)
    <div class="alert alert-danger" style="color:white !important">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif
@if ($message = Session::get('success'))
<div class="alert alert-success" style="color:white !important">
  <p>{{ $message }}</p>
</div>
@endif

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">  
<?php
    $arr = 0;
?>
<section class="section">
    <div class="section-header mt">
        <div class="row">
            <div class="col-6 col-md-6 col-lg-6">
                <h3>{{ __('products.products') }}</h3>
            </div>
            <div class="col-6 col-md-6 col-lg-6">
                {{ Breadcrumbs::render('products/edit') }}
            </div>
        </div>
    </div>
    <div class="section-body mt">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">{{ __('products.edit_product') }}</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="form-wrap">
                                @foreach($data as $datas)
                                <form action="{{route('products.update',$datas->id)}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <!-- name -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('products.product_name') }} :<span class="star">*</span></label>
                                        <input type="text" name="name" class="form-control" value="{{ old('name',$datas->name) }}">
                                    </div>
                                    <!-- Varient -->
                                    <div class="after-add-more">
                                        @foreach($datas->getvariant as $key => $variants)
                                        <input type="hidden" name="variant_id[]" value="{{$variants->id}}">
                                        <div class="row mb-30">
                                            <div class="col-md-2">
                                                <div class="form-group packate_div">
                                                    <label for="exampleInputEmail1">Measurement</label>
                                                    <input type="text" class="form-control" name="packate_measurement[]" value="{{$variants->measurement}}" required="">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group packate_div">
                                                    <label for="unit">Unit:</label>
                                                    <select class="form-control" name="packate_measurement_unit_id[]">
                                                        <option value="1" @if($variants->measurement_unit_id==1) selected @endif>kg</option>
                                                        <option value="2" @if($variants->measurement_unit_id==2) selected @endif>gm</option>
                                                        <option value="3" @if($variants->measurement_unit_id==3) selected @endif>ltr</option>
                                                        <option value="4" @if($variants->measurement_unit_id==4) selected @endif>ml</option>
                                                        <option value="5" @if($variants->measurement_unit_id==5) selected @endif>pack</option>
                                                        <option value="6" @if($variants->measurement_unit_id==6) selected @endif>pc</option>
                                                        <option value="7" @if($variants->measurement_unit_id==7) selected @endif>m</option>
                                                    </select>
                                                </div>
                                            </div>                  	
                                            <div class="col-md-2">
                                                <div class="form-group packate_div">
                                                    <label for="qty">Stock:</label>
                                                    <input type="text" class="form-control" name="packate_stock[]" value="{{$variants->stock}}">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group packate_div">
                                                    <label for="qty">Status:</label>
                                                    <select name="packate_serve_for[]" class="form-control" required="">
                                                        <option value="Available" @if($variants->serve_for=="Available") selected @endif>Available</option>
                                                        <option value="Sold Out" @if($variants->serve_for=="Sold Out") selected @endif>Sold Out</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-"></div>
                                            @if($loop->last)
                                            <div class="col-md-1">
                                                <label>Variation</label>
                                                <a id="add_packate_variation" title="Add variation of product" style="cursor: pointer;"><i class="fa fa-plus-square-o fa-2x add-more"></i></a>
                                            </div>
                                            @endif
                                            @php $variant_price = explode(",",$variants->price); @endphp
                                            <div class="col-md-12 row">
                                                @foreach($prices as $pricekey => $price)
                                                @php $price_limit = $pricekey; @endphp
                                                <div class="col-md-2">
                                                    <div class="form-group packate_div">
                                                        <label for="price">Price {{++$price_limit}} (₹):</label>
                                                        <input type="text" class="form-control" name="packate_price[]" id="packate_price" value="{{$variant_price[$pricekey]}}" required="">
                                                    </div>
                                                </div> 
                                                @endforeach
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <!-- select_categories -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('products.select_categories') }} :<span class="star">*</span></label>
                                        <select name="category_id" class="form-control">
                                            @foreach($categories as $category)
                                            <option value="{{$category->id}}" @if($datas->category_id==$category->id) selected @endif>{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- select_sub_categories -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('products.select_sub_categories') }} :<span class="star">*</span></label>
                                        <select name="sub_category_id" class="form-control">
                                            @foreach($sub_categories as $sub_category)
                                            <option value="{{$sub_category->id}}" @if($datas->sub_category_id==$sub_category->id) selected @endif>{{$sub_category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- select_brand -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('products.select_brand') }} :<span class="star">*</span></label>
                                        <select name="brand_id" class="form-control">
                                            @foreach($brands as $brand)
                                            <option value="{{$brand->id}}" @if($datas->brand_id==$brand->id) selected @endif>{{$brand->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- gst_applicable -->
                                    <!-- <div class="form-group mb-30">
                                        <label class="control-label mb-10 text-left">{{ __('products.gst_applicable') }} (%) :</label>
                                        <div class="checkbox checkbox-success">
                                            <input id="sgst" type="checkbox" name="sgst" @if($datas->sgst!=null) checked @endif> 
                                            <label for="sgst">
                                            {{ __('products.sgst') }} -
                                            </label>
                                            <input type="text" name="sgst" class="" value="{{$datas->sgst}}">
                                        </div>
                                        <div class="checkbox checkbox-success">
                                            <input id="cgst" type="checkbox" name="cgst" @if($datas->cgst!=null) checked @endif>
                                            <label for="cgst">
                                            {{ __('products.cgst') }} -
                                            </label>
                                            <input type="text" name="cgst" class="" value="{{$datas->cgst}}">
                                        </div>
                                        <div class="checkbox checkbox-success">
                                            <input id="igst" type="checkbox" name="igst" @if($datas->igst!=null) checked @endif>
                                            <label for="igst">
                                            {{ __('products.igst') }} -
                                            </label>
                                            <input type="text" name="igst" class="" value="{{$datas->igst}}">
                                        </div>	
                                    </div> -->
                                    <div class="form-group mb-30">
                                        <label class="control-label mb-10 text-left">{{ __('products.gst_applicable') }} (%) :</label>
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <label for="sgst">
                                                    {{ __('products.sgst') }} -
                                                </label>
                                                <input type="text" name="sgst" class="" value="{{$datas->sgst}}">
                                            </div>
                                            <div class="col-xs-3">
                                                <label for="cgst">
                                                    {{ __('products.cgst') }} -
                                                </label>
                                                <input type="text" name="cgst" class="" value="{{$datas->cgst}}">
                                            </div>
                                            <div class="col-xs-3">
                                                <label for="igst">
                                                    {{ __('products.igst') }} -
                                                </label>
                                                <input type="text" name="igst" class="" value="{{$datas->igst}}">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- product_image -->
                                    <div class="form-group mb-30">
                                        <label class="control-label mb-10 text-left">{{ __('products.product_image') }} <span class="star">*</span></label>
                                        <input type="file" name="pimage" class="form-control" value="">
                                        <p>Image   *Please choose square image of larger than 350px*350px & smaller than 550px*550px.</p>
                                        <img width="200px" src="{{asset('images/'.$datas->pimage)}}" alt="{{ __('products.product_image') }}">
                                    </div>
                                    <!-- gallery_image -->
                                    <div class="form-group mb-30">
                                        <label class="control-label mb-10 text-left">{{ __('products.gallery_image') }} <span class="star">*</span></label>
                                        <input type="file" name="gimage" class="form-control" value="">
                                        <p>Image   *Please choose square image of larger than 350px*350px & smaller than 550px*550px.</p>
                                        @if(!blank($datas->gimage))
                                        <img width="200px" src="{{asset('images/'.$datas->gimage)}}" alt="{{ __('products.gallery_image') }}">
                                        @endif
                                    </div>
                                    <!-- description -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('products.description') }} :</label>
                                        <textarea name="description" class="form-control" rows="5">{{$datas->description}}</textarea>
                                    </div>
                                    <!-- minimum_stock -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('products.minimum_stock') }} :<span class="star">*</span></label>
                                        <input type="text" name="minimum_stock" class="form-control" value="{{ old('minimum_stock',$datas->min_stock) }}">
                                    </div>
                                    <!-- hsn_code -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('products.hsn_code') }} :<span class="star">*</span></label>
                                        <input type="text" name="hsn_code" class="form-control" value="{{ old('hsn_code',$datas->hsn_code) }}">
                                    </div>
                                    <div class="form-group mb-30 text-center">
                                        <button type="submit" class="btn btn-primary">{{ __('products.update') }}</button>
                                    </div>
                                </form>
                                @endforeach
                                <!-- Copy Fields -->  
                                <div class="copy hide">
                                    <div class="row control-group mb-30">
                                        <div class="col-md-2">
                                            <div class="form-group packate_div">
                                                <label for="exampleInputEmail1">Measurement</label><input type="text" class="form-control" name="packate_measurement[]" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group packate_div">
                                                <label for="unit">Unit:</label>
                                                <select class="form-control" name="packate_measurement_unit_id[]">
                                                        <option value="1">kg</option><option value="2">gm</option><option value="3">ltr</option><option value="4">ml</option><option value="5">pack</option><option value="6">pc</option><option value="7">m</option>                                        </select>
                                            </div>
                                        </div>                  	
                                        <div class="col-md-2">
                                            <div class="form-group packate_div">
                                                <label for="qty">Stock:</label>
                                                <input type="text" class="form-control" name="packate_stock[]">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group packate_div">
                                                <label for="qty">Status:</label>
                                                <select name="packate_serve_for[]" class="form-control" required="">
                                                    <option value="Available">Available</option>
                                                    <option value="Sold Out">Sold Out</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-"></div>
                                        <div class="col-md-1" style="display: grid;">
                                            <label>Remove</label>
                                            <a class="remove_variation text-danger " title="Remove variation of product" style="cursor: pointer;"><i class="fa fa-times fa-2x remove"></i></a>
                                        </div>
                                        <div class="col-md-12 row">
                                            @foreach($prices as $key => $price)
                                            <div class="col-md-2">
                                                <div class="form-group packate_div">
                                                    <label for="price">Price {{++$key}} (₹):</label><input type="text" class="form-control" name="packate_price[]" id="packate_price" required="">
                                                </div>
                                            </div> 
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <!-- End -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">  
  
    $(document).ready(function() {  
  
      $(".add-more").click(function(){   
          var html = $(".copy").html();  
          $(".after-add-more").after(html);  
      });  
  
      $("body").on("click",".remove",function(){   
          $(this).parents(".control-group").remove();  
      });  
  
    });  
  
</script>
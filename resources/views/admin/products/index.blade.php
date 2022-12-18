@extends('admin.layouts.main')

@section('main-content')
@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif


<section class="section">
    <div class="section-header mt">
        <div class="row">
            <div class="col-6 col-md-6 col-lg-6">
                <h3>{{ __('products.products') }}</h3>
            </div>
            <div class="col-6 col-md-6 col-lg-6">
                {{ Breadcrumbs::render('products') }}
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
                            <a class="btn btn-success" href="{{ route('products.create') }}"> {{ __('products.add_product') }}</a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body row pa-0">
                            <div class="table-wrap">
                                <div class="table-responsive">
                                    <table class="table table-bordered data-table table-hover ml-20" style="width:97%;">
                                        <thead>
                                            <tr>
                                                <th>{{ __('products.id') }}</th>
                                                <th>{{ __('products.name') }}</th>
                                                <th>{{ __('products.image') }}</th>
                                                @foreach($prices as $price)
                                                <th>{{$price->title}}</th>
                                                @endforeach
                                                <!-- <th>{{ __('products.price1') }}</th> -->
                                                <!-- <th>{{ __('products.price2') }}</th>
                                                <th>{{ __('products.price3') }}</th>
                                                <th>{{ __('products.price4') }}</th> -->
                                                <th>{{ __('products.measurement') }} (Kg, gm, Ltr)</th>
                                                <th>{{ __('products.stock') }}</th>
                                                <th>{{ __('products.availability') }}</th>
                                                <th>{{ __('products.actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>	
                        </div>	
                    </div>
                </div>
        </div>
    </div>
</section>
<script type="text/javascript">
  $(function () {
    
    var priceList = <?php echo $prices ?>;
    var slab_key =[];
    $.each(priceList,function (index, room) {
        slab_key.push(room.slab_key) 
    });
    console.log(slab_key)
    function getConditionalColumn(){
        var columns= [];
        columns.push({data: 'id', name: 'id'}) 
        columns.push({data: 'name', name: 'name'}) 
        columns.push({data: 'image', name: 'image'})
        $.each(priceList,function (index, room) {
            // if(jQuery.inArray(index, slab_key) !== -1){
                columns.push({data: 'price'+index, name: room.title})
            // }
        });
        columns.push({data: 'measurement', name: 'measurement'}) 
        columns.push({data: 'getvariant[0].stock', name: 'stock'}) 
        columns.push({data: 'getvariant[0].stock', name: 'availability'})
        columns.push({data: 'action', name: 'action', orderable: false, searchable: false}) 

        
        return columns;
    }
   
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('products.index') }}",
        // columns: [
        //     {data: 'id', name: 'id'},
        //     {data: 'name', name: 'name'},
        //     {data: 'image', name: 'image'},
        //     {data: 'price1', name: 'price1'},
        //     {data: 'price2', name: 'price2'},
        //     {data: 'price3', name: 'price3'},
        //     {data: 'price4', name: 'price4'},
        //     {data: 'measurement', name: 'measurement'},
        //     {data: 'getvariant[0].stock', name: 'stock'},
        //     {data: 'getvariant[0].stock', name: 'availability'},
        //     {data: 'action', name: 'action', orderable: false, searchable: false},
        // ]
        columns:getConditionalColumn(false)
    });
      
  });
</script>

@endsection
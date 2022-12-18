@extends('admin.layouts.main')

@section('main-content')
@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link href="{{asset('css/components.min.css')}}" rel="stylesheet" type="text/css">	
<script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap.bundle.min.js')}}"></script>	
<script type="text/javascript" src="{{asset('js/echarts.min.js')}}"></script>
<section class="section">
    <div class="section-header mt">
        <div class="row">
            <div class="col-6 col-md-6 col-lg-6">
                <h3>{{ __('product_sales_chart.product_sales_chart') }}</h3>
            </div>
            <div class="col-6 col-md-6 col-lg-6">
                {{ Breadcrumbs::render('product_sales_chart') }}
            </div>
        </div>
    </div>
    <div class="section-body">
        <div class="col-lg-12">
            <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">{{ __('product_sales_chart.product_sales_chart') }}</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt">
                            <form action="{{route('get_chart')}}" method="POST">
                                @csrf
                                <div class="col-xs-9 text-right">
                                    <select name="product_id" id="product_id" class="form-control">
                                        <option value="">Select Product</option>
                                        @foreach($data as $datas)
                                            <option value="{{$datas->id}}" {{$id ==$datas->id ? 'selected': ''}}>{{$datas->getproduct->name.' '.$datas->measurement.$datas->getmeasurementunit->measurement_unit}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xs-3 text-left">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt">
                            <div class="chart-container">
                                @if(isset($mon1))
                                    <input id="check" type="hidden" value="{{$mon1}}">
                                    <div class="chart has-fixed-height" id="bars_basic"></div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    var bars_basic_element = document.getElementById('bars_basic');
    var check = $("#check").val();
    console.log(check)
    if (check) {
        var bars_basic = echarts.init(bars_basic_element);
        bars_basic.setOption({
            color: ['#3398DB'],
            tooltip: {
                trigger: 'axis',
                
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis: [
                {
                    type: 'category',
                    data: ['Jan', 'Feb','Mar','Apr','May', 'June','July','Aug','Sep', 'Oct','Nov','Dec'],
                    axisTick: {
                        alignWithLabel: true
                    }
                }
            ],
            yAxis: [
                {
                    type: 'value'
                    
                }
            ],
            series: [
                {
                    name: 'Qty',
                    type: 'bar',
                    barWidth: '30%',
                    data: [
                        {{$mon1}},
                        {{$mon2}},
                        {{$mon3}},
                        {{$mon4}},
                        {{$mon5}},
                        {{$mon6}},
                        {{$mon7}},
                        {{$mon8}},
                        {{$mon9}},
                        {{$mon10}},
                        {{$mon11}},
                        {{$mon12}},
                    ]
                }
            ]
        });
    }
</script>
@endsection
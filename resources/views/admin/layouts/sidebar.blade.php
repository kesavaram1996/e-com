@php
	$prefix = Request::route()->getPrefix();
	$route = Route::current()->getName();
	$split = array_map(
		function($value) {
			return implode('.', $value);
		},
		array_chunk(explode('.', $route), 2)
	);
	$arr = explode(".", $split[0],2);
	$first = $arr[0];
	
@endphp

<!--Super Admin -->
@if(auth()->user()->hasRole('Super Admin'))
<div class="fixed-sidebar-left">
	<ul class="nav navbar-nav side-nav nicescroll-bar">
		<!-- Navigation -->
		<!-- <li class="navigation-header">
			<span>Navigation</span> 
			<i class="zmdi zmdi-more"></i>
		</li> -->
		<!-- Dashboard -->
		<li class="mb-5">
			<a class="{{$first =='dashboard' ? 'active' : '' }}" href="{{ route('dashboard') }}"><div class="pull-left"><i class="menu-icon ti-dashboard mr-20"></i><span class="right-nav-text">Dashboard</span></div><div class="pull-right"></div><div class="clearfix"></div></a>
		</li>
		<!-- Profile -->
		<li class="mb-5">
			<a class="{{$first =='profile' ? 'active' : '' }}" href="{{ route('profile.index') }}"><div class="pull-left"><i class="menu-icon ti-user mr-20"></i><span class="right-nav-text">Profile</span></div><div class="pull-right"></div><div class="clearfix"></div></a>
		</li>
		<!-- Admins -->
		<li class="mb-5">
			<a class="{{$first =='users' ? 'active' : '' }}" href="{{ route('users.index') }}"><div class="pull-left"><i class="menu-icon ti-user mr-20"></i><span class="right-nav-text">Admins</span></div><div class="pull-right"></div><div class="clearfix"></div></a>
		</li>
		<!-- Roles -->
		<li class="mb-5">
			<a class="{{$first =='roles' ? 'active' : '' }}" href="{{ route('roles.index') }}"><div class="pull-left"><i class="menu-icon ti-star mr-20"></i><span class="right-nav-text">Roles</span></div><div class="pull-right"></div><div class="clearfix"></div></a>
		</li>
		<!-- Orders -->
		<li class="mb-5">
			<a class="{{$first =='admin_orders' ? 'active' : '' }}" href="{{ route('admin_orders.index') }}"><div class="pull-left"><i class="menu-icon ti-shopping-cart mr-20"></i><span class="right-nav-text">Orders</span></div><div class="pull-right"></div><div class="clearfix"></div></a>
		</li>
	</ul>
</div>
@endif

<!-- Admin -->
@if(auth()->user()->hasRole('Admin'))
<div class="fixed-sidebar-left">
	<ul class="nav navbar-nav side-nav nicescroll-bar">
		<!-- Navigation -->
		<!-- <li class="navigation-header">
			<span>Navigation</span> 
			<i class="zmdi zmdi-more"></i>
		</li> -->
		<!-- Dashboard -->
		<li class="mb-5">
			<a class="{{$first =='dashboard' ? 'active' : '' }}" href="{{ route('dashboard') }}"><div class="pull-left"><i class="menu-icon ti-dashboard mr-20"></i><span class="right-nav-text">Dashboard</span></div><div class="pull-right"></div><div class="clearfix"></div></a>
		</li>
		<!-- Profile -->
		<li class="mb-5">
			<a class="{{$first =='profile' ? 'active' : '' }}" href="{{ route('profile.index') }}"><div class="pull-left"><i class="menu-icon ti-user mr-20"></i><span class="right-nav-text">Profile</span></div><div class="pull-right"></div><div class="clearfix"></div></a>
		</li>
		<!-- Orders -->
		<li class="mb-5">
			<a class="{{$first =='orders' ? 'active' : '' }}" href="{{ route('orders.index') }}"><div class="pull-left"><i class="menu-icon ti-shopping-cart mr-20"></i><span class="right-nav-text">Orders</span></div><div class="pull-right"></div><div class="clearfix"></div></a>
		</li>
		<!-- Categories -->
		<li class="mb-5">
			<a class="{{$first =='categories' ? 'active' : '' }}" href="{{ route('categories.index') }}"><div class="pull-left"><i class="menu-icon ti-direction mr-20"></i><span class="right-nav-text">Categories</span></div><div class="pull-right"></div><div class="clearfix"></div></a>
		</li>
		<!-- Sub Categories -->
		<li class="mb-5">
			<a class="{{$first =='sub_categories' ? 'active' : '' }}" href="{{ route('sub_categories.index') }}"><div class="pull-left"><i class="menu-icon ti-direction-alt mr-20"></i><span class="right-nav-text">Sub Categories</span></div><div class="pull-right"></div><div class="clearfix"></div></a>
		</li>
		<!-- Price Slabs -->
		<!-- <li>
			<a class="{{$first =='price_slabs' ? 'active' : '' }}" href="{{ route('price_slabs.index') }}"><div class="pull-left"><i class="menu-icon ti-star mr-20"></i><span class="right-nav-text">Price Slabs</span></div><div class="pull-right"></div><div class="clearfix"></div></a>
		</li> -->
		<!-- Products -->
		<li class="mb-5">
			<a class="{{$first =='products' ? 'active' : '' }} {{$first =='brands' ? 'active' : '' }}" href="javascript:void(0);" data-toggle="collapse" data-target="#product_dr"><div class="pull-left"><i class="menu-icon ti-package mr-20"></i><span class="right-nav-text">Products</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
			<ul id="product_dr" class="collapse collapse-level-1">
				<li>
					<a class="" href="{{ route('products.create') }}">Add Product</a>
				</li>
				<li>
					<a class="" href="{{ route('products.index') }}">Manage Products</a>
				</li>
				<li>
					<a class="" href="{{ route('products.edit_products') }}">Bulk Edit Products</a>
				</li>
				<li>
					<a class="" href="">Products Order</a>
				</li>
				<li>
					<a class="" href="{{ route('products.min_stock_products') }}">Min. Stock Products</a>
				</li>
				<li>
					<a class="" href="{{ route('brands.index') }}">Brands</a>
					<!-- <a class="" href="{{ route('brands.index') }}"><div class="pull-left"><i class="menu-icon ti-apple mr-20"></i><span class="right-nav-text">Brands</span></div><div class="pull-right"></div><div class="clearfix"></div></a> -->
				</li>
				
			</ul>
		</li>
		<!-- User Interface -->
		<!-- <li class="navigation-header">
			<span>User Interface</span> 
			<i class="zmdi zmdi-more"></i>
		</li> -->
		<!-- Buyer -->
		<li class="mb-5">
			<a class="{{$first =='buyers' ? 'active' : '' }} {{$first =='price_slabs' ? 'active' : '' }}" href="javascript:void(0);" data-toggle="collapse" data-target="#buyer"><div class="pull-left"><i class="menu-icon ti-flag mr-20"></i><span class="right-nav-text">Buyers</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
			<ul id="buyer" class="collapse collapse-level-1">
				<li>
					<a class="" href="{{ route('buyers.create') }}">Add Buyer</a>
				</li>
				<li>
					<a class="" href="{{ route('buyers.index') }}">Buyers</a>
				</li>
				<li>
					<a class="" href="">Manage Buyers Credit</a>
				</li>
				<li>
					<a class="" href="{{ route('price_slabs.index') }}">Price Slabs</a>
				</li>
			</ul>
		</li>
		<!-- Sales Persons -->
		<li class="mb-5">
			<a class="{{$first =='sales_persons' ? 'active' : '' }}{{$first =='daily_logs' ? 'active' : '' }}" href="javascript:void(0);" data-toggle="collapse" data-target="#salesPerson"><div class="pull-left"><i class="menu-icon ti-flag mr-20"></i><span class="right-nav-text">Sales Persons</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
			<ul id="salesPerson" class="collapse collapse-level-1">
				<li>
					<a class="" href="{{ route('sales_persons.create') }}">Add Sales Person</a>
				</li>
				<li>
					<a class="" href="{{ route('sales_persons.index') }}">Sales Persons</a>
				</li>
				<li>
					<a class="" href="{{ route('daily_logs.index') }}">Daily Logs</a>
				</li>
			</ul>
		</li>
		<!-- System -->
		<li class="mb-5">
			@php $system = array('promo_codes', 'admin_settings','contact','privacy_policy','about'); @endphp
			<a class="{{ in_array($first, $system) ? 'active' : '' }}" href="javascript:void(0);" data-toggle="collapse" data-target="#system"><div class="pull-left"><i class="menu-icon ti-layout mr-20"></i><span class="right-nav-text">System</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
			<ul id="system" class="collapse collapse-level-1">
				<li>
					<a class="" href="{{ route('admin_settings.index') }}">Admin Settings</a>
				</li>
				<li>
					<a class="" href="">Send Notification</a>
				</li>
				<li>
					<a class="" href="{{ route('promo_codes.index') }}">Promo Code</a>
				</li>
				<li>
					<a class="" href="{{ route('contact.index') }}">Contact us</a>
				</li>
				<li>
					<a class="" href="{{ route('privacy_policy.index') }}">Privacy Policy</a>
				</li>
				<li>
					<a class="" href="{{ route('about.index') }}">About Us</a>
				</li>
			</ul>
		</li>
		<!-- Send Notification -->
		<!-- <li>
			<a class="" href="javascript:void(0);"><div class="pull-left"><i class="menu-icon ti-gift mr-20"></i><span class="right-nav-text">Send Notification</span></div><div class="pull-right"></div><div class="clearfix"></div></a>
		</li> -->
		<!-- Location -->
		<li class="mb-5">
			<a class="{{$first =='states' ? 'active' : '' }}{{$first =='cities' ? 'active' : '' }}{{$first =='areas' ? 'active' : '' }}" href="javascript:void(0);" data-toggle="collapse" data-target="#location"><div class="pull-left"><i class="menu-icon ti-layout-accordion-merged mr-20"></i><span class="right-nav-text">Location</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
			<ul id="location" class="collapse collapse-level-1">
				<li>
					<a class="" href="{{ route('states.index') }}">States</a>
				</li>
				<li>
					<a class="" href="{{ route('cities.index') }}">Cities</a>
				</li>
				<li>
					<!-- <a class="" href="{{ route('areas.index') }}">Areas</a> -->
				</li>
			</ul>
		</li>
		<!-- Promo Code -->
		<!-- <li>
			<a class="{{$first =='promo_codes' ? 'active' : '' }}" href="{{ route('promo_codes.index') }}"><div class="pull-left"><i class="menu-icon ti-gift mr-20"></i><span class="right-nav-text">Promo Code</span></div><div class="pull-right"></div><div class="clearfix"></div></a>
		</li> -->
		<!-- Additions -->
		<!-- <li class="navigation-header">
			<span>Additions</span> 
			<i class="zmdi zmdi-more"></i>
		</li> -->
		<!-- Reports -->
		<li class="mb-5">
			@php $menus = array('sales_report', 'buyers_report', 'sales_persons_report', 'top_buyers','product_wise_report','top_selling_products','product_sales_chart','get_chart'); @endphp
			<a class="{{ in_array($first, $menus) ? 'active' : '' }}" href="javascript:void(0);" data-toggle="collapse" data-target="#report"><div class="pull-left"><i class="menu-icon ti-layout-accordion-merged mr-20"></i><span class="right-nav-text">Reports</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
			<ul id="report" class="collapse collapse-level-1">
				<li>
					<a class="" href="{{ route('sales_report') }}">Sales Report</a>
				</li>
				<li>
					<a class="" href="{{ route('buyers_report') }}">Buyers Report</a>
				</li>
				<li>
					<a class="" href="{{ route('sales_persons_report') }}">Sales Persons Report</a>
				</li>
				<li>
					<a class="" href="{{ route('top_buyers') }}">Top Buyers</a>
				</li>
				<li>
					<a class="" href="{{ route('product_wise_report') }}">Product Wise Report</a>
				</li>
				<li>
					<a class="" href="{{ route('top_selling_products') }}">Top Selling Products</a>
				</li>
				<li>
					<a class="" href="{{ route('product_sales_chart') }}">Product Sales Chart</a>
				</li>
			</ul>
		</li>
		<!-- Payment Reports -->
		<li class="mb-5">
			<a class="" href="javascript:void(0);" data-toggle="collapse" data-target="#payment_report"><div class="pull-left"><i class="menu-icon ti-layout-accordion-merged mr-20"></i><span class="right-nav-text">Payment Reports</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
			<ul id="payment_report" class="collapse collapse-level-1">
				<li>
					<a class="" href="">Unpaid Invoices - All COD</a>
				</li>
				<li>
					<a class="" href="">Unpaid Invoice Receipts</a>
				</li>
				<li>
					<a class="" href="">Pending Credit Payments</a>
				</li>
				<li>
					<a class="" href="">Credit Payment Receipts</a>
				</li>
			</ul>
		</li>
		<!-- FAQs -->
		<?php
			$user_id = auth()->user()->id;
			$faqs_count = App\Models\FAQs::where('admin_id',$user_id)->count();
		?>
		<li>
			<a class="{{$first =='faqs' ? 'active' : '' }}" href="{{ route('faqs.index') }}"><div class="pull-left"><i class="menu-icon ti-info mr-20"></i><span class="right-nav-text">FAQs</span></div><div class="pull-right"><span class="label label-warning">{{$faqs_count}}</span></div><div class="clearfix"></div></a>
		</li>
	</ul>
</div>
@endif
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('admin.layouts.header')

<body>
    <div class="preloader-it">
		<div class="la-anim-1"></div>
	</div>
    <!-- <div class="wrapper box-layout theme-1-active pimary-color-blue"> -->
    <div class="wrapper theme-1-active pimary-color-blue">
        @include('admin.layouts.nav')
        @include('admin.layouts.sidebar')
        <!-- Main Content -->
        <div class="page-wrapper">
            @yield('main-content')
        </div>
        @include('admin.layouts.footer')
    </div>
    @include('admin.layouts.script')
</body>
</html>

    
<?php

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

// Home
Breadcrumbs::for ('dashboard', function ($trail) {
    $trail->push(trans('dashboard.dashboard'), route('dashboard'));
});

//Dashboard / Roles
Breadcrumbs::for ('roles', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('roles.roles'), route('roles.index'));
});

// Dashboard / Roles / Show
Breadcrumbs::for ('roles/show', function ($trail) {
    $trail->parent('roles');
    $trail->push(trans('roles.show'));
});

// Dashboard / Roles / Add
Breadcrumbs::for ('roles/add', function ($trail) {
    $trail->parent('roles');
    $trail->push(trans('roles.add'));
});

// Dashboard / Roles / Edit
Breadcrumbs::for ('roles/edit', function ($trail) {
    $trail->parent('roles');
    $trail->push(trans('roles.edit'));
});

//Dashboard / admins
Breadcrumbs::for ('admins', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('users.admins'), route('users.index'));
});

// Dashboard / admins / Show
Breadcrumbs::for ('admins/show', function ($trail) {
    $trail->parent('admins');
    $trail->push(trans('users.show'));
});

// Dashboard / admins / Add
Breadcrumbs::for ('admins/add', function ($trail) {
    $trail->parent('admins');
    $trail->push(trans('users.add'));
});

// Dashboard / admins / Edit
Breadcrumbs::for ('admins/edit', function ($trail) {
    $trail->parent('admins');
    $trail->push(trans('users.edit'));
});


//Dashboard / Categories
Breadcrumbs::for ('categories', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('categories.categories'), route('categories.index'));
});

// Dashboard / categories / Show
Breadcrumbs::for ('categories/show', function ($trail) {
    $trail->parent('categories');
    $trail->push(trans('categories.show'));
});

// Dashboard / categories / Add
Breadcrumbs::for ('categories/add', function ($trail) {
    $trail->parent('categories');
    $trail->push(trans('categories.add'));
});

// Dashboard / categories / Edit
Breadcrumbs::for ('categories/edit', function ($trail) {
    $trail->parent('categories');
    $trail->push(trans('categories.edit'));
});

//Dashboard / SUb Categories
Breadcrumbs::for ('sub_categories', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('sub_categories.sub_categories'), route('sub_categories.index'));
});

// Dashboard / sub_categories / Show
Breadcrumbs::for ('sub_categories/show', function ($trail) {
    $trail->parent('sub_categories');
    $trail->push(trans('sub_categories.show'));
});

// Dashboard / sub_categories / Add
Breadcrumbs::for ('sub_categories/add', function ($trail) {
    $trail->parent('sub_categories');
    $trail->push(trans('sub_categories.add'));
});

// Dashboard / sub_categories / Edit
Breadcrumbs::for ('sub_categories/edit', function ($trail) {
    $trail->parent('sub_categories');
    $trail->push(trans('sub_categories.edit'));
});


//Dashboard / brands
Breadcrumbs::for ('brands', function ($trail) {
    $trail->parent('products');
    $trail->push(trans('brands.brands'), route('brands.index'));
});

// Dashboard / brands / Show
Breadcrumbs::for ('brands/show', function ($trail) {
    $trail->parent('brands');
    $trail->push(trans('brands.show'));
});

// Dashboard / brands / Add
Breadcrumbs::for ('brands/add', function ($trail) {
    $trail->parent('brands');
    $trail->push(trans('brands.add'));
});

// Dashboard / brands / Edit
Breadcrumbs::for ('brands/edit', function ($trail) {
    $trail->parent('brands');
    $trail->push(trans('brands.edit'));
});


//Dashboard / price_slabs
Breadcrumbs::for ('price_slabs', function ($trail) {
    $trail->parent('buyers');
    $trail->push(trans('price_slabs.price_slabs'), route('price_slabs.index'));
});

// Dashboard / price_slabs / Show
Breadcrumbs::for ('price_slabs/show', function ($trail) {
    $trail->parent('price_slabs');
    $trail->push(trans('price_slabs.show'));
});

// Dashboard / price_slabs / Add
Breadcrumbs::for ('price_slabs/add', function ($trail) {
    $trail->parent('price_slabs');
    $trail->push(trans('price_slabs.add'));
});

// Dashboard / price_slabs / Edit
Breadcrumbs::for ('price_slabs/edit', function ($trail) {
    $trail->parent('price_slabs');
    $trail->push(trans('price_slabs.edit'));
});

//Dashboard / products
Breadcrumbs::for ('products', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('products.products'), route('products.index'));
});

// Dashboard / products / Add
Breadcrumbs::for ('products/add', function ($trail) {
    $trail->parent('products');
    $trail->push(trans('products.add'));
});

// Dashboard / products / Edit Product
Breadcrumbs::for ('products/edit', function ($trail) {
    $trail->parent('products');
    $trail->push(trans('products.edit'));
});

// Dashboard / products / Edit Products
Breadcrumbs::for ('products/edit_products', function ($trail) {
    $trail->parent('products');
    $trail->push(trans('products.edit_products'));
});

// Dashboard / products / Min Stock Products
Breadcrumbs::for ('products/min_stock_products', function ($trail) {
    $trail->parent('products');
    $trail->push(trans('products.min_stock_products'));
});


//Dashboard / states
Breadcrumbs::for ('states', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('states.states'), route('states.index'));
});

// Dashboard / states / Show
Breadcrumbs::for ('states/show', function ($trail) {
    $trail->parent('states');
    $trail->push(trans('states.show'));
});

// Dashboard / states / Add
Breadcrumbs::for ('states/add', function ($trail) {
    $trail->parent('states');
    $trail->push(trans('states.add'));
});

// Dashboard / states / Edit
Breadcrumbs::for ('states/edit', function ($trail) {
    $trail->parent('states');
    $trail->push(trans('states.edit'));
});

//Dashboard / cities
Breadcrumbs::for ('cities', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('cities.cities'), route('cities.index'));
});

// Dashboard / cities / Show
Breadcrumbs::for ('cities/show', function ($trail) {
    $trail->parent('cities');
    $trail->push(trans('cities.show'));
});

// Dashboard / cities / Add
Breadcrumbs::for ('cities/add', function ($trail) {
    $trail->parent('cities');
    $trail->push(trans('cities.add'));
});

// Dashboard / cities / Edit
Breadcrumbs::for ('cities/edit', function ($trail) {
    $trail->parent('cities');
    $trail->push(trans('cities.edit'));
});

//Dashboard / areas
Breadcrumbs::for ('areas', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('areas.areas'), route('areas.index'));
});

// Dashboard / areas / Show
Breadcrumbs::for ('areas/show', function ($trail) {
    $trail->parent('areas');
    $trail->push(trans('areas.show'));
});

// Dashboard / areas / Add
Breadcrumbs::for ('areas/add', function ($trail) {
    $trail->parent('areas');
    $trail->push(trans('areas.add'));
});

// Dashboard / areas / Edit
Breadcrumbs::for ('areas/edit', function ($trail) {
    $trail->parent('areas');
    $trail->push(trans('areas.edit'));
});

//Dashboard / buyers
Breadcrumbs::for ('buyers', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('buyers.buyers'), route('buyers.index'));
});

// Dashboard / buyers / Show
Breadcrumbs::for ('buyers/show', function ($trail) {
    $trail->parent('buyers');
    $trail->push(trans('buyers.show'));
});

// Dashboard / buyers / Add
Breadcrumbs::for ('buyers/add', function ($trail) {
    $trail->parent('buyers');
    $trail->push(trans('buyers.add'));
});

// Dashboard / buyers / Edit
Breadcrumbs::for ('buyers/edit', function ($trail) {
    $trail->parent('buyers');
    $trail->push(trans('buyers.edit'));
});


//Dashboard / sales_persons
Breadcrumbs::for ('sales_persons', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('sales_persons.sales_persons'), route('sales_persons.index'));
});

// Dashboard / sales_persons / Show
Breadcrumbs::for ('sales_persons/show', function ($trail) {
    $trail->parent('sales_persons');
    $trail->push(trans('sales_persons.show'));
});

// Dashboard / sales_persons / Add
Breadcrumbs::for ('sales_persons/add', function ($trail) {
    $trail->parent('sales_persons');
    $trail->push(trans('sales_persons.add'));
});

// Dashboard / sales_persons / Edit
Breadcrumbs::for ('sales_persons/edit', function ($trail) {
    $trail->parent('sales_persons');
    $trail->push(trans('sales_persons.edit'));
});

// Dashboard / sales_persons / daily_logs
Breadcrumbs::for ('sales_persons/daily_logs', function ($trail) {
    $trail->parent('sales_persons');
    $trail->push(trans('sales_persons.daily_logs'));
});

// Dashboard / sales_persons / daily_logs / visit_logs
Breadcrumbs::for ('sales_persons/daily_logs/visit_logs', function ($trail) {
    $trail->parent('sales_persons/daily_logs');
    $trail->push(trans('sales_persons.visit_logs'));
});

//Dashboard / promo_codes
Breadcrumbs::for ('promo_codes', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('promo_codes.promo_codes'), route('promo_codes.index'));
});

// Dashboard / promo_codes / Show
Breadcrumbs::for ('promo_codes/show', function ($trail) {
    $trail->parent('promo_codes');
    $trail->push(trans('promo_codes.show'));
});

// Dashboard / promo_codes / Add
Breadcrumbs::for ('promo_codes/add', function ($trail) {
    $trail->parent('promo_codes');
    $trail->push(trans('promo_codes.add'));
});

// Dashboard / promo_codes / Edit
Breadcrumbs::for ('promo_codes/edit', function ($trail) {
    $trail->parent('promo_codes');
    $trail->push(trans('promo_codes.edit'));
});

//Dashboard / orders
Breadcrumbs::for ('orders', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('orders.orders'), route('orders.index'));
});

// Dashboard / orders / Show
Breadcrumbs::for ('orders/show', function ($trail) {
    $trail->parent('orders');
    $trail->push(trans('orders.show'));
});

// Dashboard / orders / Add
Breadcrumbs::for ('orders/add', function ($trail) {
    $trail->parent('orders');
    $trail->push(trans('orders.add'));
});

// Dashboard / orders / Edit
Breadcrumbs::for ('orders/edit', function ($trail) {
    $trail->parent('orders');
    $trail->push(trans('orders.edit'));
});

// Dashboard / orders / Show / invoice
Breadcrumbs::for ('orders/show/invoice', function ($trail) {
    $trail->parent('orders');
    $trail->push(trans('orders.invoice'));
});

//Dashboard / sales_report
Breadcrumbs::for ('sales_report', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('sales_report.sales_report'), route('sales_report'));
});

//Dashboard / buyers_report
Breadcrumbs::for ('buyers_report', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('buyers_report.buyers_report'), route('buyers_report'));
});

//Dashboard / sales_persons_report
Breadcrumbs::for ('sales_persons_report', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('sales_persons_report.sales_persons_report'), route('sales_persons_report'));
});

//Dashboard / top_buyers
Breadcrumbs::for ('top_buyers', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('top_buyers.top_buyers'), route('top_buyers'));
});

//Dashboard / product_wise_report
Breadcrumbs::for ('product_wise_report', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('product_wise_report.product_wise_report'), route('product_wise_report'));
});

//Dashboard / top_selling_products
Breadcrumbs::for ('top_selling_products', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('top_selling_products.top_selling_products'), route('top_selling_products'));
});

//Dashboard / product_sales_chart
Breadcrumbs::for ('product_sales_chart', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('product_sales_chart.product_sales_chart'), route('product_sales_chart'));
});

//Dashboard / admin_settings
Breadcrumbs::for ('admin_settings', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('admin_settings.admin_settings'), route('admin_settings.index'));
});

//Dashboard / contact_us
Breadcrumbs::for ('contact_us', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('contact_us.contact_us'), route('contact.index'));
});

//Dashboard / about_us
Breadcrumbs::for ('about_us', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('about_us.about_us'), route('about.index'));
});

//Dashboard / privacy_policy
Breadcrumbs::for ('privacy_policy', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('privacy_policy.privacy_policy'), route('privacy_policy.index'));
});

//Dashboard / faqs
Breadcrumbs::for ('faqs', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('faqs.faqs'), route('faqs.index'));
});

//Dashboard / admin_orders
Breadcrumbs::for ('admin_orders', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('orders.admin_orders'), route('admin_orders.index'));
});

// Dashboard / admin_orders / Show admin_orders
Breadcrumbs::for ('admin_orders/show', function ($trail) {
    $trail->parent('admin_orders');
    $trail->push(trans('orders.show'));
});
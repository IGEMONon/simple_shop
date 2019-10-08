<?php
return array(

    'product/([0-9]+)' => 'product/view/$1', //actionView in ProductController with $id

    'catalog' => 'catalog/index', //actionIndex in CatalogController

    'category/([0-9]+)/page-([0-9]+)' => 'catalog/category/$1/$2', //actionCategory in CatalogController
    'category/([0-9]+)' => 'catalog/category/$1', //actionCategory in CatalogController

    'cart/add/([0-9]+)' => 'cart/add/$1', //actionAdd in CartController

    'checkout' => 'cart/checkout', //actionCheckout in CartController
    'cart/delete/([0-9]+)' => 'cart/delete/$1', //actionDelete in CartController
    'cart/addAjax/([0-9]+)' => 'cart/addAjax/$1', //actionAddAjax in CartController
    'cart' => 'cart/index', //actionIndex in CartController

    'user/register' => 'user/register', //actionRegister in UserController
    'user/login' => 'user/login', //actionLogin in UserController
    'user/logout' => 'user/logout', //actionLogout in UserController

    'cabinet/edit' => 'cabinet/edit', //actionEdit in UserController
    'cabinet' => 'cabinet/index', //actionIndex in CabinetController
    //Управление товарами
    'admin/product/create' => 'adminProduct/create', //actionCreate in AdminProductController
    'admin/product/update/([0-9]+)' => 'adminProduct/update/$1', //actionUpdate in AdminProductController
    'admin/product/delete/([0-9]+)' => 'adminProduct/delete/$1', //actionDelete in AdminProductController
    'admin/product' => 'adminProduct/index', //actionIndex in AdminProductController
    //Управление категориями
    'admin/category/create' => 'adminCategory/create', //actionCreate in AdminCategoryController
    'admin/category/update/([0-9]+)' => 'adminCategory/update/$1', //actionUpdate in AdminCategoryController
    'admin/category/delete/([0-9]+)' => 'adminCategory/delete/$1', //actionDelete in AdminCategoryController
    'admin/category' => 'adminCategory/index', //actionIndex in AdminCategoryController
    //Управление заказами
    'admin/order/view/([0-9]+)' => 'adminOrder/view/$1', //actionCreate in AdminOrderController
    'admin/order/update/([0-9]+)' => 'adminOrder/update/$1', //actionUpdate in AdminOrderController
    'admin/order/delete/([0-9]+)' => 'adminOrder/delete/$1', //actionDelete in AdminOrderController
    'admin/order' => 'adminOrder/index', //actionIndex in AdminOrderController
    //Админпанель
    'admin' => 'admin/index', //actionIndex in AdminController

    'contacts' => 'site/contact', //actionContact in SiteController

    '' => 'site/index', //actionIndex in SiteController
);
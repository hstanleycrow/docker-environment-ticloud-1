<?php

use App\Core\Route;

Route::get('/', 'HomeController#index', 'home')->middleware('auth');

#Login
Route::get('/login', 'AuthControllers/AuthIndexController#showForm', 'loginForm');
Route::post('/login', 'AuthControllers/AuthLoginController#login', 'login');
Route::get('/close', 'AuthControllers/AuthCloseSessionController#closeSession', 'close');

#NoAdmin message
Route::get('/access_denied', 'AuthControllers/AuthAccessDeniedController#showMessage', 'accessDenied');

Route::get('/easyphpdatatables/server_processing.php', 'DatatableController#index', 'serverProcessing');


# Users
Route::get('/users', 'UsersControllers/UsersIndexController#index', 'usersList')->middleware('auth', 'admin');
Route::get('/user/agregar', 'UsersControllers/UsersCreateController#showForm', 'showUserAddForm')->middleware('auth');
Route::post('/user/agregar', 'UsersControllers/UsersCreateController#create', 'createUser')->middleware('auth');
Route::get('/user/editar/[i:id]/', 'UsersControllers/UsersUpdateController#showForm', 'showUserEditForm')->middleware('auth');
Route::post('/user/editar/[i:id]/', 'UsersControllers/UsersUpdateController#save', 'saveUser')->middleware('auth');
Route::get('/user/borrar/[i:id]/', 'UsersControllers/UsersDeleteController#delete', 'deleteUser');
/* 
// # Branches
Route::get('/branches', 'BranchesControllers/BranchesIndexController#index', 'branchesList')->middleware('auth', 'admin');
Route::get('/branch/agregar', 'BranchesControllers/BranchesCreateController#showForm', 'showBranchAddForm')->middleware('auth');
Route::post('/branch/agregar', 'BranchesControllers/BranchesCreateController#create', 'createBranch')->middleware('auth');
Route::get('/branch/editar/[i:id]/', 'BranchesControllers/BranchesUpdateController#showForm', 'showBranchEditForm')->middleware('auth');
Route::post('/branch/editar/[i:id]/', 'BranchesControllers/BranchesUpdateController#save', 'saveBranch')->middleware('auth');
Route::get('/branch/borrar/[i:id]/', 'BranchesControllers/BranchesDeleteController#delete', 'deleteBranch');

# Products Categories
Route::get('/categories', 'CategoriesControllers/CategoriesIndexController#index', 'categoriesList')->middleware('auth');
Route::get('/category/agregar', 'CategoriesControllers/CategoriesCreateController#showForm', 'showCategoryAddForm')->middleware('auth');
Route::post('/category/agregar', 'CategoriesControllers/CategoriesCreateController#create', 'createCategory')->middleware('auth');
Route::get('/category/editar/[i:id]/', 'CategoriesControllers/CategoriesUpdateController#showForm', 'showCategoryEditForm')->middleware('auth');
Route::post('/category/editar/[i:id]/', 'CategoriesControllers/CategoriesUpdateController#save', 'saveCategory')->middleware('auth');
Route::get('/category/borrar/[i:id]/', 'CategoriesControllers/CategoriesDeleteController#delete', 'deleteCategory');

# Products
Route::get('/products', 'ProductsControllers/ProductsIndexController#index', 'productsList')->middleware('auth');
Route::get('/product/agregar', 'ProductsControllers/ProductsCreateController#showForm', 'showProductAddForm')->middleware('auth');
Route::post('/product/agregar', 'ProductsControllers/ProductsCreateController#create', 'createProduct')->middleware('auth');
Route::get('/product/editar/[i:id]/', 'ProductsControllers/ProductsUpdateController#showForm', 'showProductEditForm')->middleware('auth');
Route::post('/product/editar/[i:id]/', 'ProductsControllers/ProductsUpdateController#save', 'saveProduct')->middleware('auth');
Route::get('/product/borrar/[i:id]/', 'ProductsControllers/ProductsDeleteController#delete', 'deleteProduct');

# Sauces
Route::get('/sauces', 'SaucesControllers/SaucesIndexController#index', 'saucesList')->middleware('auth');
Route::get('/sauce/agregar', 'SaucesControllers/SaucesCreateController#showForm', 'showSauceAddForm')->middleware('auth');
Route::post('/sauce/agregar', 'SaucesControllers/SaucesCreateController#create', 'createSauce')->middleware('auth');
Route::get('/sauce/editar/[i:id]/', 'SaucesControllers/SaucesUpdateController#showForm', 'showSauceEditForm')->middleware('auth');
Route::post('/sauce/editar/[i:id]/', 'SaucesControllers/SaucesUpdateController#save', 'saveSauce')->middleware('auth');
Route::get('/sauce/borrar/[i:id]/', 'SaucesControllers/SaucesDeleteController#delete', 'deleteSauce');

# Order Status
Route::get('/order_status', 'OrderStatusControllers/OrderStatusIndexController#index', 'orderStatusList')->middleware('auth');
Route::get('/orderStatus/agregar', 'OrderStatusControllers/OrderStatusCreateController#showForm', 'showOrderStatusAddForm')->middleware('auth');
Route::post('/orderStatus/agregar', 'OrderStatusControllers/OrderStatusCreateController#create', 'createOrderStatus')->middleware('auth');
Route::get('/orderStatus/editar/[i:id]/', 'OrderStatusControllers/OrderStatusUpdateController#showForm', 'showOrderStatusEditForm')->middleware('auth');
Route::post('/orderStatus/editar/[i:id]/', 'OrderStatusControllers/OrderStatusUpdateController#save', 'saveOrderStatus')->middleware('auth');
Route::get('/orderStatus/borrar/[i:id]/', 'OrderStatusControllers/OrderStatusDeleteController#delete', 'deleteOrderStatus');


# Products - Sauces
Route::get('/product/sauces/[i:id]/', 'ProductSaucesControllers/ProductSaucesCreateController#showForm', 'showProductSauceAddForm')->middleware('auth');
Route::post('/product/sauces/[i:id]/', 'ProductSaucesControllers/ProductSaucesCreateController#create', 'createProductSauce')->middleware('auth');
Route::post('/product_sauces_processing', 'ProductSaucesControllers/ProductSaucesAjaxController#processRequest', 'productSaucesServerProcessing');

# Extras
Route::get('/extras', 'ExtrasControllers/ExtrasIndexController#index', 'extrasList')->middleware('auth');
Route::get('/extra/agregar', 'ExtrasControllers/ExtrasCreateController#showForm', 'showExtraAddForm')->middleware('auth');
Route::post('/extra/agregar', 'ExtrasControllers/ExtrasCreateController#create', 'createExtra')->middleware('auth');
Route::get('/extra/editar/[i:id]/', 'ExtrasControllers/ExtrasUpdateController#showForm', 'showExtraEditForm')->middleware('auth');
Route::post('/extra/editar/[i:id]/', 'ExtrasControllers/ExtrasUpdateController#save', 'saveExtra')->middleware('auth');
Route::get('/extra/borrar/[i:id]/', 'ExtrasControllers/ExtrasDeleteController#delete', 'deleteExtra');

# Products - Extras
Route::get('/product/extras/[i:id]/', 'ProductExtrasControllers/ProductExtrasCreateController#showForm', 'showProductExtraAddForm')->middleware('auth');
Route::post('/product/extras/[i:id]/', 'ProductExtrasControllers/ProductExtrasCreateController#create', 'createProductExtra')->middleware('auth');
Route::post('/product_extras_processing', 'ProductExtrasControllers/ProductExtrasAjaxController#processRequest', 'productExtrasServerProcessing');

# Orders
Route::get('/orders', 'OrdersControllers/OrdersIndexController#index', 'OrdersList')->middleware('auth');
Route::get('/customer/orders/[i:id]/', 'OrdersControllers/OrdersIndexController#index', 'OrdersWithCustomer')->middleware('auth');
Route::post('/orders/filterProducts', 'OrdersControllers/FilterProductsByCategoryController#index', 'FilterProducts')->middleware('auth');
Route::post('/orders/getSaucesAndExtras', 'OrdersControllers/FilterProductsByCategoryController#filterSaucesAndExtras', 'FilterSaucesAndExtras')->middleware('auth');
Route::post('/orders/processOrder', 'OrdersControllers/ProcessOrderController#processOrder', 'ProcessOrder')->middleware('auth');

// # Customers
Route::get('/customers', 'CustomersControllers/CustomersIndexController#index', 'customersList')->middleware('auth', 'admin');
Route::get('/customer/agregar', 'CustomersControllers/CustomersCreateController#showForm', 'showCustomerAddForm')->middleware('auth');
Route::post('/customer/agregar', 'CustomersControllers/CustomersCreateController#create', 'createCustomer')->middleware('auth');
Route::get('/customer/editar/[i:id]/', 'CustomersControllers/CustomersUpdateController#showForm', 'showCustomerEditForm')->middleware('auth');
Route::post('/customer/editar/[i:id]/', 'CustomersControllers/CustomersUpdateController#save', 'saveCustomer')->middleware('auth');
Route::get('/customer/borrar/[i:id]/', 'CustomersControllers/CustomersDeleteController#delete', 'deleteCustomer');


/**  
 * Reports
 */
/*
#Sales per branch
Route::get('/sales_per_branch', 'ReportsControllers/SalesPerBranchController#showForm', 'salesPerBranchForm')->middleware('auth', 'admin');

Route::post('/sales_per_branch', 'ReportsControllers/SalesPerBranchController#renderReport', 'salesPerBranchRender')->middleware('auth', 'admin');

#Daily sales per branch
Route::get('/daily_sales_per_branch_detailed', 'ReportsControllers/DailySalesPerBranchController#showForm', 'dailySalesPerBranchDetailedForm')->middleware('auth', 'admin');

Route::post('/daily_sales_per_branch_detailed', 'ReportsControllers/DailySalesPerBranchController#renderReport', 'dailySalesPerBranchDetailedRender')->middleware('auth', 'admin');
 */
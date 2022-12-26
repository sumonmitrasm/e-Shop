<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
Route::get('/', function () {
    return view('welcome');
});
*/
use App\Category;
use App\CmsPage; //.........................................................177

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('/admin')->namespace('Admin')->group(function(){
	Route::match(['get','post'],'/', 'AdminController@login');
	Route::group(['middleware'=>['admin']],function(){
		Route::get('dashboard', 'AdminController@dashboard');
		Route::get('logout', 'AdminController@logout');
		Route::get('settings', 'AdminController@settings');
		Route::post('check-current-pwd', 'AdminController@chkCurrentPassword'); ///admin/check-current-pwd/ have to mention VerifyCsrfTOkrn.php don't forget this.
		Route::post('update-current-pwd', 'AdminController@updateCurrentPassword');
		Route::match(['get','post'],'update-admin-details', 'AdminController@updateAdminDetails');

		//sections...............................................................................................

		Route::get('sections', 'SectionController@sections');
		Route::post('update-section-status', 'SectionController@updateSectionStatus');

		//Category...............................................................................................
		Route::get('categories', 'CategoryController@categories');
		Route::post('update-category-status', 'CategoryController@updateCategoryStatus');
		Route::match(['get','post'],'add-edit-category/{id?}', 'CategoryController@addEditCategory');
		Route::post('append-categories-level', 'CategoryController@appendCategoryLevel');
		Route::get('delete-category-image/{id}', 'CategoryController@deleteCategoryImage');
		Route::get('delete-category/{id}', 'CategoryController@deleteCategory');

		//product................................................................................................
		Route::get('products','ProductsController@products');
		Route::post('update-product-status', 'ProductsController@updateProductStatus');
		Route::get('delete-product/{id}', 'ProductsController@deleteProduct');
		Route::match(['get','post'],'add-edit-product/{id?}', 'ProductsController@addEditProduct');
		Route::get('delete-product-image/{id}', 'ProductsController@deleteProductImage');
		Route::get('delete-product-video/{id}', 'ProductsController@deleteProductVideo');

		//product Attributes....................
		Route::match(['get','post'],'add-attributes/{id}', 'ProductsController@addAttributes');
		Route::post('edit-attributes/{id}', 'ProductsController@editAttributes');
		Route::post('update-attribute-status', 'ProductsController@updateAttributeStatus');
		Route::get('delete-attribute/{id}', 'ProductsController@deleteAttribute');

		//Multipell Imagers uploded............
		Route::match(['get','post'],'add-images/{id}', 'ProductsController@addImages');
		Route::post('update-image-status', 'ProductsController@updateImageStatus');
		Route::get('delete-image/{id}', 'ProductsController@deleteImage');

		//Brands...................................................................................................
		Route::get('brands', 'BrandController@brands');
		Route::post('update-brand-status', 'BrandController@updateBrandStatus');
		Route::match(['get','post'],'add-edit-brand/{id?}', 'BrandController@addEditBrand');
		Route::get('delete-brand/{id}', 'BrandController@deleteBrand');

		//Banners controller.......................................................................................
		Route::get('banners', 'BannersController@banners');
		Route::post('update-banners-status', 'BannersController@updateBannerStatus');
		Route::get('delete-banners/{id}', 'BannersController@deleteBanner');
		Route::match(['get','post'],'add-edit-banner/{id?}', 'BannersController@addEditBanner');

		//coupons code.............................................................................................114
		Route::get('coupons', 'CouponsController@coupons');
		Route::post('update-coupons-status', 'CouponsController@updateCouponsStatus');
		Route::match(['get','post'],'add_edit_coupon/{id?}', 'CouponsController@addEditCoupon');
		Route::get('delete-coupon/{id}', 'CouponsController@deleteCoupon');

		//ORDERS code.............................................................................................135
		Route::get('orders', 'OrdersController@orders');
		Route::get('orders/{id}', 'OrdersController@orderDetails');
		Route::post('update-order-status', 'OrdersController@updateOrderStatus');
		Route::get('view-order-invoice/{id}', 'OrdersController@viewOrderInvoice');

		//shipping-charges.............................................................................................153
		Route::get('view-shipping-charges', 'ShippingController@viewShippingCharges');
		Route::match(['get','post'],'update_shipping_charges/{id}', 'ShippingController@editShippingCharges');
		Route::post('update-shipping-status', 'ShippingController@updateShippingStatus');

		//users show........................................................................170
		Route::get('users', 'UsersController@users');
		Route::post('update-user-status', 'UsersController@updateUserStatus');

		// cmc route.........................................................................175
		Route::get('cms-pages', 'CmsController@cmsPages');
		Route::post('update-smspage-status', 'CmsController@updateCmsPagesStatus');
		Route::match(['get','post'],'add-edit-cms-page/{id?}','CmsController@addEditCmsPage');
		Route::get('delete-cms/{id}', 'CmsController@deleteCmspage');

		// Admin & subadmin...................................................................180..3..181
		Route::get('admins-subadmins', 'AdminController@adminsSubadmins');
		Route::post('update-admin-status', 'AdminController@updateAdminStatus');
		Route::get('delete-admin/{id}', 'AdminController@deleteAdmin');
		Route::match(['get','post'],'add-edit-admin-subadmin/{id?}','AdminController@addEditAdminSubadmin');
		//admin subadmi roles........//.......................................................183 v1.hours
		Route::match(['get','post'],'update-role/{id?}','AdminController@updateRole');
	});
});
Route::namespace('Front')->group(function(){
	Route::get('/','IndexController@index');
	//Route::get('/{url}','ProductsController@listing');
	$catUrls = Category::select('url')->where('status',1)->get()->pluck('url')->toArray();
	//echo "<pre>";print_r($catUrls);die;
	foreach ($catUrls as $url) {
		Route::get('/'.$url,'ProductsController@listing');
		//echo "<pre>";print_r($url);die;
	}
	//cms page................................................................................177
	$cmsUrls = CmsPage::select('url')->where('status',1)->get()->pluck('url')->toArray();
	//echo "<pre>";print_r($cmsUrls);die;
	foreach ($cmsUrls as $url) {
		Route::get('/'.$url,'CmsController@cmsPage');
		//echo "<pre>";print_r($url);die;
	}
	Route::get('/product/{id}','ProductsController@details');
	//get product Attibute price route.............................
	Route::post('/get-product-price','ProductsController@getProductPrice');
	//Add to Cart routr//
	Route::post('/add-to-cart','ProductsController@addtocart');
	//Shopping cart route
	Route::get('/cart','ProductsController@cart');
	//Update cart Item Qentity........................................
	Route::post('/update-cart-item-qty','ProductsController@updateCartItemQty');
	//delete cart items...............................................
	Route::post('/delete-cart-item','ProductsController@deleteCartItem');
	//login-register page..............................................
	//Route::get('/login_register','UsersController@loginRegister');
	Route::get('/login_register',['as'=>'login','uses'=>'UsersController@loginRegister']); //111
	//login user..............................................................
	Route::post('/login','UsersController@loginUser');
	//resister user...........................................................
	Route::post('/register','UsersController@registerUser');
	//ligout..................................................................
	Route::get('/logout','UsersController@logoutUser');
	//check email match in database validation................................99
	Route::match(['get','post'],'/check-email', 'UsersController@checkMail');
	// check confirm account..................................................
	Route::match(['GET','POST'],'/confirm/{code}', 'UsersController@confirmAccount');
	//forgot-password.........................................................
	Route::match(['GET','POST'],'/forgot-password', 'UsersController@forgotPassword');
	
	//create route group for meddile authantication...............................111
	Route::group(['middleware'=>['auth']],function(){
		
		// my account page........................................................
		Route::match(['GET','POST'],'/account', 'UsersController@account');
		//orders...........................................................................132
		Route::get('/orders', 'OrdersController@orders');
		//user orders details...........................................................................133
		Route::get('/orders/{id}', 'OrdersController@orderDetails');
		//Check login user password..............................................110
		Route::post('/check-user-pwd','UsersController@chkUserPassword');
		//update user password...................................................110
		Route::post('/update-user-pwd','UsersController@UpdateUserPassword');
		//Apply coupon...........................................................119
		Route::post('/apply-coupon','ProductsController@applyCoupon');
		//checkout page..........................................................123
		Route::match(['GET','POST'],'/checkout', 'ProductsController@checkout');
		//dalivery address page..........................................................125
		Route::match(['GET','POST'],'/add-edit-delivery-address/{id?}', 'ProductsController@addEditDeliveryAddress');
		//delete delivary address.........................................................126
		Route::get('/delete-delivery-address/{id}', 'ProductsController@deleteDeliveryAddress');
		//thanks...........................................................................131
		Route::get('/thanks', 'ProductsController@thanks');
		//paypel route...........................................................................after 157
		Route::get('/paypal', 'PaypalController@paypal');
	});
	//pincode check details..............................................................167
	Route::post('/check-pincode','ProductsController@checkPincode');
	//Search Product.........................................................................173
	Route::get('/search-products','ProductsController@listing');
	//contact us page........................................................................178
	Route::match(['GET','POST'],'/contact', 'CmsController@contact');

	






	//Route::get('/contact-us',function(){
		//echo "test";die;
	//});
});
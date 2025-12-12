<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\CkEditorController;
use App\Http\Controllers\admin\ProductSubCategoryController;
use App\Http\Controllers\admin\TempImageController;
use App\Http\Controllers\admin\ProductImageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SiteSettingsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\admin\PagesController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ProductDetailsController;
use App\Http\Controllers\admin\VariationController;
use App\Http\Controllers\admin\SizeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\admin\ShippingController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\SaleReports;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersExport;
use App\Http\Controllers\AdminAccessController;

Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/shop/{categorySlug?}/{subCategorySlug?}',[ShopController::class,'index'])->name('shop');
Route::get('/product/{slug}/',[ProductDetailsController::class,'index'])->name('products');
Route::get('/cart',[CartController::class,'cart'])->name('cart');
Route::post('/add-to-cart/{id}',[CartController::class,'addToCart'])->name('addToCart');
Route::post('/update-cart', [CartController::class, 'updateCart'])->name('updateCart');
Route::get('/remove-from-cart/{rowId}', [CartController::class,'removeFromCart'])->name('removeFromCart');
Route::get('/clear-cart', [CartController::class,'clearCart'])->name('clearCart');
Route::get('/get-cart-details', [CartController::class ,'getCartDetails'])->name('getCartDetails');
Route::get('/checkout', [CartController::class ,'checkout'])->name('checkout');
Route::post('/order/submit', [CartController::class,'processCheckout'])->name('order');
Route::post('/calculate/shipping', [CartController::class,'calculateShipping'])->name('calculateShipping');
Route::post('/apply/coupon', [CartController::class,'applyCoupon'])->name('applyCoupon');
Route::post('/remove/coupon', [CartController::class,'removeCoupon'])->name('removeCoupon');
Route::get('/thankYou/{order}', [CartController::class ,'thankYou'])->name('thankYou');
Route::get('/wishlist', [WishlistController::class ,'index'])->name('wishlist');
Route::post('/add-to-wishlist',[WishlistController::class,'addToWishlist'])->name('addToWishlist');
Route::post('/get-Wishlist-Count',[WishlistController::class,'getWishlistCount'])->name('getWishlistCount');
Route::post('/check-Wishlist-Status',[WishlistController::class,'checkWishlistStatus'])->name('checkWishlistStatus');
Route::get('/about-us', [PageController::class ,'about'])->name('about');
Route::get('/contact-us', [PageController::class ,'contact'])->name('contact');
Route::get('/privacy_policy', [PageController::class ,'privacy'])->name('privacy');
Route::get('/terms_and_condition', [PageController::class ,'terms_condition'])->name('terms_condition');
Route::post('/contact-form', [PageController::class ,'contactForm'])->name('contact-form');
Route::post('submitReview',[RatingController::class,'submitReview'])->name('submitReview');
Route::get('/category/{slug}/{categorySlug?}/{subCategorySlug?}', [CategoryProductController::class ,'categoryProduct'])->name('categoryProduct');
Route::get('/sub_category/{slug}/{categorySlug?}/{subCategorySlug?}', [CategoryProductController::class ,'subCategoryProduct'])->name('subCategoryProduct');
Route::get('/load-more-products', [HomeController::class, 'loadMoreProducts'])->name('load-more-products');


Route::group(['prefix' => 'account'],function(){
    Route::group(['middleware' => 'guest'],function(){
        Route::get('/auth', [UserAuthController::class ,'userAuth'])->name('userAuth');
        Route::post('/user/register', [UserAuthController::class ,'userRegister'])->name('userRegister');
        Route::post('/user/login', [UserAuthController::class,'login'])->name('user.login');
        Route::post('/user/checkout/login', [CheckoutController::class,'CheckoutLogin'])->name('user.checkout.login');
        Route::get('/user/forget/password', [UserAuthController::class ,'forgetPassword'])->name('forgetPassword');
        Route::post('/user/forget/password/reset', [UserAuthController::class,'forgetResetLink'])->name('forgetResetLink');
        Route::get('/user/reset/password/{token}', [UserAuthController::class ,'resetPassword'])->name('resetPassword');
        Route::post('/user/reset/password/form', [UserAuthController::class,'ResetPasswordForm'])->name('ResetPasswordForm');

    });

    Route::group(['middleware' => 'auth'],function(){
        Route::get('/user/logout',[UserAuthController::class,'logout'])->name('user.logout');
        Route::get('/user/profile',[UserProfileController::class,'index'])->name('user.profile');
        Route::get('/user/order/detail/{id}',[UserProfileController::class,'orderDetail'])->name('orderDetail');
        Route::post('/user/update/address/{id}',[UserProfileController::class,'updateAddress'])->name('updateBillingAddress');
        Route::post('/user/update/shippingAddress/{id}',[UserProfileController::class,'updateShippingAddress'])->name('updateShippingAddress');
        Route::post('/user/update/Info/{id}',[UserProfileController::class,'updateUserInfo'])->name('updateUserInfo');
        Route::post('/get-order-status', [UserProfileController::class, 'getOrderStatus'])->name('get-order-status');
        Route::get('/profileordercancel/{id}', [UserProfileController::class, 'profileordercancel'])->name('profileordercancel');
        Route::get('/profile/order/return/{id}', [UserProfileController::class, 'profileorderreturn'])->name('profileorderreturn');

    });
});

Route::group(['prefix' => 'admin'],function(){

    Route::group(['middleware' => 'admin.guest'],function(){
        Route::get('/login',[AdminLoginController::class,'index'])->name('admin.login');
        Route::post('/authenticate',[AdminLoginController::class,'authenticate'])->name('admin.authenticate');
    });

    Route::group(['middleware' => 'admin.auth'],function(){
        Route::get('/dashboard',[DashboardController::class,'index'])->name('admin.dashboard');
        Route::get('/logout',[DashboardController::class,'logout'])->name('admin.logout');
        Route::resources(['category' => CategoryController::class]);
        Route::resources(['subcategory' => SubCategoryController::class]);
        Route::resources(['brand' => BrandController::class]);
        Route::resources(['product' => ProductController::class]);
        Route::resources(['variations' => VariationController::class]);
        Route::post('/upload',[CkEditorController::class,'upload'])->name('ck.upload');
        Route::post('/images/upload',[TempImageController::class,'store'])->name('temp-images.create');
        Route::get('/product-subcategories',[ProductSubCategoryController::class,'index'])->name('product-subcategories');
        Route::delete('/product-images/{image}',[ProductImageController::class,'destroy'])->name('product-images.delete');
        Route::post('/product-images',[ProductImageController::class,'store'])->name('product-images.store');
        Route::get('/header/settings',[SiteSettingsController::class,'header'])->name('headerSettings');
        Route::get('/footer/settings',[SiteSettingsController::class,'footer'])->name('footerSettings');
        Route::post('/save/siteSettings',[SiteSettingsController::class,'update'])->name('updateSiteSettings');
        Route::post('/save/headerSettings',[SiteSettingsController::class,'updateHeader'])->name('updateHeaderSettings');
        Route::post('/save/footerSettings',[SiteSettingsController::class,'updateFooter'])->name('updateFooterSettings');
        Route::post('/save/profileSettings',[ProfileController::class,'profileUpdate'])->name('profileUpdate');
        Route::get('/profile/details',[ProfileController::class,'profile'])->name('profile');
        Route::get('/profile/settings',[ProfileController::class,'profileSettings'])->name('profileSettings');
        Route::get('/pages/homeSettings',[PagesController::class,'home'])->name('homeSettings');
        Route::post('/offer/save',[OfferController::class,'offerSave'])->name('offer-save');
        Route::post('/homeSetting/save',[PagesController::class,'homeSettingUpdate'])->name('homeSetting-save');
        Route::get('/offer/show/{id}',[OfferController::class,'offerShow'])->name('offer-show');
        Route::get('/homeSetting/show/{id}',[PagesController::class,'homeSettingShow'])->name('homeSetting-show');
        Route::get('/variation/size',[VariationController::class,'size'])->name('variationSize');
        Route::post('/variation/size/save',[VariationController::class,'save'])->name('variation.save');
        Route::post('/variation/size/update/{id}',[VariationController::class,'updates'])->name('variation.updates');
        Route::post('/variations/update',[ProductController::class,'variationUpdate'])->name('updateVariations');
        Route::post('variation/color/image/delete/{id}',[ProductController::class,'colorImageDelete'])->name('colorImageDelete');
        Route::get('/shipping/methods',[ShippingController::class,'index'])->name('shipping');
        Route::post('/shipping/methods/store',[ShippingController::class,'store'])->name('shippingStore');
        Route::post('/shipping/methods/delete/{id}',[ShippingController::class,'delete'])->name('shippingDelete');
        Route::post('/shipping/methods/update/{id}',[ShippingController::class,'update'])->name('shippingUpdate');
        Route::resources(['coupons' => CouponController::class]);
        Route::get('/orders',[OrderController::class,'index'])->name('ordersPending');
        Route::get('/orders/procesing',[OrderController::class,'ordersProcessing'])->name('ordersProcessing');
        Route::get('/orders/shipped',[OrderController::class,'ordersshiped'])->name('ordersshiped');
        Route::get('/orders/complete',[OrderController::class,'ordersComplete'])->name('ordersComplete');
        Route::get('/orders/cancel',[OrderController::class,'ordersCancel'])->name('ordersCancel');
        Route::get('/orders/return/requested',[OrderController::class,'ordersreturnrequesst'])->name('ordersreturnrequesst');
        Route::get('/orders/retured/refunded',[OrderController::class,'ordersreturenen'])->name('ordersreturenen');
        Route::get('/view/orders/{id}',[OrderController::class,'viewOrders'])->name('viewOrders');
        Route::post('/order/status/update/{id}',[OrderController::class,'orderStatusUpdate'])->name('order-status-update');
        Route::post('/order/payment/status/update/{id}',[OrderController::class,'orderPaymentStatusUpdate'])->name('order-paymentStatus-update');
        Route::resources(['users' => UserController::class]);
        Route::get('/page/about/settings',[PagesController::class,'aboutPage'])->name('aboutPage');
        Route::get('/page/contact/settings',[PagesController::class,'contactPage'])->name('contactPage');
        Route::get('/page/privacy_policy/settings',[PagesController::class,'privacy_policy'])->name('privacy_policy');
        Route::get('/page/terms_and_condition/settings',[PagesController::class,'terms_and_condition'])->name('terms_and_condition');
        Route::post('/update/about/page',[PagesController::class,'updateAboutPage'])->name('update-aboutPage');
        Route::post('/update/contact/page',[PagesController::class,'updateContactPage'])->name('update-contactPage');
        Route::post('/update/privacy/page',[PagesController::class,'updatePrivacyPage'])->name('update-privacyPage');
        Route::post('/update/terms/page',[PagesController::class,'updateTermsPage'])->name('update-termsPage');
        Route::get('notificationRead/{id}',[DashboardController::class,'notificationRead'])->name('notificationRead');
        Route::post('messages/mark-all-as-read',[DashboardController::class,'markAllAsRead'])->name('messages.markAllAsRead');
        Route::get('reviews',[RatingController::class,'reviews'])->name('reviews');
        Route::get('reviewShow/{id}',[RatingController::class,'reviewShow'])->name('reviewShow');
        Route::post('reviewDestroy/{id}',[RatingController::class,'reviewDestroy'])->name('reviewDestroy');
        Route::post('/update/slider/destroy/{id}',[PagesController::class,'sliderdestroy'])->name('sliderdestroy');
        Route::post('/update/slider/update/{id}',[PagesController::class,'sliderupdate'])->name('sliderupdate');
        Route::post('/update/slider/store',[PagesController::class,'sliderstore'])->name('sliderstore');
        Route::resources(['payment_methods' => PaymentMethodController::class]);
        Route::get('sales/report',[SaleReports::class,'salesReport'])->name('sales_report');
        Route::get('/products/view/{id}', [ProductController::class, 'viewProduct'])->name('products.view');
        Route::post('/products/update-quantity', [ProductController::class, 'updateQuantity'])->name('products.updateQuantity');
        Route::get('/products/shipments/{id}',[ProductController::class,'shipments'])->name('product.shipment');
        Route::get('/products/shipments/update/{id}',[ProductController::class,'shipmentsUpdate'])->name('product.shipment.edit');
        Route::get('/products/shipments/delete/{id}',[ProductController::class,'shipmentDelete'])->name('product.shipment.delete');

        Route::get('/control/panel/admins', [AdminAccessController::class, 'admins'])->name('admin.control.panel');
        Route::post('/control/panel/store', [AdminAccessController::class, 'store'])->name('admin.control.store');
        Route::post('/control/panel/{id}/status', [AdminAccessController::class, 'status'])->name('admin.control.status');
        Route::post('/control/panel/{id}', [AdminAccessController::class, 'update'])->name('admin.control.update');
        Route::post('/control/panel/delete/{id}', [AdminAccessController::class, 'delete'])->name('admin.control.delete');
        Route::get('admin/log/info',[AdminAccessController::class,'adminLog'])->name('admin.log');
    });

});

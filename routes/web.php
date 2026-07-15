<?php

use App\Http\Controllers\StarttestController;
use App\Model\SMS;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::
        namespace('App\Http\Controllers')->group(function () {
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

            Route::middleware(['AuthUser'])->group(function () {

                Route::GET('/', 'MainController@index')->name('index');
                // Route::GET('/hearing-test', 'MainController@testIndex')->name('test.index');
                // Route::GET('/hearing-test-start', 'MainController@testStart')->name('test.start');
                Route::view('/product/show', 'frontend.newproduct.show')->name('prod.show');
                Route::view('/product/category', 'frontend.newproduct.category')->name('prod.category');
                Route::view('/about', 'frontend.about')->name('about');
                Route::view('/all-product', 'frontend.all-product')->name('all-product');
                Route::view('/product-detail', 'frontend.product-detail')->name('product-detail');
                Route::view('/checkout', 'frontend.checkout')->name('checkout');
                Route::GET('/faq', 'Admin\FaqController@manage')->name('faq');

                // policy
        
                Route::GET('/terms-condition', 'MainController@showPolicy')->name('terms-condition');
                Route::GET('/privacy', 'MainController@showPolicy')->name('privacy');
                Route::GET('/cancellation', 'MainController@showPolicy')->name('cancellation');
                Route::GET('/refund-return', 'MainController@showPolicy')->name('refund-return');
                Route::GET('/shipping', 'MainController@showPolicy')->name('shipping');

                // contact us
        
                Route::GET('/contact', 'EnquiryController@create')->name('contact');
                Route::POST('/contact', 'EnquiryController@store');
                Route::POST('/sendmail', 'MainController@sendMail')->name('sendmail');

                // Bulk Orders
        
                Route::POST('/bulk-orders', 'Admin\BulkOrderController@store')->name('bulk.store');

                // filter
        
                Route::GET('/search/filter', 'MainController@filter')->name('search.filter');
                Route::GET('/categories/filter', 'MainController@cateFilter')->name('categories.filter');

                // product routes
        
                Route::GET('/product/{slug}', 'MainController@getProduct')->name('product');
                Route::GET('/category/{slug}', 'MainController@getCategoryProducts')->name('cate');
                Route::GET('/search', 'MainController@search')->name('search');
                Route::POST('/get-sizes', 'MainController@getSizes')->name('get.sizes');
                Route::POST('/verify-promocode', 'MainController@verifyPromocode')->name('verify.promocode');
                Route::POST('/remove-promocode', 'MainController@removePromocode')->name('remove.promocode');
                Route::POST('/get-size-price', 'MainController@getSizePrice')->name('get.size.price');

                // Start Socialite
        
                Route::GET('auth/{provider}', 'SocialiteManageController@redirectToProvider')->name('user.auth.socialite');
                Route::GET('auth/{provider}/callback', 'SocialiteManageController@handleProviderCallback')->name('user.auth.socialite.callback');

                // End Socialite
        
                // Subscriber
        
                // Route::POST('/subscriber', 'MainController@subscribers')->name('subscribe');
                Route::GET('/unsubscriber/{email}', 'Admin\SubscriberController@unsubscribe')->name('unsubscribe');

                // Cart & Checkout
        
                Route::post('/cart', 'CartController@store')->name('cart.store');
                Route::get('/cart', 'CartController@index')->name('cart');
                Route::POST('/cart/delete', 'CartController@destroy')->name('cart.delete');
                Route::POST('/cart/update', 'CartController@update')->name('cart.update');
                Route::get('/checkout', 'OrderController@index')->name('checkout');
                Route::POST('/checkout', 'OrderController@checkout')->name('order.checkout');
                Route::POST('/transaction-callback', 'OrderController@handleCallbackFromPaytm')->name('paytm.callback');
                Route::get('/checkout/razorpay/{order}', 'OrderController@razorpayIndex')->name('razorpay.index');
                Route::post('/payment/razorpay-callback', 'OrderController@handleCallbackFromRazorpay')->name('razorpay.callback');

                Route::POST('/pincode', 'MainController@verifyPincode')->name('verify.pincode');
                Route::get('/order/success/{order}', 'OrderController@handleCallbackofCOD')->name('order.success');
                // Wishlist
        
                Route::post('/wishlist/add', 'WishlistController@store')->name('wishlist.add');
                Route::post('/wishlist/remove', 'WishlistController@destroy')->name('wishlist.remove');
            });

            Route::prefix('adranayas753')->group(function () {

                // Route::get('/test-view', [StarttestController::class, 'testlist'])->name('test.start.all');
                // Route::get('/test-view/{slug}', [StarttestController::class, 'testtable'])->name('test.start.table');
                // Route::post('/submit-form', 'FormController@submitForm');
        
                Route::middleware(['guest:admin'])->group(function () {
                    Route::GET('/login', 'AdminAuth\LoginController@showLoginForm')->name('login');
                    Route::POST('/login', 'AdminAuth\LoginController@login');
                    Route::GET('/login/otp', 'AdminAuth\LoginController@showOtpForm')->name('admin.login.otp');
                    Route::POST('/login/otp', 'AdminAuth\LoginController@verifyOtp');
                    Route::POST('/login/otp/resend', 'AdminAuth\LoginController@resendOtp')->name('admin.login.otp.resend');
                    Route::POST('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail');
                    Route::GET('/password/email', 'AdminAuth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
                    Route::POST('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
                    Route::POST('/password/reset', 'AdminAuth\ResetPasswordController@reset')->name('password.update');
                    Route::GET('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm')->name('password.reset');
                    Route::GET('/check/email', 'AdminAuth\LoginController@checkEmail')->name('check.email');
                });

                Route::group(['middleware' => ['auth:admin', 'admin.timeout']], function () {
                    Route::GET('/', 'AdminController@index')->name('admin.dashboard');
                    Route::GET('/profile', 'AdminController@edit')->name('admin.profile');
                    Route::POST('/profile', 'AdminController@update');
                    Route::match(['get', 'post'], '/logout', 'AdminAuth\LoginController@logout')->name('admin.logout');

                    Route::prefix('/manage-policies')->group(function () {
                        Route::GET('/edit/{slug}', 'Admin\PolicyController@edit')->name('admin.policies.edit');
                        Route::POST('/update/{slug}', 'Admin\PolicyController@update')->name('admin.policies.update');
                    });

                    Route::prefix('/manage-admins')->group(function () {
                        Route::GET('/', 'AdminController@manage')->name('admin.admins.all');
                        Route::POST('/', 'AdminController@store');
                        Route::GET('/edit/{id}', 'AdminController@edit')->name('admin.admins.edit');
                        Route::POST('/edit/{id}', 'AdminController@update');
                        Route::POST('/delete/{id}', 'AdminController@destroy');
                    });

                    Route::prefix('/manage-users')->group(function () {
                        Route::GET('/', 'Admin\UserManageController@index')->name('admin.users.all');
                        Route::GET('/edit/{id}', 'Admin\UserManageController@edit')->name('admin.users.edit');
                        Route::GET('/show/{id}', 'Admin\UserManageController@show')->name('admin.users.show');
                        Route::POST('/edit/{id}', 'Admin\UserManageController@update');
                        Route::GET('/orders/{id}', 'Admin\UserManageController@orders')->name('admin.users.orders');
                        Route::GET('/reviews/{id}', 'Admin\UserManageController@reviews')->name('admin.users.reviews');
                        Route::GET('/addresses/{id}', 'Admin\UserManageController@addresses')->name('admin.users.addresses');
                        Route::POST('/block', 'Admin\UserManageController@block')->name('admin.users.block');
                        Route::POST('/unblock', 'Admin\UserManageController@unblock')->name('admin.users.unblock');
                        Route::POST('/export', 'Admin\UserManageController@export')->name('admin.users.exports');
                    });

                    Route::prefix('/files')->group(function () {
                        Route::GET('/', 'Admin\FileUploadController@index')->name('admin.files.all');
                        Route::POST('/', 'Admin\FileUploadController@save')->name('admin.files.save');
                        Route::delete('/delete', 'Admin\FileUploadController@delete')->name('admin.files.delete');
                    });

                    Route::prefix('/manage-sliders')->group(function () {
                        Route::GET('/', 'Admin\SliderController@index')->name('admin.sliders.all');
                        Route::POST('/', 'Admin\SliderController@store');
                        Route::GET('/edit/{id}', 'Admin\SliderController@edit')->name('admin.sliders.edit');
                        Route::POST('/edit/{id}', 'Admin\SliderController@update');
                        Route::POST('/delete', 'Admin\SliderController@destroy')->name('admin.sliders.delete');
                    });

                    Route::prefix('/manage-categories')->group(function () {
                        Route::GET('/', 'Admin\CategoryController@index')->name('admin.categories.all');
                        Route::GET('/add', 'Admin\CategoryController@create')->name('admin.categories.create');
                        Route::POST('/add/catagory', 'Admin\CategoryController@store')->name('admin.categories.add');
                        Route::GET('/edit/{id}', 'Admin\CategoryController@edit')->name('admin.categories.edit');
                        Route::POST('/edit/{id}', 'Admin\CategoryController@update');
                        Route::POST('/get/catagory', 'Admin\CategoryController@getCategory');
                    });

                    Route::prefix('/manage-products')->group(function () {
                        Route::post('/products/import', 'Admin\ProductController@import')->name('products.import');
                        Route::GET('/', 'Admin\ProductController@index')->name('admin.products.all');
                        Route::GET('/add', 'Admin\ProductController@create')->name('admin.products.create');
                        Route::POST('/add', 'Admin\ProductController@store');
                        Route::GET('/edit/{id}', 'Admin\ProductController@edit')->name('admin.products.edit');
                        Route::POST('/edit/{id}', 'Admin\ProductController@update');
                        Route::GET('/questions/{id}', 'Admin\ProductController@getQuestions')->name('admin.products.questions');
                        Route::POST('/add-product-custom-field/{id}', 'Admin\ProductController@addCustomField')->name('admin.products.add.custom.field');
                        Route::POST('/update-product-custom-field', 'Admin\ProductController@updateCustomField')->name('admin.products.update.custom.field');
                        Route::POST('/delete-product-custom-field', 'Admin\ProductController@destroyCustomField')->name('admin.products.delete.custom.field');
                        Route::GET('/edit/question/{id}', 'Admin\ProductController@getQuestion')->name('admin.product-faqs.edit');
                        Route::POST('/edit/question/{id}', 'Admin\ProductController@updateQuestion')->name('admin.product-faqs.edit');
                        Route::POST('/delete/question/{id}', 'Admin\ProductController@deleteQuestion')->name('admin.product-faqs.delete');
                    });

                    Route::prefix('/manage-shop-by-budgets')->group(function () {
                        Route::GET('/', 'Admin\ShopByBudgetController@index')->name('admin.shop_by_budgets.index');
                        Route::POST('/', 'Admin\ShopByBudgetController@store');
                        Route::GET('/edit/{id}', 'Admin\ShopByBudgetController@edit')->name('admin.shop_by_budgets.edit');
                        Route::POST('/edit/{id}', 'Admin\ShopByBudgetController@update');
                        Route::POST('/delete/{id}', 'Admin\ShopByBudgetController@destroy');
                        Route::GET('/assign/{id}', 'Admin\ShopByBudgetController@assignPage')->name('admin.shop_by_budgets.assign');
                        Route::POST('/assign/{id}', 'Admin\ShopByBudgetController@assignProduct');
                        Route::POST('/remove-assign/{id}', 'Admin\ShopByBudgetController@removeAssign');
                        Route::POST('/update-sort/{id}', 'Admin\ShopByBudgetController@updateSort');
                        Route::POST('/update-budgets-sort', 'Admin\ShopByBudgetController@updateBudgetsSort')->name('admin.shop_by_budgets.update_budgets_sort');
                    });

                    Route::prefix('/manage-color-sizes')->group(function () {

                        Route::POST('/add-product-color/{id}', 'Admin\ProductController@addColor')->name('admin.products.add.color');
                        Route::POST('/update-product-color', 'Admin\ProductController@updateColor')->name('admin.products.update.color');
                        Route::POST('/delete-product-color', 'Admin\ProductController@destroyColor')->name('admin.products.delete.color');
                        Route::POST('/add/size/{id}', 'Admin\ProductController@addSizes')->name('admin.products.add.sizes');
                        Route::GET('/edit/color/{id}', 'Admin\ProductController@editColor')->name('admin.products.color.edit');
                        Route::POST('/edit/color/{id}', 'Admin\ProductController@updateColorSize')->name('admin.products.color.update');
                        Route::POST('/add-product-images/{id}', 'Admin\ProductController@addImages')->name('admin.products.add.images');
                        Route::POST('/delete-image', 'Admin\ProductController@deleteImage')->name('admin.products.delete.images');
                    });

                    Route::prefix('/manage-brands')->group(function () {
                        Route::GET('/', 'Admin\BrandController@index')->name('admin.brands.all');
                        Route::POST('/', 'Admin\BrandController@store')->name('admin.brands.store');
                        Route::GET('/edit/{id}', 'Admin\BrandController@edit')->name('admin.brands.edit');
                        Route::POST('/edit/{id}', 'Admin\BrandController@update');
                    });

                    Route::prefix('/manage-coupons')->group(function () {
                        Route::GET('/', 'Admin\CouponController@index')->name('admin.coupons.all');
                        Route::GET('/create', 'Admin\CouponController@create')->name('admin.coupons.create');
                        Route::POST('/store', 'Admin\CouponController@store')->name('admin.coupons.store');
                        Route::GET('/edit/{id}', 'Admin\CouponController@edit')->name('admin.coupons.edit');
                        Route::POST('/update/{id}', 'Admin\CouponController@update')->name('admin.coupons.update');
                        Route::POST('/delete/{id}', 'Admin\CouponController@destroy')->name('admin.coupons.delete');
                    });

                    Route::prefix('/manage-gsts')->group(function () {
                        Route::GET('/', 'Admin\GstController@index')->name('admin.gsts.all');
                        Route::POST('/', 'Admin\GstController@store');
                        Route::GET('/edit/{id}', 'Admin\GstController@edit')->name('admin.gsts.edit');
                        Route::POST('/edit/{id}', 'Admin\GstController@update');
                    });

                    Route::prefix('/manage-colors')->group(function () {
                        Route::GET('/', 'Admin\MstColorController@index')->name('admin.colors.all');
                        Route::POST('/', 'Admin\MstColorController@store');
                        Route::GET('/edit/{id}', 'Admin\MstColorController@edit')->name('admin.colors.edit');
                        Route::POST('/edit/{id}', 'Admin\MstColorController@update');
                    });

                    Route::prefix('/manage-materials')->group(function () {
                        Route::GET('/', 'Admin\MaterialController@index')->name('admin.materials.all');
                        Route::POST('/', 'Admin\MaterialController@store');
                        Route::GET('/edit/{id}', 'Admin\MaterialController@edit')->name('admin.materials.edit');
                        Route::POST('/edit/{id}', 'Admin\MaterialController@update');
                    });

                    Route::prefix('/manage-units')->group(function () {
                        Route::GET('/', 'Admin\UnitController@index')->name('admin.units.all');
                        Route::POST('/', 'Admin\UnitController@store');
                        Route::GET('/edit/{id}', 'Admin\UnitController@edit')->name('admin.units.edit');
                        Route::POST('/edit/{id}', 'Admin\UnitController@update');
                    });

                    Route::prefix('/manage-length-units')->group(function () {
                        Route::GET('/', 'Admin\LengthUnitController@index')->name('admin.length_units.all');
                        Route::POST('/', 'Admin\LengthUnitController@store');
                        Route::GET('/edit/{id}', 'Admin\LengthUnitController@edit')->name('admin.length_units.edit');
                        Route::POST('/edit/{id}', 'Admin\LengthUnitController@update');
                    });

                    Route::prefix('/manage-sizes')->group(function () {
                        Route::GET('/', 'Admin\MstSizeController@index')->name('admin.sizes.all');
                        Route::POST('/', 'Admin\MstSizeController@store');
                        Route::GET('/edit/{id}', 'Admin\MstSizeController@edit')->name('admin.sizes.edit');
                        Route::POST('/edit/{id}', 'Admin\MstSizeController@update');
                    });

                    Route::prefix('/manage-conditions')->group(function () {
                        Route::GET('/', 'Admin\ConditionController@index')->name('admin.conditions.all');
                        Route::POST('/', 'Admin\ConditionController@store');
                        Route::GET('/edit/{id}', 'Admin\ConditionController@edit')->name('admin.conditions.edit');
                        Route::POST('/edit/{id}', 'Admin\ConditionController@update');
                    });

                    Route::prefix('/manage-warranties')->group(function () {
                        Route::GET('/', 'Admin\WarrantyController@index')->name('admin.warranties.all');
                        Route::POST('/', 'Admin\WarrantyController@store');
                        Route::GET('/edit/{id}', 'Admin\WarrantyController@edit')->name('admin.warranties.edit');
                        Route::POST('/edit/{id}', 'Admin\WarrantyController@update');
                    });


                    Route::prefix('/manage-reviews')->group(function () {
                        Route::GET('/', 'Admin\ReviewController@index')->name('admin.reviews.all');
                        Route::POST('/', 'Admin\ReviewController@store');
                        Route::GET('/edit/{id}', 'Admin\ReviewController@edit')->name('admin.reviews.edit');
                        Route::POST('/edit/{id}', 'Admin\ReviewController@update');
                        Route::POST('/delete', 'Admin\ReviewController@destroy')->name('admin.reviews.delete');
                    });

                    Route::prefix('/manage-tickets')->group(function () {
                        Route::GET('/', 'Admin\TicketController@index')->name('admin.tickets.all');
                        Route::POST('/', 'Admin\TicketController@store');
                        Route::GET('/edit/{id}', 'Admin\TicketController@edit')->name('admin.tickets.edit');
                        Route::POST('/edit/{id}', 'Admin\TicketController@update');
                    });

                    Route::prefix('/manage-return-refund-tickets')->group(function () {
                        Route::GET('/', 'Admin\ReturnticketController@index')->name('admin.return-tickets.all');
                        Route::POST('/', 'Admin\ReturnticketController@store');
                        Route::GET('/edit/{id}', 'Admin\ReturnticketController@edit')->name('admin.return-tickets.edit');
                        Route::POST('/edit/{id}', 'Admin\ReturnticketController@update');
                    });

                    /* Route::prefix('/manage-subscribers')->group(function () {
                        Route::GET('/', 'Admin\SubscriberController@index')->name('admin.subscribers.all');
                        Route::POST('/view', 'Admin\SubscriberController@show')->name('admin.subscribers.show');
                        Route::POST('/send', 'Admin\SubscriberController@send')->name('admin.subscribers.send');
                    }); */

                    Route::prefix('/manage-orders')->group(function () {
                        Route::GET('/', 'Admin\OrderController@index')->name('admin.orders.all');
                        Route::GET('/show/{id}', 'Admin\OrderController@show')->name('admin.orders.show');
                        Route::POST('/show/{id}', 'Admin\OrderController@update');
                        Route::POST('/return-status/{id}', 'Admin\OrderController@returnUpdate')->name('admin.orders.return-status');
                        Route::POST('/assign/{id}', 'Admin\OrderController@assignShipment')->name('admin.orders.assign');
                        Route::POST('/charges', 'Admin\OrderController@updateCharges')->name('admin.orders.charges');
                        Route::GET('/generate-label/{id}', 'Admin\OrderController@generateLabel')->name('admin.orders.generate-label');
                        Route::POST('/export', 'Admin\OrderController@export')->name('admin.orders.export');
                    });

                    Route::prefix('/manage-reports')->group(function () {
                        Route::GET('/', 'Admin\ReportController@index')->name('admin.reports.all');
                        Route::POST('/', 'Admin\ReportController@generateReport');
                        Route::POST('/export-report', 'Admin\ReportController@exportGeneratedReport')->name('admin.orders.reports.export');
                    });

                    Route::prefix('/manage-invoices')->group(function () {
                        Route::GET('/', 'Admin\InvoiceController@index')->name('admin.invoices.all');
                        Route::GET('/show/{id}', 'Admin\InvoiceController@show')->name('admin.invoices.show');
                        Route::GET('/download/{id}', 'Admin\InvoiceController@downloadInvoice')->name('admin.invoices.download');
                        Route::POST('/resend', 'Admin\InvoiceController@resendInvoice')->name('admin.invoices.resend');
                    });

                    Route::prefix('/manage-enquiries')->group(function () {
                        Route::GET('/', 'EnquiryController@index')->name('admin.enquiries.all');
                    });

                    Route::prefix('/manage-faqs')->group(function () {
                        Route::GET('/', 'Admin\FaqController@index')->name('admin.faqs.all');
                        Route::POST('/', 'Admin\FaqController@store');
                        Route::GET('/edit/{id}', 'Admin\FaqController@edit')->name('admin.faqs.edit');
                        Route::POST('/edit/{id}', 'Admin\FaqController@update');
                        Route::POST('/delete', 'Admin\FaqController@destroy')->name('admin.faqs.delete');
                    });

                    Route::prefix('/manage-abouts')->group(function () {
                        Route::GET('/', 'Admin\AboutController@index')->name('admin.abouts.all');
                        Route::POST('/', 'Admin\AboutController@store');
                        Route::POST('/edit/{id}', 'Admin\AboutController@update');
                        Route::POST('/delete/{id}', 'Admin\AboutController@destroy');
                    });

                    Route::prefix('/manage-shops')->group(function () {
                        Route::GET('/', 'Admin\ShopController@index')->name('admin.shops.all');
                        Route::POST('/', 'Admin\ShopController@store');
                        Route::GET('{id}/edit', 'Admin\ShopController@edit')->name('admin.shops.edit');
                        Route::GET('{id}/coupons', 'Admin\ShopController@coupons')->name('admin.shops.coupons');
                        Route::POST('{id}/edit', 'Admin\ShopController@update');
                        Route::POST('{id}/download/pdf', 'Admin\ShopController@downloadPdf')->name('admin.shops.download.pdf');
                        Route::POST('{id}/download/excel', 'Admin\ShopController@downloadExcel')->name('admin.shops.download.excel');
                        Route::POST('/delete', 'Admin\ShopController@destroy')->name('admin.shops.delete');
                        Route::POST('/generate-coupon/{id}', 'Admin\ShopController@generateCoupon')->name('admin.shops.generate');
                    });

                    Route::prefix('/manage-home-offer-sliders')->group(function () {
                        Route::GET('/', 'Admin\HomeOfferSliderController@index')->name('admin.home-offer-sliders.all');
                        Route::POST('/', 'Admin\HomeOfferSliderController@store');
                        Route::GET('/edit/{slider}', 'Admin\HomeOfferSliderController@edit')->name('admin.home-offer-sliders.edit');
                        Route::POST('/edit/{slider}', 'Admin\HomeOfferSliderController@update')->name('admin.home-offer-sliders.update');
                        Route::POST('/delete', 'Admin\HomeOfferSliderController@destroy')->name('admin.home-offer-sliders.delete');
                    });

                    Route::prefix('/manage-offers')->group(function () {
                        Route::GET('/', 'Admin\OfferController@index')->name('admin.offers.all');
                        Route::POST('/', 'Admin\OfferController@store');
                        Route::GET('/edit/{id}', 'Admin\OfferController@edit')->name('admin.offers.edit');
                        Route::POST('/edit/{id}', 'Admin\OfferController@update')->name('admin.offers.update');
                        Route::POST('/delete', 'Admin\OfferController@destroy')->name('admin.offers.delete');
                        Route::POST('/get/products', 'Admin\OfferController@getProducts')->name('admin.offers.getProduct');
                        Route::POST('/get/colours', 'Admin\OfferController@getColors')->name('admin.offers.getColors');
                        Route::POST('/add/offer', 'Admin\OfferController@mapOfferProduct')->name('admin.offers.map.offer');
                        Route::GET('/offer/edit/{id}', 'Admin\OfferController@editOffer')->name('admin.offers.map.edit');
                    });
                });
            });

            // User
            Route::prefix('myaccount')->group(function () {

                Route::middleware(['guest:user'])->group(function () {
                    Route::GET('/login', 'UserAuth\LoginController@showLoginForm')->name('user.login');
                    Route::GET('/login/otp', 'UserAuth\LoginController@showOtpLoginForm')->name('user.login.otp');
                    Route::POST('/login/otp', 'UserAuth\LoginController@otpLogin')->name('user.login.otp');
                    Route::POST('/login', 'UserAuth\LoginController@login')->name('user.login');
                    Route::GET('/register', 'UserAuth\LoginController@create')->name('user.register');
                    Route::POST('/register', 'UserAuth\LoginController@store')->name('user.register');
                    Route::POST('/register/phone', 'UserAuth\LoginController@registerPhone')->name('user.register.phone');
                    Route::GET('/register/mail', 'UserAuth\LoginController@createMail')->name('user.register.mail');
                    Route::GET('/otp', 'UserAuth\LoginController@otp')->name('user.otp');
                    Route::POST('/otp/resend', 'UserAuth\LoginController@resendOtp')->name('user.otp.resend');
                    Route::POST('/otp/verify', 'UserAuth\LoginController@verifyOtp')->name('user.otp.verify');
                    Route::GET('/password/email', 'UserResetPassword@showResetRequestForm')->name('user.password.request');
                    Route::POST('/password/email', 'UserResetPassword@sendResetLinkEmail')->name('user.password.email');
                    Route::GET('/password/reset/{token}', 'UserResetPassword@showResetForm')->name('user.password.reset');
                    Route::POST('/password/reset', 'UserResetPassword@reset')->name('user.password.update');
                });

                Route::group(['middleware' => 'auth:user'], function () {

                    Route::match(['get', 'post'], '/logout', 'UserAuth\LoginController@logout')->name('user.logout');
                    Route::GET('/', 'UserController@index')->name('user.dashboard');
                    Route::GET('/profile', 'UserController@showMyAccount')->name('user.profile');
                    Route::GET('/change-password', 'UserController@showChangePassword')->name('user.change-password');
                    Route::GET('/orders', 'UserController@showOrder')->name('user.showOrder');
                    Route::GET('/wishlists', 'UserController@getWishlists')->name('user.wishlists');
                    Route::POST('/profile', 'UserController@update')->name('user.profile.updateRequest');
                    Route::POST('/change-password', 'UserController@updateChangePassword')->name('user.change-password.updateRequest');
                    Route::POST('/review', 'UserController@review');
                    Route::GET('/order/{id}', 'UserController@getOrder')->name('user.order');
                    Route::GET('/order-tracking/{id}', 'UserController@getOrderTracking')->name('user.order.tracking');
                    Route::POST('/order/return/{id}', 'UserController@returnOrder')->name('user.orders.return');
                    Route::POST('/order/help/{id}', 'UserController@orderHelp')->name('user.orders.help');
                    Route::POST('/order/cancel', 'UserController@cancelOrder')->name('user.orders.cancel');
                    Route::GET('/download/{id}', 'UserController@downloadInvoice')->name('user.invoices.download');
                    Route::GET('/addresses', 'UserController@getAddresses')->name('user.addresses');
                    Route::POST('/addresses/add', 'UserController@storeAddress')->name('user.addresses.add');
                    Route::GET('/addresses/edit/{id}', 'UserController@editAddress')->name('user.addresses.edit');
                    Route::POST('/addresses/edit/{id}', 'UserController@UpdateAddress')->name('user.addresses.update');
                    Route::POST('/addresses/delete', 'UserController@deleteAddress')->name('user.addresses.delete');
                    Route::POST('/addresses/edit', 'UserController@fEditAddress')->name('user.addresses.fedit');
                    Route::POST('/addresses/update', 'UserController@fUpdateAddress')->name('user.addresses.fupdate');
                });
            });

            // Shop
        
            Route::prefix('ranayasshop')->group(function () {

                Route::middleware(['guest:shop'])->group(function () {
                    Route::GET('/login', 'ShopAuth\LoginController@showLoginForm')->name('shop.login');
                    Route::POST('/login', 'ShopAuth\LoginController@login')->name('shop.login');
                });

                Route::group(['middleware' => 'auth:shop'], function () {

                    Route::GET('/', 'ShopController@index')->name('shop.dashboard');

                    Route::GET('/profile', 'ShopController@getAccount')->name('shop.account');

                    Route::POST('/profile', 'ShopController@update')->name('shop.update');

                    Route::match(['get', 'post'], '/logout', 'ShopAuth\LoginController@logout')->name('shop.logout');
                });
            });

        });

// Test route to send SMS: /test-sms?mobile=9876543210&text=Hello
Route::get('/test-sms', function (Request $request) {
    // $mobile = $request->query('mobile');
    $mobile = "7045882487";
    // $otp = $request->query('otp');
    $otp = "393292";
    $templateid = $request->query('templateid', '');

    if (empty($mobile)) {
        return response()->json(['success' => false, 'message' => 'Provide mobile query param, e.g. ?mobile=9876543210']);
    }

    if (!empty($otp)) {
        // Build exact template text replacing placeholder with OTP (single-line)
        $text = 'Dear Customer, Thank You for login with RANAYAS. Your OTP for login is ' . $otp . '.';
    } else {
        // Fallback to testing the template even if no OTP provided, as it's the only one
        $text = 'Dear Customer, Thank You for login with RANAYAS. Your OTP for login is 123456.';
    }

    $result = SMS::send($mobile, $text, $templateid);

    return response()->json($result);
})->name('test.sms');



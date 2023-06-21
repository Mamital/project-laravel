<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\admin\user\RoleController;
use App\Http\Controllers\admin\notify\SMSController;
use App\Http\Controllers\Admin\Content\FAQController;
use App\Http\Controllers\Admin\Content\MenuController;
use App\Http\Controllers\admin\content\PageController;
use App\Http\Controllers\admin\content\PostController;
use App\Http\Controllers\Admin\Market\BanerController;
use App\Http\Controllers\Admin\Market\BrandController;
use App\Http\Controllers\Admin\Market\OrderController;
use App\Http\Controllers\Admin\Market\StoreController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\admin\notify\EmailController;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\admin\ticket\TicketController;
use App\Http\Controllers\Admin\User\CustomerController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\Market\CommentController;
use App\Http\Controllers\Admin\Market\GalleryController;
use App\Http\Controllers\Admin\Market\PaymentController;
use App\Http\Controllers\Admin\Market\ProductController;
use App\Http\Controllers\Admin\User\AdminUserController;
use App\Http\Controllers\Admin\Market\CategoryController;
use App\Http\Controllers\Admin\Market\DeliveryController;
use App\Http\Controllers\Admin\Market\DiscountController;
use App\Http\Controllers\Admin\Market\PropertyController;
use App\Http\Controllers\admin\setting\SettingController;
use App\Http\Controllers\admin\user\PermissionController;
use App\Http\Controllers\Admin\Market\GuaranteeController;
use App\Http\Controllers\Admin\Notify\EmailFileController;
use App\Http\Controllers\Admin\Ticket\TicketAdminController;
use App\Http\Controllers\Customer\Profile\CompareController;
use App\Http\Controllers\Customer\Profile\ProfileController;
use App\Http\Controllers\Admin\Market\ProductColorController;
use App\Http\Controllers\Customer\Profile\FavoriteController;
use App\Http\Controllers\Admin\Market\CategoryValueController;
use App\Http\Controllers\Admin\Ticket\TicketCategoryController;
use App\Http\Controllers\Admin\Ticket\TicketPriorityController;
use App\Http\Controllers\Customer\SalesProccess\CartController;
use App\Http\Controllers\Customer\Profile\PhoneNumberController;
use App\Http\Controllers\Customer\SalesProccess\AddressController;
use App\Http\Controllers\Customer\SalesProccess\ProfileCompletionController;
use App\Http\Controllers\Admin\Market\CommentController as MarketCommentController;
use App\Http\Controllers\Customer\Profile\EmailController as ProfileEmailController;
use App\Http\Controllers\Admin\Content\CommentController as ContentCommentController;
use App\Http\Controllers\Customer\Profile\OrderController as CustomerOrderController;
use App\Http\Controllers\Admin\Content\CategoryController as ContentCategoryController;
use App\Http\Controllers\Customer\Profile\TicketController as CustomerTicketController;
use App\Http\Controllers\Customer\Market\ProductController as CustomerProductController;
use App\Http\Controllers\Customer\Profile\AddressController as CustomerAddressController;
use App\Http\Controllers\Customer\SalesProccess\PaymentController as CustomerPaymentController;

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
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::middleware('admin')->prefix('admin')->namespace('Admin')->group(function () {

    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.home');

    Route::prefix('market')->namespace('Market')->group(function () {

        //category
        Route::prefix('category')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('admin.market.category.index')->middleware('can:read-productCategory');
            Route::get('/create', [CategoryController::class, 'create'])->name('admin.market.category.create')->middleware('can:create-productCategory');
            Route::post('/store', [CategoryController::class, 'store'])->name('admin.market.category.store')->middleware('can:create-productCategory');
            Route::get('/edit/{productCategory}', [CategoryController::class, 'edit'])->name('admin.market.category.edit')->middleware('can:edit-productCategory');
            Route::put('/update/{productCategory}', [CategoryController::class, 'update'])->name('admin.market.category.update')->middleware('can:edit-productCategory');
            Route::delete('/destroy/{productCategory}', [CategoryController::class, 'destroy'])->name('admin.market.category.destroy')->middleware('can:delete-productCategory');
            Route::get('/status/{productCategory}', [CategoryController::class, 'status'])->name('admin.market.category.status')->middleware('can:edit-productCategory');
            Route::get('/show-in-menu/{productCategory}', [CategoryController::class, 'showInMenu'])->name('admin.market.category.show-in-menu')->middleware('can:edit-productCategory');
        });

        //baners
        Route::prefix('baner')->group(function () {
            Route::get('/', [BanerController::class, 'index'])->name('admin.market.baner.index')->middleware('can:read-baner');
            Route::get('/create', [BanerController::class, 'create'])->name('admin.market.baner.create')->middleware('can:create-baner');
            Route::post('/store', [BanerController::class, 'store'])->name('admin.market.baner.store')->middleware('can:create-baner');
            Route::get('/edit/{baner}', [BanerController::class, 'edit'])->name('admin.market.baner.edit')->middleware('can:edit-baner');
            Route::put('/update/{baner}', [BanerController::class, 'update'])->name('admin.market.baner.update')->middleware('can:edit-baner');
            Route::delete('/destroy/{baner}', [BanerController::class, 'destroy'])->name('admin.market.baner.destroy')->middleware('can:delete-baner');
            Route::get('/status/{baner}', [BanerController::class, 'status'])->name('admin.market.baner.status')->middleware('can:edit-baner');
        });

        Route::prefix('color')->group(function () {
            //color
            Route::get('/{product}', [ProductColorController::class, 'index'])->name('admin.market.color.index')->middleware('can:read-product');
            Route::get('/create/{product}', [ProductColorController::class, 'create'])->name('admin.market.color.create')->middleware('can:create-product');
            Route::post('/store/{product}', [ProductColorController::class, 'store'])->name('admin.market.color.store')->middleware('can:create-product');
            Route::delete('/destroy/{product}/{productColor}', [ProductColorController::class, 'destroy'])->name('admin.market.color.destroy')->middleware('can:delete-product');
            Route::get('/status/{productColor}', [ProductColorController::class, 'status'])->name('admin.market.color.status')->middleware('can:edit-product');
        });

        //Guarantee
        Route::prefix('guarantee')->group(function () {
            Route::get('/{product}', [GuaranteeController::class, 'index'])->name('admin.market.guarantee.index')->middleware('can:read-product');
            Route::get('/create/{product}', [GuaranteeController::class, 'create'])->name('admin.market.guarantee.create')->middleware('can:create-product');
            Route::post('/store/{product}', [GuaranteeController::class, 'store'])->name('admin.market.guarantee.store')->middleware('can:create-product');
            Route::delete('/destroy/{guarantee}/{product}', [GuaranteeController::class, 'destroy'])->name('admin.market.guarantee.destroy')->middleware('can:delete-product');
            Route::get('/status/{guarantee}', [GuaranteeController::class, 'status'])->name('admin.market.guarantee.status')->middleware('can:edit-product');
        });

        //brand
        Route::prefix('brand')->group(function () {
            Route::get('/', [BrandController::class, 'index'])->name('admin.market.brand.index')->middleware('can:read-brand');
            Route::get('/create', [BrandController::class, 'create'])->name('admin.market.brand.create')->middleware('can:create-brand');
            Route::post('/store', [BrandController::class, 'store'])->name('admin.market.brand.store')->middleware('can:create-brand');
            Route::get('/edit/{brand}', [BrandController::class, 'edit'])->name('admin.market.brand.edit')->middleware('can:edit-brand');
            Route::put('/update/{brand}', [BrandController::class, 'update'])->name('admin.market.brand.update')->middleware('can:edit-brand');
            Route::delete('/destroy/{brand}', [BrandController::class, 'destroy'])->name('admin.market.brand.destroy')->middleware('can:delete-brand');
            Route::get('/status/{brand}', [BrandController::class, 'status'])->name('admin.market.brand.status')->middleware('can:edit-brand');
        });

        //comment
        Route::prefix('comment')->group(function () {
            Route::get('/', [MarketCommentController::class, 'index'])->name('admin.market.comment.index')->middleware('can:read-productComment');
            Route::get('/show/{comment}', [MarketCommentController::class, 'show'])->name('admin.market.comment.show')->middleware('can:read-productComment');
            Route::delete('/destroy/{comment}', [MarketCommentController::class, 'destroy'])->name('admin.market.comment.destroy')->middleware('can:approve-productComment');
            Route::get('/approved/{comment}', [MarketCommentController::class, 'approved'])->name('admin.market.comment.approved')->middleware('can:approve-productComment');
            Route::get('/status/{comment}', [MarketCommentController::class, 'status'])->name('admin.market.comment.status')->middleware('can:approve-productComment');
            Route::post('/answer/{comment}', [MarketCommentController::class, 'answer'])->name('admin.market.comment.answer')->middleware('can:answer-productComment');
        });

        //delivery
        Route::prefix('delivery')->group(function () {
            Route::get('/', [DeliveryController::class, 'index'])->name('admin.market.delivery.index')->middleware('can:read-delivery');
            Route::get('/create', [DeliveryController::class, 'create'])->name('admin.market.delivery.create')->middleware('can:create-delivery');
            Route::post('/store', [DeliveryController::class, 'store'])->name('admin.market.delivery.store')->middleware('can:create-delivery');
            Route::get('/edit/{delivery}', [DeliveryController::class, 'edit'])->name('admin.market.delivery.edit')->middleware('can:edit-delivery');
            Route::put('/update/{delivery}', [DeliveryController::class, 'update'])->name('admin.market.delivery.update')->middleware('can:edit-delivery');
            Route::delete('/destroy/{delivery}', [DeliveryController::class, 'destroy'])->name('admin.market.delivery.destroy')->middleware('can:delete-delivery');
            Route::get('/status/{delivery}', [DeliveryController::class, 'status'])->name('admin.market.delivery.status')->middleware('can:edit-delivery');
        });

        //discount
        Route::prefix('discount')->group(function () {

            //copan

            Route::get('/copan', [DiscountController::class, 'copan'])->name('admin.market.discount.copan')->middleware('can:read-discount');
            Route::get('/copan/create', [DiscountController::class, 'copanCreate'])->name('admin.market.discount.copan.create')->middleware('can:create-discount');
            Route::post('/copan/store', [DiscountController::class, 'copanStore'])->name('admin.market.discount.copan.store')->middleware('can:create-discount');
            Route::get('/copan/edit/{copan}', [DiscountController::class, 'copanEdit'])->name('admin.market.discount.copan.edit')->middleware('can:edit-discount');
            Route::put('/copan/update/{copan}', [DiscountController::class, 'copanUpdate'])->name('admin.market.discount.copan.update')->middleware('can:edit-discount');
            Route::delete('/copan/destroy/{copan}', [DiscountController::class, 'copanDestroy'])->name('admin.market.discount.copan.destroy')->middleware('can:delete-discount');

            //common discount

            Route::get('/common-discount', [DiscountController::class, 'commonDiscount'])->name('admin.market.discount.commonDiscount')->middleware('can:read-discount');
            Route::get('/common-discount/create', [DiscountController::class, 'commonDiscountCreate'])->name('admin.market.discount.commonDiscount.create')->middleware('can:create-discount');
            Route::post('/common-discount/store', [DiscountController::class, 'commonDiscountStore'])->name('admin.market.discount.commonDiscount.store')->middleware('can:create-discount');
            Route::get('/common-discount/edit/{commonDiscount}', [DiscountController::class, 'commonDiscountEdit'])->name('admin.market.discount.commonDiscount.edit')->middleware('can:edit-discount');
            Route::put('/common-discount/update/{commonDiscount}', [DiscountController::class, 'commonDiscountUpdate'])->name('admin.market.discount.commonDiscount.update')->middleware('can:edit-discount');
            Route::delete('/common-discount/destroy/{commonDiscount}', [DiscountController::class, 'commonDiscountDestroy'])->name('admin.market.discount.commonDiscount.destroy')->middleware('can:delete-discount');

            //amazing sale

            Route::get('/amazing-sale', [DiscountController::class, 'amazingSale'])->name('admin.market.discount.amazingSale')->middleware('can:read-discount');
            Route::get('/amazing-sale/create', [DiscountController::class, 'amazingSaleCreate'])->name('admin.market.discount.amazingSale.create')->middleware('can:create-discount');
            Route::post('/amazing-sale/store', [DiscountController::class, 'amazingSaleStore'])->name('admin.market.discount.amazingSale.store')->middleware('can:create-discount');
            Route::get('/amazing-sale/edit/{amazingSale}', [DiscountController::class, 'amazingSaleEdit'])->name('admin.market.discount.amazingSale.edit')->middleware('can:edit-discount');
            Route::put('/amazing-sale/update/{amazingSale}', [DiscountController::class, 'amazingSaleUpdate'])->name('admin.market.discount.amazingSale.update')->middleware('can:edit-discount');
            Route::delete('/amazing-sale/destroy/{amazingSale}', [DiscountController::class, 'amazingSaleDestroy'])->name('admin.market.discount.amazingSale.destroy')->middleware('can:delete-discount');
        });

        //order
        Route::prefix('order')->group(function () {
            Route::get('/', [OrderController::class, 'all'])->name('admin.market.order.all')->middleware('can:read-order');
            Route::get('/new-order', [OrderController::class, 'newOrders'])->name('admin.market.order.newOrders')->middleware('can:read-order');
            Route::get('/sending', [OrderController::class, 'sending'])->name('admin.market.order.sending')->middleware('can:edit-order');
            Route::get('/unpaid', [OrderController::class, 'unpaid'])->name('admin.market.order.unpaid')->middleware('can:edit-order');
            Route::get('/canceled', [OrderController::class, 'canceled'])->name('admin.market.order.canceled')->middleware('can:edit-order');
            Route::get('/returned', [OrderController::class, 'returned'])->name('admin.market.order.returned')->middleware('can:edit-order');
            Route::get('/show/{order}', [OrderController::class, 'show'])->name('admin.market.order.show')->middleware('can:read-order');
            Route::get('/show/{order}/detail', [OrderController::class, 'detail'])->name('admin.market.order.detail')->middleware('can:read-order');
            Route::get('/change-send-status/{order}', [OrderController::class, 'changeSendStatus'])->name('admin.market.order.changeSendStatus')->middleware('can:edit-order');
            Route::get('/change-order-status/{order}', [OrderController::class, 'changeOrderStatus'])->name('admin.market.order.changeOrderStatus')->middleware('can:edit-order');
            Route::get('/cancel-order/{order}', [OrderController::class, 'cancelOrder'])->name('admin.market.order.cancelOrder')->middleware('can:edit-order');
        });


        //payment
        Route::prefix('payment')->group(function () {
            Route::get('/', [PaymentController::class, 'index'])->name('admin.market.payment.index')->middleware('can:read-payment');
            Route::get('/show/{payment}', [PaymentController::class, 'show'])->name('admin.market.payment.show')->middleware('can:read-payment');
            Route::get('/online', [PaymentController::class, 'online'])->name('admin.market.payment.online')->middleware('can:read-payment');
            Route::get('/offline', [PaymentController::class, 'offline'])->name('admin.market.payment.offline')->middleware('can:read-payment');
            Route::get('/attendance', [PaymentController::class, 'attendance'])->name('admin.market.payment.attendance')->middleware('can:edit-payment');
            Route::get('/confirm', [PaymentController::class, 'confirm'])->name('admin.market.payment.confirm')->middleware('can:edit-payment');
            Route::get('/cancel/{payment}', [PaymentController::class, 'cancel'])->name('admin.market.payment.cancel')->middleware('can:edit-payment');
            Route::get('/return/{payment}', [PaymentController::class, 'return'])->name('admin.market.payment.return')->middleware('can:edit-payment');
        });

        //product
        Route::prefix('product')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('admin.market.product.index')->middleware('can:read-product');
            Route::get('/create', [ProductController::class, 'create'])->name('admin.market.product.create')->middleware('can:create-product');
            Route::post('/store', [ProductController::class, 'store'])->name('admin.market.product.store')->middleware('can:create-product');
            Route::get('/edit/{product}', [ProductController::class, 'edit'])->name('admin.market.product.edit')->middleware('can:edit-product');
            Route::put('/update/{product}', [ProductController::class, 'update'])->name('admin.market.product.update')->middleware('can:edit-product');
            Route::delete('/destroy/{product}', [ProductController::class, 'destroy'])->name('admin.market.product.destroy')->middleware('can:delete-product');
            Route::get('/status/{product}', [ProductController::class, 'status'])->name('admin.market.product.status')->middleware('can:edit-product');
            Route::get('/marketable/{product}', [ProductController::class, 'marketable'])->name('admin.market.product.marketable')->middleware('can:edit-product');
            //gallery
            Route::get('/gallery/{product}', [GalleryController::class, 'index'])->name('admin.market.gallery.index')->middleware('can:edit-product');
            Route::get('/create/{product}', [GalleryController::class, 'create'])->name('admin.market.gallery.create')->middleware('can:edit-product');
            Route::post('/gallery/store/{product}', [GalleryController::class, 'store'])->name('admin.market.gallery.store')->middleware('can:edit-product');
            Route::delete('/gallery/destroy{product}/{gallery}', [GalleryController::class, 'destroy'])->name('admin.market.gallery.destroy')->middleware('can:edit-product');
            Route::get('/status/{gallery}', [GalleryController::class, 'status'])->name('admin.market.gallery.status')->middleware('can:edit-product');
        });

        //property
        Route::prefix('property')->group(function () {
            Route::get('/', [PropertyController::class, 'index'])->name('admin.market.property.index')->middleware('can:edit-product');
            Route::get('/create', [PropertyController::class, 'create'])->name('admin.market.property.create')->middleware('can:edit-product');
            Route::post('/store', [PropertyController::class, 'store'])->name('admin.market.property.store')->middleware('can:edit-product');
            Route::get('/edit/{property}', [PropertyController::class, 'edit'])->name('admin.market.property.edit')->middleware('can:edit-product');
            Route::put('/update/{property}', [PropertyController::class, 'update'])->name('admin.market.property.update')->middleware('can:edit-product');
            Route::delete('/destroy/{property}', [PropertyController::class, 'destroy'])->name('admin.market.property.destroy')->middleware('can:edit-product');

            Route::prefix('value')->group(function () {
                //value
                Route::get('/{property}', [CategoryValueController::class, 'index'])->name('admin.market.value.index')->middleware('can:edit-product');
                Route::get('/create/{property}', [CategoryValueController::class, 'create'])->name('admin.market.value.create')->middleware('can:edit-product');
                Route::post('/store/{property}', [CategoryValueController::class, 'store'])->name('admin.market.value.store')->middleware('can:edit-product');
                Route::get('/edit/{property}/{categoryValue}', [CategoryValueController::class, 'edit'])->name('admin.market.value.edit')->middleware('can:edit-product');
                Route::put('/update/{property}/{categoryValue}', [CategoryValueController::class, 'update'])->name('admin.market.value.update')->middleware('can:edit-product');
                Route::delete('/destroy/{property}/{categoryValue}', [CategoryValueController::class, 'destroy'])->name('admin.market.value.destroy')->middleware('can:edit-product');
                Route::get('/status/{categoryValue}', [CategoryValueController::class, 'status'])->name('admin.market.value.status')->middleware('can:edit-product');
            });
        });

        //store
        Route::prefix('store')->group(function () {
            Route::get('/', [StoreController::class, 'index'])->name('admin.market.store.index')->middleware('can:read-store');
            Route::get('/add-to-store/{product}', [StoreController::class, 'addToStore'])->name('admin.market.store.add-to-store')->middleware('can:edit-store');
            Route::post('/store/{product}', [StoreController::class, 'store'])->name('admin.market.store.store')->middleware('can:edit-store');
            Route::get('/edit/{product}', [StoreController::class, 'edit'])->name('admin.market.store.edit')->middleware('can:edit-store');
            Route::put('/update/{product}', [StoreController::class, 'update'])->name('admin.market.store.update')->middleware('can:edit-store');
        });
    });

    Route::prefix('content')->namespace('Content')->group(function () {

        //category
        Route::prefix('category')->group(function () {
            Route::get('/', [ContentCategoryController::class, 'index'])->name('admin.content.category.index')->middleware('can:read-postCategory');
            Route::get('/create', [ContentCategoryController::class, 'create'])->name('admin.content.category.create')->middleware('can:create-postCategory');
            Route::post('/store', [ContentCategoryController::class, 'store'])->name('admin.content.category.store')->middleware('can:create-postCategory');
            Route::get('/edit/{postCategory}', [ContentCategoryController::class, 'edit'])->name('admin.content.category.edit')->middleware('can:edit-postCategory');
            Route::put('/update/{postCategory}', [ContentCategoryController::class, 'update'])->name('admin.content.category.update')->middleware('can:edit-postCategory');
            Route::delete('/destroy/{postCategory}', [ContentCategoryController::class, 'destroy'])->name('admin.content.category.destroy')->middleware('can:delete-postCategory');
            Route::get('/status/{postCategory}', [ContentCategoryController::class, 'status'])->name('admin.content.category.status')->middleware('can:edit-postCategory');
        });

        //comment
        Route::prefix('comment')->group(function () {
            Route::get('/', [ContentCommentController::class, 'index'])->name('admin.content.comment.index')->middleware('can:read-postComment');
            Route::get('/show/{comment}', [ContentCommentController::class, 'show'])->name('admin.content.comment.show')->middleware('can:read-postComment');
            Route::delete('/destroy/{comment}', [ContentCommentController::class, 'destroy'])->name('admin.content.comment.destroy')->middleware('can:approved-postComment');
            Route::get('/approved/{comment}', [ContentCommentController::class, 'approved'])->name('admin.content.comment.approved')->middleware('can:approved-postComment');
            Route::get('/status/{comment}', [ContentCommentController::class, 'status'])->name('admin.content.comment.status')->middleware('can:approved-postComment');
            Route::post('/answer/{comment}', [ContentCommentController::class, 'answer'])->name('admin.content.comment.answer')->middleware('can:answer-postComment');
        });

        //faq
        Route::prefix('faq')->group(function () {
            Route::get('/', [FAQController::class, 'index'])->name('admin.content.faq.index')->middleware('can:read-faq');
            Route::get('/create', [FAQController::class, 'create'])->name('admin.content.faq.create')->middleware('can:create-faq');
            Route::post('/store', [FAQController::class, 'store'])->name('admin.content.faq.store')->middleware('can:create-faq');
            Route::get('/edit/{faq}', [FAQController::class, 'edit'])->name('admin.content.faq.edit')->middleware('can:edit-faq');
            Route::put('/update/{faq}', [FAQController::class, 'update'])->name('admin.content.faq.update')->middleware('can:edit-faq');
            Route::delete('/destroy/{faq}', [FAQController::class, 'destroy'])->name('admin.content.faq.destroy')->middleware('can:delete-faq');
            Route::get('/status/{faq}', [FAQController::class, 'status'])->name('admin.content.faq.status')->middleware('can:edit-faq');
        });
        //menu
        Route::prefix('menu')->group(function () {
            Route::get('/', [MenuController::class, 'index'])->name('admin.content.menu.index')->middleware('can:read-menu');
            Route::get('/create', [MenuController::class, 'create'])->name('admin.content.menu.create')->middleware('can:create-menu');
            Route::post('/store', [MenuController::class, 'store'])->name('admin.content.menu.store')->middleware('can:create-menu');
            Route::get('/edit/{menu}', [MenuController::class, 'edit'])->name('admin.content.menu.edit')->middleware('can:edit-menu');
            Route::put('/update/{menu}', [MenuController::class, 'update'])->name('admin.content.menu.update')->middleware('can:edit-menu');
            Route::delete('/destroy/{menu}', [MenuController::class, 'destroy'])->name('admin.content.menu.destroy')->middleware('can:delete-menu');
            Route::get('/status/{menu}', [MenuController::class, 'status'])->name('admin.content.menu.status')->middleware('can:edit-menu');
        });

        //page
        Route::prefix('page')->group(function () {
            Route::get('/', [PageController::class, 'index'])->name('admin.content.page.index')->middleware('can:read-page');
            Route::get('/create', [PageController::class, 'create'])->name('admin.content.page.create')->middleware('can:create-page');
            Route::post('/store', [PageController::class, 'store'])->name('admin.content.page.store')->middleware('can:create-page');
            Route::get('/edit/{page}', [PageController::class, 'edit'])->name('admin.content.page.edit')->middleware('can:edit-page');
            Route::put('/update/{page}', [PageController::class, 'update'])->name('admin.content.page.update')->middleware('can:edit-page');
            Route::delete('/destroy/{page}', [PageController::class, 'destroy'])->name('admin.content.page.destroy')->middleware('can:delete-page');
            Route::get('/status/{page}', [PageController::class, 'status'])->name('admin.content.page.status')->middleware('can:edit-page');
        });

        //post
        Route::prefix('post')->group(function () {
            Route::get('/', [PostController::class, 'index'])->name('admin.content.post.index')->middleware('can:read-post');
            Route::get('/create', [PostController::class, 'create'])->name('admin.content.post.create')->middleware('can:create-post');
            Route::post('/store', [PostController::class, 'store'])->name('admin.content.post.store')->middleware('can:create-post');
            Route::get('/edit/{post}', [PostController::class, 'edit'])->name('admin.content.post.edit')->middleware('can:edit-post');
            Route::put('/update/{post}', [PostController::class, 'update'])->name('admin.content.post.update')->middleware('can:edit-post');
            Route::delete('/destroy/{post}', [PostController::class, 'destroy'])->name('admin.content.post.destroy')->middleware('can:delete-post');
            Route::get('/status/{post}', [PostController::class, 'status'])->name('admin.content.post.status')->middleware('can:edit-post');
            Route::get('/commentable/{post}', [PostController::class, 'commentable'])->name('admin.content.post.commentable')->middleware('can:edit-post');
        });
    });

    Route::prefix('user')->namespace('User')->group(function () {

        //admin-user
        Route::prefix('admin-user')->group(function () {
            Route::get('/', [AdminUserController::class, 'index'])->name('admin.user.admin-user.index')->middleware('can:read-admin');
            Route::get('/create', [AdminUserController::class, 'create'])->name('admin.user.admin-user.create')->middleware('can:create-admin');
            Route::post('/store', [AdminUserController::class, 'store'])->name('admin.user.admin-user.store')->middleware('can:create-admin');
            Route::get('/edit/{admin}', [AdminUserController::class, 'edit'])->name('admin.user.admin-user.edit')->middleware('can:edit-admin');
            Route::put('/update/{admin}', [AdminUserController::class, 'update'])->name('admin.user.admin-user.update')->middleware('can:edit-admin');
            Route::delete('/destroy/{admin}', [AdminUserController::class, 'destroy'])->name('admin.user.admin-user.destroy')->middleware('can:delete-admin');
            Route::get('/status/{user}', [AdminUserController::class, 'status'])->name('admin.user.admin-user.status')->middleware('can:edit-admin');
            Route::get('/activation/{user}', [AdminUserController::class, 'activation'])->name('admin.user.admin-user.activation')->middleware('can:edit-admin');
            Route::get('/role/{user}', [AdminUserController::class, 'showRole'])->name('admin.user.admin-user.role')->middleware('can:access-admin');
            Route::post('/role/{user}', [AdminUserController::class, 'storeRole'])->name('admin.user.admin-user.role.store')->middleware('can:access-admin');
            Route::get('/permission/{user}', [AdminUserController::class, 'showPermission'])->name('admin.user.admin-user.permission')->middleware('can:access-admin');
            Route::post('/permission/{user}', [AdminUserController::class, 'storePermission'])->name('admin.user.admin-user.permission.store')->middleware('can:access-admin');
        });

        //customer
        Route::prefix('customer')->group(function () {
            Route::get('/', [CustomerController::class, 'index'])->name('admin.user.customer.index')->middleware('can:read-customer');
            Route::get('/create', [CustomerController::class, 'create'])->name('admin.user.customer.create')->middleware('can:create-customer');
            Route::post('/store', [CustomerController::class, 'store'])->name('admin.user.customer.store')->middleware('can:create-customer');
            Route::get('/edit/{user}', [CustomerController::class, 'edit'])->name('admin.user.customer.edit')->middleware('can:edit-customer');
            Route::put('/update/{user}', [CustomerController::class, 'update'])->name('admin.user.customer.update')->middleware('can:edit-customer');
            Route::delete('/destroy/{user}', [CustomerController::class, 'destroy'])->name('admin.user.customer.destroy')->middleware('can:delete-customer');
            Route::get('/status/{user}', [CustomerController::class, 'status'])->name('admin.user.customer.status')->middleware('can:edit-customer');
            Route::get('/activation/{user}', [CustomerController::class, 'activation'])->name('admin.user.customer.activation')->middleware('can:edit-customer');
        });

        //role
        Route::prefix('role')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('admin.user.role.index')->middleware('can:read-role');
            Route::get('/create', [RoleController::class, 'create'])->name('admin.user.role.create')->middleware('can:create-role');
            Route::post('/store', [RoleController::class, 'store'])->name('admin.user.role.store')->middleware('can:create-role');
            Route::get('/edit/{role}', [RoleController::class, 'edit'])->name('admin.user.role.edit')->middleware('can:edit-role');
            Route::put('/update/{role}', [RoleController::class, 'update'])->name('admin.user.role.update')->middleware('can:edit-role');
            Route::delete('/destroy/{role}', [RoleController::class, 'destroy'])->name('admin.user.role.destroy')->middleware('can:delete-role');
            Route::get('/permission-form/{role}', [RoleController::class, 'PermissionForm'])->name('admin.user.role.permission-form')->middleware('can:access-admin');
            Route::put('/permission-update/{role}', [RoleController::class, 'PermissionUpdate'])->name('admin.user.role.permission-update')->middleware('can:access-admin');
        });

        //permission
        Route::prefix('permission')->group(function () {
            Route::get('/', [PermissionController::class, 'index'])->name('admin.user.permission.index')->middleware('can:read-permission');
            Route::get('/create', [PermissionController::class, 'create'])->name('admin.user.permission.create')->middleware('can:create-permission');
            Route::post('/store', [PermissionController::class, 'store'])->name('admin.user.permission.store')->middleware('can:create-permission');
            Route::get('/edit/{permission}', [PermissionController::class, 'edit'])->name('admin.user.permission.edit')->middleware('can:edit-permission');
            Route::put('/update/{permission}', [PermissionController::class, 'update'])->name('admin.user.permission.update')->middleware('can:edit-permission');
            Route::delete('/destroy/{permission}', [PermissionController::class, 'destroy'])->name('admin.user.permission.destroy')->middleware('can:delete-permission');
        });
    });


    Route::prefix('notify')->namespace('Notify')->group(function () {

        //email
        Route::prefix('email')->group(function () {
            Route::get('/', [EmailController::class, 'index'])->name('admin.notify.email.index')->middleware('can:read-email');
            Route::get('/create', [EmailController::class, 'create'])->name('admin.notify.email.create')->middleware('can:create-email');
            Route::post('/store', [EmailController::class, 'store'])->name('admin.notify.email.store')->middleware('can:create-email');
            Route::get('/edit/{email}', [EmailController::class, 'edit'])->name('admin.notify.email.edit')->middleware('can:edit-email');
            Route::put('/update/{email}', [EmailController::class, 'update'])->name('admin.notify.email.update')->middleware('can:edit-email');
            Route::delete('/destroy/{email}', [EmailController::class, 'destroy'])->name('admin.notify.email.destroy')->middleware('can:delete-email');
            Route::get('/status/{email}', [EmailController::class, 'status'])->name('admin.notify.email.status')->middleware('can:edit-email');
        });


        //email file
        Route::prefix('email-file')->group(function () {
            Route::get('/{email}', [EmailFileController::class, 'index'])->name('admin.notify.email-file.index')->middleware('can:edit-email');
            Route::get('/{email}/create', [EmailFileController::class, 'create'])->name('admin.notify.email-file.create')->middleware('can:edit-email');
            Route::post('/{email}/store', [EmailFileController::class, 'store'])->name('admin.notify.email-file.store')->middleware('can:edit-email');
            Route::get('/edit/{file}', [EmailFileController::class, 'edit'])->name('admin.notify.email-file.edit')->middleware('can:edit-email');
            Route::put('/update/{file}', [EmailFileController::class, 'update'])->name('admin.notify.email-file.update')->middleware('can:edit-email');
            Route::delete('/destroy/{file}', [EmailFileController::class, 'destroy'])->name('admin.notify.email-file.destroy')->middleware('can:edit-email');
            Route::get('/status/{file}', [EmailFileController::class, 'status'])->name('admin.notify.email-file.status')->middleware('can:edit-email');
        });

        //sms
        Route::prefix('sms')->group(function () {
            Route::get('/', [SMSController::class, 'index'])->name('admin.notify.sms.index')->middleware('can:read-sms');
            Route::get('/create', [SMSController::class, 'create'])->name('admin.notify.sms.create')->middleware('can:create-sms');
            Route::post('/store', [SMSController::class, 'store'])->name('admin.notify.sms.store')->middleware('can:create-smssms');
            Route::get('/edit/{sms}', [SMSController::class, 'edit'])->name('admin.notify.sms.edit')->middleware('can:edit-sms');
            Route::put('/update/{sms}', [SMSController::class, 'update'])->name('admin.notify.sms.update')->middleware('can:edit-sms');
            Route::delete('/destroy/{sms}', [SMSController::class, 'destroy'])->name('admin.notify.sms.destroy')->middleware('can:delete-sms');
            Route::get('/status/{sms}', [SMSController::class, 'status'])->name('admin.notify.sms.status')->middleware('can:edit-sms');
        });
    });

    Route::prefix('ticket')->namespace('Ticket')->group(function () {

        //category
        Route::prefix('category')->group(function () {
            Route::get('/', [TicketCategoryController::class, 'index'])->name('admin.ticket.category.index')->middleware('can:read-ticketCategory');
            Route::get('/create', [TicketCategoryController::class, 'create'])->name('admin.ticket.category.create')->middleware('can:create-ticketCategory');
            Route::post('/store', [TicketCategoryController::class, 'store'])->name('admin.ticket.category.store')->middleware('can:create-ticketCategory');
            Route::get('/edit/{ticketCategory}', [TicketCategoryController::class, 'edit'])->name('admin.ticket.category.edit')->middleware('can:edit-ticketCategory');
            Route::put('/update/{ticketCategory}', [TicketCategoryController::class, 'update'])->name('admin.ticket.category.update')->middleware('can:delete-ticketCategory');
            Route::delete('/destroy/{ticketCategory}', [TicketCategoryController::class, 'destroy'])->name('admin.ticket.category.destroy')->middleware('can:edit-ticketCategory');
            Route::get('/status/{ticketCategory}', [TicketCategoryController::class, 'status'])->name('admin.ticket.category.status')->middleware('can:edit-ticketCategory');
        });


        //priority
        Route::prefix('priority')->group(function () {
            Route::get('/', [TicketPriorityController::class, 'index'])->name('admin.ticket.priority.index')->middleware('can:read-ticketPriority');
            Route::get('/create', [TicketPriorityController::class, 'create'])->name('admin.ticket.priority.create')->middleware('can:create-ticketPriority');
            Route::post('/store', [TicketPriorityController::class, 'store'])->name('admin.ticket.priority.store')->middleware('can:create-ticketPriority');
            Route::get('/edit/{ticketPriority}', [TicketPriorityController::class, 'edit'])->name('admin.ticket.priority.edit')->middleware('can:edit-ticketPriority');
            Route::put('/update/{ticketPriority}', [TicketPriorityController::class, 'update'])->name('admin.ticket.priority.update')->middleware('can:edit-ticketPriority');
            Route::delete('/destroy/{ticketPriority}', [TicketPriorityController::class, 'destroy'])->name('admin.ticket.priority.destroy')->middleware('can:delete-ticketPriority');
            Route::get('/status/{ticketPriority}', [TicketPriorityController::class, 'status'])->name('admin.ticket.priority.status')->middleware('can:edit-ticketPriority');
        });


        //admin
        Route::prefix('admin')->group(function () {
            Route::get('/', [TicketAdminController::class, 'index'])->name('admin.ticket.admin.index')->middleware('can:read-ticketAdmin');
            Route::get('/set/{admin}', [TicketAdminController::class, 'set'])->name('admin.ticket.admin.set')->middleware('can:edit-ticketAdmin');
        });

        //main
        Route::get('/', [TicketController::class, 'index'])->name('admin.ticket.index')->middleware('can:read-ticket');
        Route::get('/new-tickets', [TicketController::class, 'newTickets'])->name('admin.ticket.newTickets')->middleware('can:edit-ticket');
        Route::get('/open-tickets', [TicketController::class, 'openTickets'])->name('admin.ticket.openTickets')->middleware('can:edit-ticket');
        Route::get('/close-tickets', [TicketController::class, 'closeTickets'])->name('admin.ticket.closeTickets')->middleware('can:edit-ticket');
        Route::get('/show/{ticket}', [TicketController::class, 'show'])->name('admin.ticket.show')->middleware('can:edit-ticket');
        Route::post('/answer/{ticket}', [TicketController::class, 'answer'])->name('admin.ticket.answer')->middleware('can:edit-ticket');
        Route::get('/change/{ticket}', [TicketController::class, 'change'])->name('admin.ticket.change')->middleware('can:edit-ticket');
    });

    Route::prefix('setting')->namespace('Setting')->group(function () {

        Route::get('/', [SettingController::class, 'index'])->name('admin.setting.index')->middleware('can:read-setting');
        Route::get('/edit/{setting}', [SettingController::class, 'edit'])->name('admin.setting.edit')->middleware('can:edit-setting');
        Route::put('/update/{setting}', [SettingController::class, 'update'])->name('admin.setting.update')->middleware('can:edit-setting');
        Route::delete('/destroy/{setting}', [SettingController::class, 'destroy'])->name('admin.setting.destroy')->middleware('can:edit-setting');
    });
    Route::post('/notification/read-all', [NotificationController::class, 'readAll'])->name('admin.notification.read-all');
});

Route::namespace('Auth')->group(function () {
    Route::get('login-register-form', [LoginRegisterController::class, 'loginRegisterForm'])->name('auth.customer.login-register-form');
    Route::middleware('throttle:login-register-limiter')->post('login-register', [LoginRegisterController::class, 'loginRegister'])->name('auth.customer.login-register');
    Route::get('login-confirm-form/{token}', [LoginRegisterController::class, 'logiConfirmForm'])->name('auth.customer.login-confirm-form');
    Route::middleware('throttle:login-confirm-limiter')->post('login-confirm/{token}', [LoginRegisterController::class, 'loginConfirm'])->name('auth.customer.login-confirm');
    Route::middleware('throttle:login-resend-confirm-limiter')->get('login-resend-confirm/{token}', [LoginRegisterController::class, 'loginResendConfirm'])->name('auth.customer.login-resend-confirm');
    Route::get('logout', [LoginRegisterController::class, 'logout'])->name('auth.customer.logout');
});

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/products/{productCategory?}', [HomeController::class, 'products'])->name('home.products');
Route::get('/products/{productCategory?}', [HomeController::class, 'products'])->name('home.products');

Route::namespace('Market')->group(function () {

    Route::get('/product/{product:slug}', [CustomerProductController::class, 'index'])->name('home.product.index');
    Route::get('/add-comment/{product}', [CustomerProductController::class, 'addComment'])->name('home.product.add-comment');
    Route::get('/add-favorite/{product}', [CustomerProductController::class, 'addFavorite'])->name('home.product.add-favorite');
    Route::get('/add-compare/{product}', [CustomerProductController::class, 'addCompare'])->name('home.product.add-compare');
    Route::post('/add-rate/{product}', [CustomerProductController::class, 'addRate'])->name('home.product.add-rate');
});

Route::middleware('auth')->namespace('SalesProccess')->group(function () {
    //cart
    Route::get('/cart', [CartController::class, 'cart'])->name('home.sales-proccess.cart');
    Route::post('/cart', [CartController::class, 'updateCart'])->name('home.sales-proccess.update-cart');
    Route::post('/add-to-cart/{product:slug}', [CartController::class, 'addToCart'])->name('home.sales-proccess.add-to-cart');
    Route::get('/remove-from-cart/{cartItem}', [CartController::class, 'removeFromCart'])->name('home.sales-proccess.remove-from-cart');

    Route::middleware('profile.completion')->group(function () {
        //address
        Route::get('/address-and-delivery', [AddressController::class, 'addressAndDelivery'])->name('home.sales-proccess.address-and-delivery');
        Route::post('/add-address', [AddressController::class, 'addAddress'])->name('home.sales-proccess.add-address');
        Route::post('/update-address/{address}', [AddressController::class, 'updateAddress'])->name('home.sales-proccess.update-address');
        Route::get('/get-cities/{province}', [AddressController::class, 'getCities'])->name('home.sales-proccess.get-cities');
        Route::post('/choose-address-delivery', [AddressController::class, 'chooseAddressDelivery'])->name('home.sales-proccess.choose-address-delivery');

        //payment
        Route::get('/payment', [CustomerPaymentController::class, 'payment'])->name('home.sales-proccess.payment');
        Route::post('/copan-discount', [CustomerPaymentController::class, 'copanDiscount'])->name('home.sales-proccess.copan-discount');
        Route::post('/payment-submit', [CustomerPaymentController::class, 'paymentSubmit'])->name('home.sales-proccess.payment-submit');
        Route::any('/payment-callback/{order}/{onlinePayment}', [CustomerPaymentController::class, 'paymentCallback'])->name('home.sales-proccess.payment-callback');
    });

    //profile completion
    Route::post('/profile-completion', [ProfileCompletionController::class, 'update'])->name('home.sales-proccess.profile-update');
    Route::get('/profile-completion', [ProfileCompletionController::class, 'profileCompletion'])->name('home.sales-proccess.profile-completion');
});

Route::prefix('profile')->group(
    function () {
        Route::get('/my-order', [CustomerOrderController::class, 'orders'])->name('home.profile.my-order');

        Route::get('/my-favorite', [FavoriteController::class, 'favorites'])->name('home.profile.my-favorite');
        Route::get('/my-favorite/delete/{product}', [FavoriteController::class, 'deleteFavorite'])->name('home.profile.my-favorite.delete');

        Route::get('/my-compare', [CompareController::class, 'compare'])->name('home.profile.my-compare');
        Route::get('/my-compare/{product}', [CompareController::class, 'remove'])->name('home.profile.my-compare.remove');

        Route::get('/my-profile', [ProfileController::class, 'profile'])->name('home.profile.my-profile');
        Route::put('/my-profile', [ProfileController::class, 'update'])->name('home.profile.my-profile.update');

        Route::get('/my-number', [PhoneNumberController::class, 'form'])->name('home.profile.my-number.index');
        Route::middleware('throttle:login-register-limiter')->post('/my-number', [PhoneNumberController::class, 'update'])->name('home.profile.my-number.update');
        Route::get('/my-number/confirm/{token}', [PhoneNumberController::class, 'confirmForm'])->name('home.profile.my-number.confirm-form');
        Route::middleware('throttle:login-confirm-limiter')->post('/my-number/confirm/{token}', [PhoneNumberController::class, 'confirm'])->name('home.profile.my-number.confirm');

        Route::get('/my-email', [ProfileEmailController::class, 'form'])->name('home.profile.my-email.index');
        Route::middleware('throttle:login-register-limiter')->post('/my-email', [ProfileEmailController::class, 'update'])->name('home.profile.my-email.update');
        Route::get('/my-email/confirm/{token}', [ProfileEmailController::class, 'confirmForm'])->name('home.profile.my-email.confirm-form');
        Route::middleware('throttle:login-confirm-limiter')->post('/my-email/confirm/{token}', [ProfileEmailController::class, 'confirm'])->name('home.profile.my-email.confirm');

        Route::get('/my-addresses', [CustomerAddressController::class, 'index'])->name('home.profile.my-address');

        Route::get('/my-ticket', [CustomerTicketController::class, 'index'])->name('home.profile.my-ticket');
        Route::get('my-ticket/show/{ticket}', [CustomerTicketController::class, 'show'])->name('home.profile.my-ticket.show');
        Route::post('my-ticket/answer/{ticket}', [CustomerTicketController::class, 'answer'])->name('home.profile.my-ticket.answer');
        Route::get('my-ticket/change/{ticket}', [CustomerTicketController::class, 'change'])->name('home.profile.my-ticket.change');
        Route::get('my-ticket/create', [CustomerTicketController::class, 'create'])->name('home.profile.my-ticket.create');
        Route::post('my-ticket/store', [CustomerTicketController::class, 'store'])->name('home.profile.my-ticket.store');
        Route::get('my-ticket/download/{ticket}', [CustomerTicketController::class, 'download'])->name('home.profile.my-ticket.download');
    }
);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/login', function () {
    auth()->loginUsingId(1);
});

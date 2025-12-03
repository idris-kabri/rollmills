<?php

use App\Http\Controllers\Admin\LogoutController;
use App\Livewire\Admin\Brand\Create;
use App\Livewire\Admin\Brand\Edit;
use App\Livewire\Admin\Brand\Index;
use App\Livewire\Admin\ProductAttributes\Index as ProductAttributesIndex;
use App\Livewire\Admin\ProductAttributes\Create as ProductAttributesCreate;

use App\Livewire\Admin\ProductsCategories\Index as ProductsCategoriesIndex;
use App\Livewire\Admin\ProductsCategories\Edit as ProductsCategoriesEdit;
use App\Livewire\Admin\ProductsCategories\Create as ProductsCategoriesCreate;
use App\Livewire\Admin\Settings\Index as SettingIndex;
use App\Livewire\Admin\Post\Index as Post;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\ProductAttributes\Edit as ProductAttributesEdit;

use App\Livewire\Admin\Product\Index as ProductIndex;
use App\Livewire\Admin\Product\Create as ProductCreate;
use App\Livewire\Admin\Product\Edit as ProductEdit;

use App\Livewire\Admin\Banner\Index as BannerIndex;
use App\Livewire\Admin\Banner\Create as BannerCreate;
use App\Livewire\Admin\Banner\Edit as BannerEdit;

use App\Livewire\Admin\GiftCardGroup\Index as GiftCardGroupIndex;
use App\Livewire\Admin\GiftCardItem\Index as GiftCardItemIndex;
use App\Livewire\Admin\GiftCardItem\View as GiftCardItemView;

use App\Livewire\Admin\Customers\Index as CustomerIndex;
use App\Livewire\Admin\Customers\CustomerDetail as CustomerDetail;

use App\Livewire\Admin\ContactUs\Index as ContactUs;
use App\Livewire\Admin\ContactUs\Detail as ContactUsDetail;

use App\Livewire\Admin\Transactions\Index as Transaction;
use App\Livewire\Admin\Transactions\Edit as TransactionEdit;

use App\Livewire\Admin\Profile\Index as Profile;

// Coupon
use App\Livewire\Admin\Coupon\Index as CouponIndex;
use App\Livewire\Admin\Coupon\Create as CouponCreate;
use App\Livewire\Admin\Coupon\Edit as CouponEdit;

// Offer
use App\Livewire\Admin\Offer\Index as OfferIndex;
use App\Livewire\Admin\Offer\Create as OfferCreate;
use App\Livewire\Admin\Offer\Edit as OfferEdit;
use App\Livewire\Admin\Offer\Detail as OfferDetail;

// Order
use App\Livewire\Admin\Order\Index as OrderIndex;
use App\Livewire\Admin\Order\View as OrderView;

// Order Retun
use App\Livewire\Admin\OrderItemReturn\Index as OrderItemReturnIndex;
use App\Livewire\Admin\OrderItemReturn\Create as OrderItemReturnCreate;
use App\Livewire\Admin\OrderItemReturn\View as OrderItemReturnView;

//reviews
use App\Livewire\Admin\Review\Index as reviewIndex;

//user-quotation
use App\Livewire\Admin\UserQuotation\Index as UserQuotationIndex;
use App\Livewire\Admin\UserQuotation\View as UserQuotationView;

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::match(['get', 'post'], '/', Dashboard::class)->name('dashboard');
    Route::match(['get', 'post'], '/logout', [LogoutController::class, "logout"])->name('dashboard.logout');

    //product route
    Route::prefix('/product')->name('product.')->group(function () {
        Route::get('/', ProductIndex::class)->name('index');
        Route::get('/create', ProductCreate::class)->name('create');
        Route::get('/edit/{id}', ProductEdit::class)->name('edit');
    });

    //Product Attributes route
    Route::prefix('/product-attributes')->name('product-attributes.')->group(function () {
        Route::get('/', ProductAttributesIndex::class)->name('index');
        Route::get('/create', ProductAttributesCreate::class)->name('create');
        Route::get('/edit/{id}', ProductAttributesEdit::class)->name('edit');
    });
    // Products Categories
    Route::prefix('/products-categories')->name('products-categories.')->group(function () {
        Route::get('/', ProductsCategoriesIndex::class)->name("index");
        Route::get('/create', ProductsCategoriesCreate::class)->name("create");
        Route::get('/edit/{id}', ProductsCategoriesEdit::class)->name("edit");
    });

    //brand route
    Route::prefix('/brand')->name('brand.')->group(function () {
        Route::match(['get', 'post'], '/', Index::class)->name('index');
        Route::get('/create', Create::class)->name('create');
        Route::post('/store', [Create::class, 'create'])->name('store');
        Route::get('/edit/{id}', Edit::class)->name('edit');
    });

    //settings
    Route::prefix('/settings')->name('settings.')->group(function () {
        Route::get('/', SettingIndex::class)->name('index');
    });

    // post routes
    Route::prefix('/post')->name('post.')->group(function () {
        Route::match(['get', 'post'], '/', Post::class)->name('index');
    });

    // banner routes
    Route::prefix('/banner')->name('banner.')->group(function () {
        Route::match(['get', 'post'], '/', BannerIndex::class)->name('index');
        Route::get('/create', BannerCreate::class)->name('create');
        Route::get('/edit/{id}', BannerEdit::class)->name('edit');
    });

    // customer routes
    Route::prefix('/customer')->name('customer.')->group(function () {
        Route::match(['get', 'post'], '/', CustomerIndex::class)->name('index');
        Route::match(['get', 'post'], '/customer-detail/{id}', CustomerDetail::class)->name('customer-detail');
    });

    Route::prefix('/contact-us')->name('contact.us.')->group(function () {
        Route::match(['get', 'post'], '/', ContactUs::class)->name('index');
        Route::match(['get', 'post'], '/customer-detail/{id}', ContactUsDetail::class)->name('customer-detail');
    });

    // gift card routes
    Route::prefix('/gift-cards')->name('gift-card.')->group(function () {
        Route::match(['get', 'post'], '/', GiftCardGroupIndex::class)->name('index');
    });

    // gift card items routes
    Route::prefix('/gift-card-items')->name('gift-card-items.')->group(function () {
        Route::match(['get', 'post'], '/{id}', GiftCardItemIndex::class)->name('index');
        Route::get('view/{id}', GiftCardItemView::class)->name('view');
    });

    // payments transaction route
    Route::prefix('/transaction')->name('transaction.')->group(function () {
        Route::match(['get', 'post'], '/', Transaction::class)->name('index');
        Route::match(['get', 'post'], '/edit/{id}', TransactionEdit::class)->name('edit');
    });

    Route::prefix('/profile')->name('profile.')->group(function () {
        Route::match(['get', 'post'], '/{id}', Profile::class)->name('index');
    });

    //Coupon route
    Route::prefix('/coupon')->name('coupon.')->group(function () {
        Route::get('/', CouponIndex::class)->name('index');
        Route::get('/create', CouponCreate::class)->name('create');
        Route::get('/edit/{id}', CouponEdit::class)->name('edit');
    });

    //Offer route
    Route::prefix('/offer')->name('offer.')->group(function () {
        Route::get('/', OfferIndex::class)->name('index');
        Route::get('/create', OfferCreate::class)->name('create');
        Route::get('/edit/{id}', OfferEdit::class)->name('edit');
        Route::match(['get', 'post'], '/detail/{id}', OfferDetail::class)->name('detail');
    });

    //orders route 
    Route::prefix('/orders')->name('orders.')->group(function () {
        Route::get('/', OrderIndex::class)->name('index');
        Route::get('/view/{id}', OrderView::class)->name('view');
    });

    //orders return 
    Route::prefix('/order-return')->name('order-return.')->group(function () {
        Route::get('/', OrderItemReturnIndex::class)->name('index');
        Route::get('/create', OrderItemReturnCreate::class)->name('create');
        Route::get('/view/{id}', OrderItemReturnView::class)->name('view');
    });

    //review route 
    Route::prefix('/reviews')->name('reviews.')->group(function () {
        Route::get('/', reviewIndex::class)->name('index');
    });

    //review route 
    Route::prefix('user-quotation')->name('user-quotation.')->group(function () {
        Route::get('/', UserQuotationIndex::class)->name('index');
        Route::get('/view/{id}', UserQuotationView::class)->name('view');
    });
});

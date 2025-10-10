<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\LoginComponent;
use App\Livewire\Auth\RegisterComponent;
use App\Livewire\User\HomeComponent;
use App\Livewire\User\AboutComponent;
use App\Livewire\User\AccountComponent;
use App\Livewire\User\ContactComponent;
use App\Livewire\User\PrivacyPolicyComponent;
use App\Livewire\User\TermsComponent;
use App\Livewire\User\CartComponent;
use App\Livewire\User\CheckoutComponent;
use App\Livewire\User\CompareComponent;
use App\Livewire\User\ShopComponent;
use App\Livewire\User\ShopDetailComponent;
use App\Livewire\User\WishlistComponent;

Route::get('/', HomeComponent::class)->name('home');
Route::get('/about', AboutComponent::class)->name('about');
Route::get('/my-account', AccountComponent::class)->name('my-account');
Route::get('/contact', ContactComponent::class)->name('contact');
Route::get('/privacy-policy', PrivacyPolicyComponent::class)->name('privacy-policy');
Route::get('/terms', TermsComponent::class)->name('terms');
Route::get('/cart', CartComponent::class)->name('cart');
Route::get('/checkout', CheckoutComponent::class)->name('checkout');
Route::get('/compare', CompareComponent::class)->name('compare');
Route::get('/shop', ShopComponent::class)->name('shop');
Route::get('/shop-detail', ShopDetailComponent::class)->name('shop-detail');
Route::get('/wishlist', WishlistComponent::class)->name('wishlist');

Route::get('/login', LoginComponent::class)->name('login');
Route::get('/register', RegisterComponent::class)->name('register');
@include('admin.php');
<div class="section p-4 text-center" style="border-radius:12px;">
    <div class="no-record-img d-flex justify-content-center">
        <img src="assets/frontend/imgs/page/output-onlinepngtools__4_-removebg-preview.png" alt="No data"
            class="img-fluid mx-auto my-4" />
    </div>
    @if (request()->routeIs('cart'))
        <h4 class="font2">No Items In Your Cart !!</h4>
    @elseif (request()->routeIs('wishlist'))
        <h4 class="font2">No Item In Your Wishlist !!</h4>
    @else
        <h4 class="font2">No Item Found !!</h4>
    @endif

    <a href="/shop" class="btn btn-brand mt-4 d-inline-flex align-items-center px-4 py-2 mb-4"
        style="border-radius: 50px;">
        <i class="fi-rs-shopping-cart me-2"></i>
        Continue Shopping
    </a>
</div>

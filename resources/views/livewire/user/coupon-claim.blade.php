<main class="main pages">
    <div class="page-content pt-50 pb-30">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-11 m-auto">
                    {{-- <div class="content mb-60">
                        <h1 class="title style-3 mb-20 text-center">Coupon Claim</h1>
                    </div> --}}
                    <div class="coupon-card p-4 text-center">
                        <h1 class="title-bg">OFFER</h1>
                        <h2 class="offer-title text-uppercase mt-35 text-center">Roll into Savings with <br> <span
                                class="fw-900">Roll Mills!</span></h2>
                        <div class="discount-amount fw-600 text-secondary mt-2 fs-18 mb-4">
                            Congratulations! You've unlocked a ₹200 discount on your next purchase. <br>
                            <span>Keep the savings rolling with Roll Mills!</span>
                        </div>
                        <div class="result-display mt-0">
                            <p id="copyCodeBtn" class="position-absolute end-0 top-0 fs-12 copy-code">Copy Code</p>
                            <p id="couponCode" class="result-numbers">MUSTAFA200</p>
                        </div>

                        <p class="discount-amount fw-600 text-secondary mt-4 fs-16 fst-italic">Use this code on checkout
                            and
                            let the deals roll your way!</p>
                        <div class="row">
                            <div class="col-12">
                                <h5 class="mt-3 fs-24 text-brand">Terms & Conditions</h5>
                            </div>
                            <div class="col-lg-6">
                                <ul class="terms-list text-muted small text-start mt-3 mx-auto">
                                    <li>Valid only on Roll Mills’ official website.</li>
                                    <li>Coupon code ROLL200 must be applied at checkout.</li>
                                    <li>Minimum purchase of ₹1000 required to avail discount.</li>

                                </ul>
                            </div>
                            <div class="col-lg-6">
                                <ul class="terms-list text-muted small text-start mt-lg-3 mt-0 mx-auto">

                                    <li>Non-transferable and cannot be redeemed for cash.</li>
                                    <li>Offer valid till 30 November 2025 or while stocks last.</li>
                                    <li>Roll Mills reserves the right to modify or cancel the offer anytime.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-lg mb-30 mt-50">
        <div class="row">
            <div class="col-xl-11 col-lg-12 m-auto">
                <div class="content mb-50">
                    <h1 class="title style-3 mb-20 text-center">Your Order List</h1>
                    <h6 class="text-body text-center">There are <span class="text-brand">5</span> products in this list
                    </h6>
                </div>
                {{-- <div class="mb-50">
                    <h1 class="heading-2 mb-10">Your Wishlist</h1>
                </div> --}}
                <div class="table-responsive shopping-summery table-responsive-custom">
                    <table class="table table-wishlist mb-0">
                        <thead>
                            <tr class="main-heading">
                                <th scope="col" class="custome-checkbox start pl-20">
                                    Order ID
                                </th>
                                <th scope="col">Product(s)</th>
                                <th scope="col">Total Amount</th>
                                <th scope="col">Date Purchased</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="pt-30">
                                <td class="custome-checkbox pl-30">
                                    <p class="small-screen-table-index">1</p>
                                </td>
                                <td class="product-des product-name">
                                    <h5 class="mb-3 fs-18 underline">Product List</h5>
                                    <div class="mb-2 order-list-divider">
                                        <h6>
                                            <a class="product-name hover-a fw-600 fs-15 mb-10" href="/shop-detail">1.
                                                Field Roast Chao Cheese Creamy Original
                                                <span class="ms-2 fs-12 fw-600 px-1 bg-light border border-2 rounded-3 quicksand mt-2">x2</span>
                                            </a>
                                        </h6>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>
                                    </div>
                                    <div class="mb-2 order-list-divider">
                                        <h6>
                                             <a class="product-name hover-a fw-600 fs-15 mb-10" href="/shop-detail">2.
                                                Field Roast Chao Cheese Creamy Original
                                                <span class="ms-2 fs-12 fw-600 px-1 bg-light border border-2 rounded-3 quicksand mt-2">x2</span>
                                            </a>
                                        </h6>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>
                                    </div>
                                    <div class="mb-2 order-list-divider">
                                        <h6>
                                            <a class="product-name hover-a fw-600 fs-15 mb-10" href="/shop-detail">3.
                                                Field Roast Chao Cheese Creamy Original
                                                <span class="ms-2 fs-12 fw-600 px-1 bg-light border border-2 rounded-3 quicksand mt-2">x2</span>
                                            </a>
                                        </h6>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="price small-screen-table-td" data-title="Price">
                                    <h3 class="text-brand small-screen-table-td-content">$2.51</h3>
                                </td>
                                <td class="detail-info small-screen-table-td" data-title="Date Purchased">
                                    <p class="fs-17 fw-700 small-screen-table-td-content">23 / 5 / 25</p>
                                </td>
                                <td class="text-right">
                                    <button class="btn btn-sm custom-btn-table-responsive">Avail Coupon</button>
                                </td>
                            </tr>
                            <tr class="pt-30">
                                <td class="custome-checkbox pl-30">
                                    <p class="small-screen-table-index">1</p>
                                </td>
                                <td class="product-des product-name">
                                    <h5 class="mb-3 fs-18 underline">Product List</h5>
                                    <div class="mb-2 order-list-divider">
                                        <h6>
                                            <a class="product-name hover-a fw-600 fs-15 mb-10" href="/shop-detail">1.
                                                Field Roast Chao Cheese Creamy Original
                                                <span class="ms-2 fs-12 fw-600 px-1 bg-light border border-2 rounded-3 quicksand mt-2">x2</span>
                                            </a>
                                        </h6>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>
                                    </div>
                                    <div class="mb-2 order-list-divider">
                                        <h6>
                                             <a class="product-name hover-a fw-600 fs-15 mb-10" href="/shop-detail">2.
                                                Field Roast Chao Cheese Creamy Original
                                                <span class="ms-2 fs-12 fw-600 px-1 bg-light border border-2 rounded-3 quicksand mt-2">x2</span>
                                            </a>
                                        </h6>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>
                                    </div>
                                    <div class="mb-2 order-list-divider">
                                        <h6>
                                            <a class="product-name hover-a fw-600 fs-15 mb-10" href="/shop-detail">3.
                                                Field Roast Chao Cheese Creamy Original
                                                <span class="ms-2 fs-12 fw-600 px-1 bg-light border border-2 rounded-3 quicksand mt-2">x2</span>
                                            </a>
                                        </h6>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="price small-screen-table-td" data-title="Price">
                                    <h3 class="text-brand small-screen-table-td-content">$2.51</h3>
                                </td>
                                <td class="detail-info small-screen-table-td" data-title="Date Purchased">
                                    <p class="fs-17 fw-700 small-screen-table-td-content">23 / 5 / 25</p>
                                </td>
                                <td class="text-right">
                                    <button class="btn btn-sm custom-btn-table-responsive">Avail Coupon</button>
                                </td>
                            </tr>
                            <tr class="pt-30">
                                <td class="custome-checkbox pl-30">
                                    <p class="small-screen-table-index">1</p>
                                </td>
                                <td class="product-des product-name">
                                    <h5 class="mb-3 fs-18 underline">Product List</h5>
                                    <div class="mb-2 order-list-divider">
                                        <h6>
                                            <a class="product-name hover-a fw-600 fs-15 mb-10" href="/shop-detail">1.
                                                Field Roast Chao Cheese Creamy Original
                                                <span class="ms-2 fs-12 fw-600 px-1 bg-light border border-2 rounded-3 quicksand mt-2">x2</span>
                                            </a>
                                        </h6>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>
                                    </div>
                                    <div class="mb-2 order-list-divider">
                                        <h6>
                                             <a class="product-name hover-a fw-600 fs-15 mb-10" href="/shop-detail">2.
                                                Field Roast Chao Cheese Creamy Original
                                                <span class="ms-2 fs-12 fw-600 px-1 bg-light border border-2 rounded-3 quicksand mt-2">x2</span>
                                            </a>
                                        </h6>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>
                                    </div>
                                    <div class="mb-2 order-list-divider">
                                        <h6>
                                            <a class="product-name hover-a fw-600 fs-15 mb-10" href="/shop-detail">3.
                                                Field Roast Chao Cheese Creamy Original
                                                <span class="ms-2 fs-12 fw-600 px-1 bg-light border border-2 rounded-3 quicksand mt-2">x2</span>
                                            </a>
                                        </h6>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="price small-screen-table-td" data-title="Price">
                                    <h3 class="text-brand small-screen-table-td-content">$2.51</h3>
                                </td>
                                <td class="detail-info small-screen-table-td" data-title="Date Purchased">
                                    <p class="fs-17 fw-700 small-screen-table-td-content">23 / 5 / 25</p>
                                </td>
                                <td class="text-right">
                                    <button class="btn btn-sm custom-btn-table-responsive">Avail Coupon</button>
                                </td>
                            </tr>
                            <tr class="pt-30">
                                <td class="custome-checkbox pl-30">
                                    <p class="small-screen-table-index">1</p>
                                </td>
                                <td class="product-des product-name">
                                    <h5 class="mb-3 fs-18 underline">Product List</h5>
                                    <div class="mb-2 order-list-divider">
                                        <h6>
                                            <a class="product-name hover-a fw-600 fs-15 mb-10" href="/shop-detail">1.
                                                Field Roast Chao Cheese Creamy Original
                                                <span class="ms-2 fs-12 fw-600 px-1 bg-light border border-2 rounded-3 quicksand mt-2">x2</span>
                                            </a>
                                        </h6>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>
                                    </div>
                                    <div class="mb-2 order-list-divider">
                                        <h6>
                                             <a class="product-name hover-a fw-600 fs-15 mb-10" href="/shop-detail">2.
                                                Field Roast Chao Cheese Creamy Original
                                                <span class="ms-2 fs-12 fw-600 px-1 bg-light border border-2 rounded-3 quicksand mt-2">x2</span>
                                            </a>
                                        </h6>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>
                                    </div>
                                    <div class="mb-2 order-list-divider">
                                        <h6>
                                            <a class="product-name hover-a fw-600 fs-15 mb-10" href="/shop-detail">3.
                                                Field Roast Chao Cheese Creamy Original
                                                <span class="ms-2 fs-12 fw-600 px-1 bg-light border border-2 rounded-3 quicksand mt-2">x2</span>
                                            </a>
                                        </h6>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="price small-screen-table-td" data-title="Price">
                                    <h3 class="text-brand small-screen-table-td-content">$2.51</h3>
                                </td>
                                <td class="detail-info small-screen-table-td" data-title="Date Purchased">
                                    <p class="fs-17 fw-700 small-screen-table-td-content">23 / 5 / 25</p>
                                </td>
                                <td class="text-right">
                                    <button class="btn btn-sm custom-btn-table-responsive">Avail Coupon</button>
                                </td>
                            </tr>
                            <tr class="pt-30">
                                <td class="custome-checkbox pl-30">
                                    <p class="small-screen-table-index">1</p>
                                </td>
                                <td class="product-des product-name">
                                    <h5 class="mb-3 fs-18 underline">Product List</h5>
                                    <div class="mb-2 order-list-divider">
                                        <h6>
                                            <a class="product-name hover-a fw-600 fs-15 mb-10" href="/shop-detail">1.
                                                Field Roast Chao Cheese Creamy Original
                                                <span class="ms-2 fs-12 fw-600 px-1 bg-light border border-2 rounded-3 quicksand mt-2">x2</span>
                                            </a>
                                        </h6>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>
                                    </div>
                                    <div class="mb-2 order-list-divider">
                                        <h6>
                                             <a class="product-name hover-a fw-600 fs-15 mb-10" href="/shop-detail">2.
                                                Field Roast Chao Cheese Creamy Original
                                                <span class="ms-2 fs-12 fw-600 px-1 bg-light border border-2 rounded-3 quicksand mt-2">x2</span>
                                            </a>
                                        </h6>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>
                                    </div>
                                    <div class="mb-2 order-list-divider">
                                        <h6>
                                            <a class="product-name hover-a fw-600 fs-15 mb-10" href="/shop-detail">3.
                                                Field Roast Chao Cheese Creamy Original
                                                <span class="ms-2 fs-12 fw-600 px-1 bg-light border border-2 rounded-3 quicksand mt-2">x2</span>
                                            </a>
                                        </h6>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="price small-screen-table-td" data-title="Price">
                                    <h3 class="text-brand small-screen-table-td-content">$2.51</h3>
                                </td>
                                <td class="detail-info small-screen-table-td" data-title="Date Purchased">
                                    <p class="fs-17 fw-700 small-screen-table-td-content">23 / 5 / 25</p>
                                </td>
                                <td class="text-right">
                                    <button class="btn btn-sm custom-btn-table-responsive">Avail Coupon</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

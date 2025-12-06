<div>
    <!-- PAGE TITLE -->
    <div class="section-title mt-4 mx-3 px-3">
        <h3 class="m-0 fw-bold">All Categories</h3>
    </div>

    <!-- PARENT CATEGORY CARDS -->
    <div class="row justify-content-center mt-4 px-3">

        @foreach ($parentCategories as $cat)
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 mb-3 px-2">
                <div class="card shadow-sm border-0 text-center p-3 rounded-4 h-100">

                    <!-- Category Image -->
                    <img src="{{ asset('storage/' . $cat->image) }}" class="w-100 rounded mb-2"
                         style="height:130px; object-fit:cover;">

                    <!-- Name -->
                    <h5 class="fs-15 mb-3 fw-semibold">{{ $cat->name }}</h5>

                    <!-- Buttons -->
                    <div class="d-grid gap-2">
                        <a href="/shop?category_id={{ $cat->id }}"
                           class="btn btn-sm btn-primary">
                            View All Products
                        </a>

                        <button class="btn btn-sm btn-outline-primary"
                                wire:click="selectParent({{ $cat->id }})">
                            View Sub Categories
                        </button>
                    </div>

                </div>
            </div>
        @endforeach

    </div>


    <!-- SUB CATEGORY LIST -->
    @if ($selectedParent)
        <h4 class="px-4 mt-4 fw-bold">Sub Categories</h4>

        <div class="row px-4 mt-3">

            @foreach ($subCategories as $sub)
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 mb-3 px-2">
                    <a href="/shop?category_id={{ $sub->id }}" class="text-decoration-none">

                        <div class="card shadow-sm border rounded-4 p-3 
                                    text-center h-100 d-flex align-items-center justify-content-center">

                            <h6 class="text-dark fw-semibold m-0">{{ $sub->name }}</h6>
                        </div>

                    </a>
                </div>
            @endforeach

        </div>
    @endif

</div>

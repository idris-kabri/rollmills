<main class="main pages">
    <div class="page-content pt-130">
        <div class="section">
            <div class="container">
                <div class="row justify-content-center pb-130">
                    <div class="col-md-8">
                        <div class="text-center order_complete">

                            <i class="fas fa-check-circle" style="font-size:70px; color:#28a745;"></i>

                            <div class="heading_s1 mt-20">
                                <h3>Thank You for Shopping With Us!</h3>
                            </div>

                            <p class="mt-10" style="font-size:18px;">
                                Your order has been successfully placed.  
                                <br>
                                <strong>Order ID: #{{ $id }}</strong>
                            </p>

                            <p>Your order is being processed. We will update you shortly with further details.</p>

                            <a href="{{ url('/shop') }}" class="btn btn-fill-out mt-10">
                                Continue Shopping
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

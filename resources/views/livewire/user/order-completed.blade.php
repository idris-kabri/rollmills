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

                            <div class="wa-btn-container">
                                <a href="https://wa.me/918764766553?text=Hi%20Roll%20Mills,%20I%20placed%20order%20%23{{ $id }}%20and%20would%20like%20to%20receive%20updates%20here."
                                    class="btn-whatsapp-premium" target="_blank">
                                    <i class="fab fa-whatsapp"></i>
                                    <span>Get Order updates on WhatsApp</span>
                                </a>
                            </div>

                            <style>
                                /* Spacing around the button */
                                .wa-btn-container {
                                    margin: 30px 0 20px 0;
                                    display: flex;
                                    justify-content: center;
                                }

                                /* The Button Itself */
                                .btn-whatsapp-premium {
                                    display: inline-flex;
                                    align-items: center;
                                    /* Forces perfect vertical alignment */
                                    justify-content: center;
                                    background-color: #25D366;
                                    /* Official WhatsApp Green */
                                    color: #fff !important;
                                    /* Force white text */
                                    font-size: 16px;
                                    font-weight: 600;
                                    /* Semi-bold text */
                                    padding: 12px 30px;
                                    /* Generous padding for a "premium" feel */
                                    border-radius: 8px;
                                    /* Smooth rounded corners */
                                    text-decoration: none;
                                    box-shadow: 0 4px 10px rgba(37, 211, 102, 0.25);
                                    /* Attractive shadow */
                                    transition: all 0.3s ease;
                                    border: none;
                                }

                                /* The Icon Styling */
                                .btn-whatsapp-premium i {
                                    font-size: 24px;
                                    /* Large, clear icon */
                                    margin-right: 4px;
                                    /* Space between icon and text */
                                    margin-bottom: 0;
                                    /* Fixes alignment in some themes */
                                    vertical-align: middle;
                                }

                                /* Hover Effects */
                                .btn-whatsapp-premium:hover {
                                    background-color: #20bd5a;
                                    /* Slightly darker green */
                                    transform: translateY(-2px);
                                    /* Lifts up slightly */
                                    box-shadow: 0 6px 15px rgba(37, 211, 102, 0.35);
                                    /* Shadow grows */
                                    text-decoration: none;
                                    color: #fff;
                                }
                            </style>
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

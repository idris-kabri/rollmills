 <main class="main pages">
     <div class="page-header breadcrumb-wrap">
         <div class="container">
             <div class="breadcrumb">
                 <a href="/" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                 <span></span> My Account
             </div>
         </div>
     </div>
     <div class="page-content pt-40 pb-40">
         <div class="container">
             <div class="row">
                 <div class="col-lg-10 m-auto">
                     <div class="content mb-50">
                         <h1 class="title style-3 mb-20 text-center">My Account</h1>
                     </div>
                     <div class="row">
                         <div class="col-lg-4 col-md-6 col-12 mb-30">
                             <div class="my-account-cards">
                                 <a href="/user-order"
                                     class="card px-4 d-flex flex-row py-4 rounded-15 shadow-sm text-center border border-2">
                                     <div class="img-section me-4">
                                         <img src="{{ asset('assets/frontend/imgs/icon&images/checklist.png') }}"
                                             alt="" class="img-fluid mx-auto">
                                     </div>
                                     <div class="content">
                                         <h5 class="underline text-start mb-2">Your Orders</h5>
                                         <p class="fw-500 text-secondary text-start">Track, return, or buy things again
                                         </p>
                                     </div>
                                 </a>
                             </div>
                         </div>
                         <div class="col-lg-4 col-md-6 col-12 mb-30">
                             <div class="my-account-cards">
                                 <a href="/user-profile"
                                     class="card px-4 d-flex flex-row py-4 rounded-15 shadow-sm text-center border border-2">
                                     <div class="img-section me-4">
                                         <img src="{{ asset('assets/frontend/imgs/icon&images/mobile-password-forgot.png') }}"
                                             alt="" class="img-fluid mx-auto">
                                     </div>
                                     <div class="content">
                                         <h5 class="underline text-start mb-2">My Profile</h5>
                                         <p class="fw-500 text-secondary text-start">Edit profile name, and mobile
                                             number.
                                         </p>
                                     </div>
                                 </a>
                             </div>
                         </div>
                         <div class="col-lg-4 col-md-6 col-12 mb-30">
                             <div class="my-account-cards">
                                 <a href="/user-address"
                                     class="card px-4 d-flex flex-row py-4 rounded-15 shadow-sm text-center border border-2">
                                     <div class="img-section me-4">
                                         <img src="{{ asset('assets/frontend/imgs/icon&images/map.png') }}"
                                             alt="" class="img-fluid mx-auto">
                                     </div>
                                     <div class="content">
                                         <h5 class="underline text-start mb-2">Your Addresses</h5>
                                         <p class="fw-500 text-secondary text-start">Edit addresses for orders and gifts
                                         </p>
                                     </div>
                                 </a>
                             </div>
                         </div>
                         <div class="col-lg-4 col-md-6 col-12 mb-30">
                             <div class="my-account-cards">
                                 <a href="https://wa.me/918764766553?text=Hello,%20I%20need%20assistance%20regarding%20my%20account.
"
                                     class="card px-4 d-flex flex-row py-4 rounded-15 shadow-sm text-center border border-2">
                                     <div class="img-section me-4">
                                         <img src="{{ asset('assets/frontend/imgs/icon&images/whatsapp.png') }}"
                                             alt="" class="img-fluid mx-auto">
                                     </div>
                                     <div class="content">
                                         <h5 class="underline text-start mb-2">Chat Us On WhatsApp</h5>
                                         <p class="fw-500 text-secondary text-start">Get help through WhatsApp chat</p>
                                     </div>
                                 </a>
                             </div>
                         </div>
                         <div class="col-lg-4 col-md-6 col-12 mb-30">
                             <div class="my-account-cards">
                                 <a href="tel:+918764766553"
                                     class="card px-4 d-flex flex-row py-4 rounded-15 shadow-sm text-center border border-2">
                                     <div class="img-section me-4">
                                         <img src="{{ asset('assets/frontend/imgs/icon&images/virtual-assistants.png') }}"
                                             alt="" class="img-fluid mx-auto">
                                     </div>
                                     <div class="content">
                                         <h5 class="underline text-start mb-2">Call Us</h5>
                                         <p class="fw-500 text-secondary text-start">Reach our support team by phone</p>
                                     </div>
                                 </a>
                             </div>
                         </div>
                         <div class="col-lg-4 col-md-6 col-12 mb-30">
                             <div class="my-account-cards">
                                 <a href="mailto:rollmills.rm@gmail.com"
                                     class="card px-4 d-flex flex-row py-4 rounded-15 shadow-sm text-center border border-2">
                                     <div class="img-section me-4">
                                         <img src="{{ asset('assets/frontend/imgs/icon&images/mail.png') }}"
                                             alt="" class="img-fluid mx-auto">
                                     </div>
                                     <div class="content">
                                         <h5 class="underline text-start mb-2">Email Us</h5>
                                         <p class="fw-500 text-secondary text-start">Send us an email for assistance</p>
                                     </div>
                                 </a>
                             </div>
                         </div>
                         <div class="col-lg-4 col-md-6 col-12 mb-30">
                             <div class="my-account-cards">

                                 <a href="#" wire:confirm="Are you sure you want to logout?" wire:click.prevent="logoutUser"
                                     class="card px-4 d-flex flex-row py-4 rounded-15 shadow-sm text-center border border-2">

                                     <div class="img-section me-4">
                                         <img src="{{ asset('assets/frontend/imgs/icon&images/de072167-48fd-4d29-9074-ac4453a330be-removebg-preview.png') }}"
                                             alt="Logout" class="img-fluid mx-auto">
                                     </div>

                                     <div class="content">
                                         <h5 class="underline text-start mb-2">Logout</h5>
                                         <p class="fw-500 text-secondary text-start">Securely sign out of your account
                                         </p>
                                     </div>

                                 </a>

                             </div>
                         </div>


                     </div>
                 </div>
             </div>
         </div>
     </div>
 </main>

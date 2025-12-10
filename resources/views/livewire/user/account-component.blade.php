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
                                         <h5 class="underline text-start mb-2 justify-content-start">Your Orders</h5>
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
                                         <h5 class="underline text-start mb-2 justify-content-start">My Profile</h5>
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
                                         <h5 class="underline text-start mb-2 justify-content-start">Your Addresses</h5>
                                         <p class="fw-500 text-secondary text-start">Edit addresses for orders and gifts
                                         </p>
                                     </div>
                                 </a>
                             </div>
                         </div>
                         <div class="col-lg-4 col-md-6 col-12 mb-30">
                             <div class="my-account-cards">
                                 <a href="https://wa.me/918764766553?text=Hello,%20I%20need%20assistance%20regarding%20my%20account."
                                     class="card px-4 d-flex flex-row py-4 rounded-15 shadow-sm text-center border border-2">
                                     <div class="img-section me-4">
                                         <img src="{{ asset('assets/frontend/imgs/icon&images/whatsapp.png') }}"
                                             alt="" class="img-fluid mx-auto">
                                     </div>
                                     <div class="content">
                                         <h5 class="underline text-start mb-2 justify-content-start">Chat Us On WhatsApp
                                         </h5>
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
                                         <h5 class="underline text-start mb-2 justify-content-start">Call Us</h5>
                                         <p class="fw-500 text-secondary text-start">Reach our support team by phone</p>
                                     </div>
                                 </a>
                             </div>
                         </div>
                         <div class="col-lg-4 col-md-6 col-12 mb-30">
                             <div class="my-account-cards">
                                 <a href="mailto:info@rollmills.store"
                                     class="card px-4 d-flex flex-row py-4 rounded-15 shadow-sm text-center border border-2">
                                     <div class="img-section me-4">
                                         <img src="{{ asset('assets/frontend/imgs/icon&images/mail.png') }}"
                                             alt="" class="img-fluid mx-auto">
                                     </div>
                                     <div class="content">
                                         <h5 class="underline text-start mb-2 justify-content-start">Email Us</h5>
                                         <p class="fw-500 text-secondary text-start">Send us an email for assistance</p>
                                     </div>
                                 </a>
                             </div>
                         </div>
                         <div class="col-lg-4 col-md-6 col-12 mb-30">
                             <div class="my-account-cards">
                                 <a href="#" data-bs-toggle="modal" data-bs-target="#ConfirmActionModal"
                                     {{-- wire:click.prevent="logoutUser" --}}
                                     class="card px-4 d-flex flex-row py-4 rounded-15 shadow-sm text-center border border-2">
                                     <div class="img-section me-4">
                                         <img src="{{ asset('assets/frontend/imgs/icon&images/layoff.png') }}"
                                             alt="Logout" class="img-fluid mx-auto">
                                     </div>
                                     <div class="content">
                                         <h5 class="underline text-start mb-2 justify-content-start">Logout</h5>
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
     {{-- Logout Model Start --}}
     <div class="modal fade" id="ConfirmActionModal" tabindex="-1" aria-labelledby="ConfirmActionModal"
         aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered">
             <div class="modal-content-custom w-100">
                 <div class="mb-4">
                     <div class="d-flex justify-content-center">
                         {{-- <img src="{{ asset('assets/frontend/imgs/icon&images/complain.png') }}" alt=""
                             class="img-fluid mb-3 mt-4 modal-logo" style="width: 80px; height: 80px" /> --}}
                         <img src="{{ asset('assets/frontend/imgs/icon&images/de072167-48fd-4d29-9074-ac4453a330be-removebg-preview.png') }}"
                             alt="" class="img-fluid mb-3 mt-4 modal-logo" />
                     </div>
                     <div class="modal-body p-0 d-flex justify-content-center text-center">
                         <h1 class="fs-3 mb-2">Are you Sure?</h1>
                     </div>
                     <p class="fs-6 mx-auto text-center w-md-75 w-75 quicksand">
                         Are you Sure you want to Logout? This Action cannot be Undone.
                     </p>
                 </div>
                 <div class="pb-4 d-flex flex-column justify-content-center">
                     <button type="submit" class="btn mb-3 w-90-per pt-10 pb-10" wire:click.prevent="logoutUser">
                         Logout
                     </button>
                     <button type="button" class="btn btn-brand-outline mx-auto pt-10 pb-10 w-90-per"
                         data-bs-dismiss="modal" id="close-confirm-action-btn">
                         Cancel
                     </button>
                 </div>
             </div>
         </div>
     </div>
     {{-- Logout Model End --}}
 </main>

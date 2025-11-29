 <main class="main pages">
     <div class="page-header breadcrumb-wrap">
         <div class="container">
             <div class="breadcrumb">
                 <a href="/" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                 <span></span> <a href="/my-account">My Account</a> <span></span> Address
             </div>
         </div>
     </div>
     <div class="page-content pt-50 pb-50">
         <div class="container">
             <div class="row">
                 <div class="col-xl-10 col-lg-10 m-auto">
                     <div class="content mb-50">
                         <h1 class="title style-3 mb-20 text-center">Address</h1>
                     </div>
                     <div class="row">
                        @foreach ($addresses as $key=>$address)
                        <div class="col-lg-4 py-2 mb-4">
                            <div class="card address-cards border-2 p-4 rounded-15">
                                <div class="heading mb-15">
                                    <h5 class="underline pb-2 mb-3 d-flex align-items-center">
                                        Address {{ $key+1 }}
                                        @if($address->is_default == 1)
                                        <span class="text-muted fw-400 fs-13 ms-3">
                                            (Default)
                                        </span>
                                        @endif
                                    </h5>
                                </div>
                                <div class="address-details mb-3">
                                    <div class="align-items-center flex-wrap mb-1">
                                        <span class="me-2 text-muted fw-600 fs-15 quicksand">
                                            Name :
                                        </span>
                                        <span class="text-heading fw-600 fs-15 quicksand">
                                            {{ $address->name }}
                                        </span>
                                    </div>
                                    <div class="align-items-center flex-wrap mb-1">
                                        <span class="me-2 text-muted fw-600 fs-15 quicksand">
                                            Mobile :
                                        </span>
                                        <span class="text-heading fw-600 fs-15 quicksand">
                                            +91 {{ $address->mobile }}
                                        </span>
                                    </div>
                                    <div class="align-items-center flex-wrap mb-1">
                                        <span class="me-2 text-muted fw-600 fs-15 quicksand">
                                            State :
                                        </span>
                                        <span class="text-heading fw-600 fs-15 quicksand">
                                            {{ $address->state }}
                                        </span>
                                    </div>
                                    <div class="align-items-center flex-wrap mb-1">
                                        <span class="me-2 text-muted fw-600 fs-15 quicksand">
                                            Pincode :
                                        </span>
                                        <span class="text-heading fw-600 fs-15 quicksand">
                                            {{ $address->zipcode }}
                                        </span>
                                    </div>
                                    <div class="align-items-center flex-wrap mb-1">
                                        <span class="me-2 text-muted fw-600 fs-15 quicksand">
                                            Address :
                                        </span>
                                        <span class="text-heading fw-600 fs-15 quicksand">
                                            {{ $address->address_line_1 }} {{ $address->address_line_2 }}
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span
                                        class="border rounded-pill px-2 pt-5 pb-5 fs-13 text-white fw-600 quicksand d-flex align-items-center btn btn-sm hover-a me-2">
                                        <i
                                            class="fi fi-rs-edit me-1 d-flex justify-content-center align-items-center"></i>Edit</span>
                                    <a href="#" wire:click.prevent="deleteAddress({{ $address->id }})" wire:confirm="Are you sure you want to delete this address?"
                                        class="border rounded-pill px-2 pt-5 pb-5 fs-13 text-white fw-600 quicksand d-flex align-items-center btn btn-sm hover-a me-2">
                                        <i
                                            class="fi fi-rs-trash me-1 d-flex justify-content-center align-items-center"></i>Delete</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                         <div class="col-lg-4 py-2 mb-4">
                             <a href="#" wire:click.prevent="add_address()"
                                 class="card address-cards h-100 add-address border-2 p-4 rounded-15 d-flex justify-content-center align-items-center">
                                 <i class="fa-solid fa-plus fa-4x text-muted"></i>
                                 <h5 class="text-muted fw-700 mt-3">
                                     Add Address
                                 </h5>
                             </a>
                         </div>
                     </div>
                     @if($show_addres)
                     <form method="post">
                         <div class="row mt-20 pt-lg-5">
                             <div class="content mb-20">
                                 <h1 class="title style-3 mb-20 text-center">Add Address</h1>
                             </div>
                             <div class="col-md-6 col-lg-4">
                                 <div class="form-group mb-25">
                                     <label for=""
                                         class="ps-1 text-secondary fw-700 quicksand fs-16 mb-1">Name</label>
                                     <input type="text" placeholder="Enter Your Name" required
                                         class="login-input2" />
                                 </div>
                             </div>
                             <div class="col-md-6 col-lg-4">
                                 <div class="form-group mb-25">
                                     <label for=""
                                         class="ps-1 text-secondary fw-700 quicksand fs-16 mb-1">Email</label>
                                     <input type="email" placeholder="Enter Your Name" required
                                         class="login-input2" />
                                 </div>
                             </div>
                             <div class="col-md-6 col-lg-4">
                                 <div class="form-group mb-25">
                                     <label for=""
                                         class="ps-1 text-secondary fw-700 quicksand fs-16 mb-1">Mobile
                                         Number</label>
                                     <input type="text" placeholder="Enter Your Number" required
                                         class="login-input2" />
                                 </div>
                             </div>
                             <div class="col-md-6 col-lg-4">
                                 <div class="form-group mb-25">
                                     <label for=""
                                         class="ps-1 text-secondary fw-700 quicksand fs-16 mb-1">State</label>
                                     <input type="text" placeholder="Enter Your State Name" class="login-input2" />
                                 </div>
                             </div>
                             <div class="col-md-6 col-lg-4">
                                 <div class="form-group mb-25">
                                     <label for=""
                                         class="ps-1 text-secondary fw-700 quicksand fs-16 mb-1">City</label>
                                     <input type="text" placeholder="Enter Your Locality / Town"
                                         class="login-input2" />
                                 </div>
                             </div>
                             <div class="col-md-6 col-lg-4">
                                 <div class="form-group mb-25">
                                     <label for=""
                                         class="ps-1 text-secondary fw-700 quicksand fs-16 mb-1">Pincode</label>
                                     <input type="text" placeholder="Enter Your Pincode" required
                                         class="login-input2" />
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="form-group mb-25">
                                     <label for=""
                                         class="ps-1 text-secondary fw-700 quicksand fs-16 mb-1">Address
                                         1</label>
                                     <textarea class="login-input2" placeholder="Enter You Adrress 1" id="floatingTextarea1" style="min-height: 150px"></textarea>
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="form-group mb-25">
                                     <label for=""
                                         class="ps-1 text-secondary fw-700 quicksand fs-16 mb-1">Address
                                         2</label>
                                     <textarea class="login-input2" placeholder="Enter You Adrress 2" id="floatingTextarea2" style="min-height: 150px"></textarea>
                                 </div>
                             </div>
                         </div>
                         <div class="form-group mt-3 d-flex justify-content-center">
                             <button type="submit"
                                 class="btn quicksand fw-600 btn-block fs-18 pt-10 pb-10  hover-up hover-brand"
                                 name="login">Add Address</button>
                         </div>
                     </form>
                     @endif
                 </div>
             </div>
         </div>
     </div>
 </main>

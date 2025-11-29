 <main class="main pages">
     <div class="page-header breadcrumb-wrap">
         <div class="container">
             <div class="breadcrumb">
                 <a href="/" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                 <span></span> <a href="/my-account">My Account</a> <span></span> Profile
             </div>
         </div>
     </div>
     <div class="page-content pt-50 pb-50">
         <div class="container">
             <div class="row">
                 <div class="col-xl-8 col-lg-10 m-auto">
                     <div class="content mb-50">
                         <h1 class="title style-3 mb-20 text-center">Profile</h1>
                     </div>
                     <div class="row">
                         <div class="col-lg-3 py-2 mb-4">
                             <div class="img-section rounded-pill border border-1 p-1 overflow-hidden mb-2 mx-auto border-brand"
                                 style="height: 170px; width: 170px">

                                 {{-- If new image uploaded, show preview --}}
                                 @if ($new_profile_image)
                                     <img src="{{ $new_profile_image->temporaryUrl() }}" class="img-fluid rounded-pill"
                                         style="object-fit: cover">

                                     {{-- If user already has saved image --}}
                                 @elseif($profile_image)
                                     <img src="{{ asset('storage/' . $profile_image) }}" class="img-fluid rounded-pill"
                                         style="object-fit: cover">

                                     {{-- Default image --}}
                                 @else
                                     <img src="{{ asset('assets\frontend\imgs\icon&images\profile-removebg-preview.png') }}"
                                         class="img-fluid rounded-pill" style="object-fit: cover">
                                 @endif
                             </div>

                             <label
                                 class="fw-600 text-center justify-content-center d-flex fs-16 align-items-center gap-1"
                                 style="cursor: pointer">
                                 Change Profile Image <i class="fa-solid fa-pen-to-square"></i>

                                 <input type="file" accept=".png, .jpg, .jpeg, .webp" wire:model="new_profile_image" class="d-none">
                             </label>

                             @error('new_profile_image')
                                 <small class="text-danger">{{ $message }}</small>
                             @enderror
                         </div>
                         <div class="col-lg-9 px-lg-4">
                             <form wire:submit.prevent="updateUser">

                                 <div class="row">
                                     <div class="col-md-6">
                                         <div class="form-group mb-20">
                                             <label class="ps-1 text-muted fw-600 quicksand fs-16 mb-1">Name</label>
                                             <input type="text" wire:model="name" class="login-input2" />
                                             @error('name')
                                                 <small class="text-danger">{{ $message }}</small>
                                             @enderror
                                         </div>
                                     </div>

                                     <div class="col-md-6">
                                         <div class="form-group mb-20">
                                             <label class="ps-1 text-muted fw-600 quicksand fs-16 mb-1">Email</label>
                                             <input type="email" wire:model="email" class="login-input2" />
                                             @error('email')
                                                 <small class="text-danger">{{ $message }}</small>
                                             @enderror
                                         </div>
                                     </div>

                                     <div class="col-md-6">
                                         <div class="form-group mb-20">
                                             <label class="ps-1 text-muted fw-600 quicksand fs-16 mb-1">Mobile
                                                 Number</label>
                                             <input type="text" readonly wire:model="mobile" class="login-input2" />
                                             @error('mobile')
                                                 <small class="text-danger">{{ $message }}</small>
                                             @enderror
                                         </div>
                                     </div>
                                 </div>

                                 <div class="form-group mt-3">
                                     <button type="submit"
                                         class="btn quicksand fw-600 btn-block fs-18 pt-10 pb-10 hover-up hover-brand">
                                         Submit
                                     </button>
                                 </div>
                             </form>
                         </div>

                     </div>
                 </div>
             </div>
         </div>
     </div>
 </main>

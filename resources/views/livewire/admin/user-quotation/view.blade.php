<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="mb-0 d-inline-block fs-6 lh-1" href="{{url('/admin')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <h1 class="mb-0 d-inline-block fs-6 lh-1">Ecommerce</h1>
                                </li>
                                <li class="breadcrumb-item">
                                    <a class="mb-0 d-inline-block fs-6 lh-1" href="{{route('admin.user-quotation.index')}}">User Quotations</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <h1 class="mb-0 d-inline-block fs-6 lh-1">User Quotation Details</h1>
                                </li>
                            </ol>
                        </nav>

                    </div>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body page-content">
        <div class="container-xl">


            <div id="main-order-content">



                <div class="row row-cards">
                    <div class="col-md-9">
                        <div class="card mb-3">
                            <div class="card-header justify-content-between">
                                <h4 class="card-title">
                                    User Quotation Details
                                </h4>

                                @if($quotation->status == 0)
                                <span class="badge bg-warning text-dark d-flex align-items-center gap-1">
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="M12 6v6l4 2"></path>
                                    </svg>
                                    Pending
                                </span>
                                @elseif($quotation->status == 1)
                                <span class="badge bg-primary text-white d-flex align-items-center gap-1">
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M3 12h18"></path>
                                        <path d="M3 6h18"></path>
                                        <path d="M3 18h18"></path>
                                    </svg>
                                    Converted
                                </span>
                                @else
                                <span class="badge bg-danger text-white d-flex align-items-center gap-1">
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M22 7H2v10h20V7z"></path>
                                        <path d="M7 7V4h10v3"></path>
                                    </svg>
                                    Lost
                                </span>
                                @endif

                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 px-3 py-4">
                                        <p class="mb-2 text-dark fs-15">
                                            <strong class="text-secondary">Name &nbsp; : &nbsp;</strong>
                                            <span class="text-dark fw-bold">{{$quotation->name}}</span>
                                        </p>
                                        <p class="mb-2 text-dark fs-15">
                                            <strong class="text-secondary">Eamil &nbsp; :
                                                &nbsp;</strong>
                                            <span class="text-dark fw-bold">{{$quotation->email}}</span>
                                        </p>
                                        <p class="mb-2 text-dark fs-15">
                                            <strong class="text-secondary">Mobile &nbsp; :
                                                &nbsp;</strong>
                                            <span class="text-dark fw-bold">{{$quotation->mobile_number}}</span>

                                        </p>
                                        <p class="mb-2 text-dark fs-15">
                                            <strong class="text-secondary">Remarks &nbsp; :
                                                &nbsp;</strong>
                                            <span class="text-dark fw-bold">{{$quotation->remarks}}</span>

                                        </p>
                                        <p class="mb-2 text-dark fs-15">
                                            <strong class="text-secondary">Remarks &nbsp; :
                                                &nbsp;</strong>
                                            <span class="text-dark fw-bold">{{$quotation->remarks}}</span>

                                        </p>
                                    </div> 
                                    <div class="col-md-6 px-3 py-4">
                                        <p class="mb-2 text-dark fs-15">
                                            <strong class="text-secondary">Images &nbsp; :&nbsp;</strong>
                                        </p> 
                                        <div class="row"> 
                                            @php 
                                                $quotation_images = json_decode($quotation->images,true); 
                                            @endphp 

                                            @foreach($quotation_images as $img)
                                            <div class="col-md-4"> 
                                                <a href="{{Storage::url($img)}}" target="_blank" rel="noopener noreferrer">
                                                    <img src="{{Storage::url($img)}}" alt="" style="height: 100px; width:100px;">
                                                </a>
                                            </div> 
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">


                        <div class="card mb-4">
                            <div class="card-header">
                                <h4 class="card-title">
                                    Quotation Status Change
                                </h4>
                            </div>

                            <div class="card-body p-3">
                                @if ($quotation->status !== 1 && $quotation->status !== 2)
                                <form wire:submit.prevent="quotationStatusChange" class="mb-2">

                                    <div class="">
                                        <label for="statusSelect" class="form-label fw-bold">Change Status:</label>
                                        <select wire:model="status" id="statusSelect" class="form-select">
                                            <option value="">Select Status</option>
                                            <option value="1">Converted</option>
                                            <option value="2">Lost</option>
                                        </select>
                                    </div>

                                    <div class="d-flex justify-content-center mt-3">
                                        <button class="btn btn-primary">Change</button>
                                    </div>
                                </form>
                                @else
                                <div class="mt-3">
                                    <label for="statusSelect" class="form-label fw-bold">Status</label>
                                    @if ($quotation->status == 1)
                                    <p class="badge bg-success text-white">Converted</p>
                                    @elseif($quotation->status == 2)
                                    <p class="badge bg-danger text-white">Lost</p>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 <div class="page-wrapper">
     <div class="page-header d-print-none">
         <div class="container-xl">
             <div class="row g-2 align-items-center">
                 <div class="col">
                     <div class="page-pretitle">
                         <nav aria-label="breadcrumb">
                             <ol class="breadcrumb">
                                 <li class="breadcrumb-item">
                                     <a class="mb-0 d-inline-block fs-6 lh-1"
                                         href="{{ url("/admin") }}">Dashboard</a>
                                 </li>
                                 <li class="breadcrumb-item active" aria-current="page">
                                     <h1 class="mb-0 d-inline-block fs-6 lh-1">Contact</h1>
                                 </li>
                             </ol>
                         </nav>
                     </div>
                 </div>
                 <div class="col-auto ms-auto d-print-none">
                     <div class="btn-list"></div>
                 </div>
             </div>
         </div>
     </div>

     <div class="page-body page-content">
         <div class="container-xl">
             <div class="table-wrapper">
                 <div class="card mb-3 table-configuration-wrap" style="display: none">
                     <div class="card-body">
                         <button class="btn btn-icon btn-sm btn-show-table-options rounded-pill" type="button">
                             <svg class="icon icon-sm icon-left svg-icon-ti-ti-x" xmlns="http://www.w3.org/2000/svg"
                                 width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                 <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                 <path d="M18 6l-12 12" />
                                 <path d="M6 6l12 12" />
                             </svg>
                         </button>
                     </div>
                 </div>

                 <div class="card has-actions has-filter">
                     <div class="card-header">
                         <div class="w-100 justify-content-between d-flex flex-wrap align-items-center gap-1">
                             <div class="table-search-input">
                                 <label>
                                     <input type="search" class="form-control input-sm" placeholder="Search..."
                                         style="min-width: 120px" wire:model.live.debounce.500ms="search" />
                                 </label>
                             </div>
                         </div>
                     </div>

                     <div class="card-table">
                         <div class="table-responsive table-has-actions table-has-filter">
                             <table class="table card-table table-vcenter table-striped table-hover"
                                 id="botble-contact-tables-contact-table">
                                 <thead>
                                     <tr>
                                         <th title="ID" width="20"
                                             class="text-center no-column-visibility column-key-0">
                                             ID
                                         </th>
                                         <th title="Name" class="text-start column-key-1">
                                             Name
                                         </th>
                                         <th title="Email" class="text-start column-key-2">
                                             Email
                                         </th>
                                         <th title="Phone" class="text-start column-key-3">
                                             Phone
                                         </th>
                                         <th title="Created At" width="100" class="column-key-4">
                                             Created At
                                         </th>
                                         <th title="Status" width="100" class="text-center column-key-5">
                                             Status
                                         </th>
                                         <th title="Operations">Operations</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     @php
                                         $i = 1;
                                     @endphp
                                     @foreach ($contacts as $contact)
                                         <tr>
                                             <td>{{ $i++ }}</td>
                                             <td>{{ $contact->name }}</td>
                                             <td>{{ $contact->email }}</td>
                                             <td>{{ $contact->phone }}</td>
                                             <td>{{ $contact->created_at }}</td>
                                             <td>
                                                 @if ($contact->status == 0)
                                                     <span class="badge bg-danger text-white">Unread</span>
                                                 @else
                                                     <span class="badge bg-success text-white">Read</span>
                                                 @endif
                                             </td>
                                             <td><a
                                                     href="{{ route('admin.contact.us.customer-detail', $contact->id) }}"><i
                                                         class="fa fa-eye"></i></a></td>
                                         </tr>
                                     @endforeach
                                 </tbody>
                             </table>
                             {{ $contacts->links('vendor.pagination.bootstrap-5') }}
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <footer class="footer position-sticky footer-transparent d-print-none">
         <div class="container-xl">
             <div class="text-start">
                 <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-between">
                     <div class="order-2 order-lg-1">
                         Copyright 2025 © Fakhri Electric Store.
                     </div>
                 </div>
             </div>
         </div>
     </footer>
 </div>

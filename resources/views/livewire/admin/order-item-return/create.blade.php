<div class="page-wrapper">

    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="mb-0 d-inline-block fs-6 lh-1" href="{{ url('/admin') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <h1 class="mb-0 d-inline-block fs-6 lh-1">Return Order</h1>
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body page-content">
        <div class="container-xl">
            <form wire:submit.prevent="store">
                <div class="tab-pane fade active show" id="orders">

                    <div class="bb-return-form p-4 rounded shadow-sm border rounded-3"
                        style="background-color: #fff; border-left: 4px solid #ff6b6b;">

                        <h5 class="bb-section-title mb-4">Create Return Request</h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Order ID</label>
                                <input type="text" wire:model.live.debounce.500ms="order_id"
                                    class="form-control @error('order_id') is-invalid @enderror"
                                    placeholder="Enter Order ID">
                                @error('order_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Select Order Item</label>
                                <select wire:model="item_id" class="form-select @error('item_id') is-invalid @enderror">
                                    <option value="">-- Select Item --</option>
                                    @if (count($order_items) > 0)
                                        @foreach ($order_items as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->getProduct->name ?? 'Unknown Product' }}
                                                (Qty: {{ $item->quantity }})
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="" disabled>Enter valid Order ID first</option>
                                    @endif
                                </select>
                                @error('item_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Reason</label>
                                <select wire:model="reason" class="form-select @error('reason') is-invalid @enderror">
                                    <option value="">-- Select Reason --</option>
                                    <option value="Wrong item">Wrong item</option>
                                    <option value="Damaged">Damaged</option>
                                    <option value="Defective">Defective</option>
                                    <option value="Other">Other</option>
                                </select>
                                @error('reason')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Upload Images</label>
                                <input type="file" wire:model="images" multiple class="form-control">
                                @error('images.*')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Status</label>
                                <select wire:model="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="">-- Select Status --</option>
                                    <option value="0">Pending</option>
                                    <option value="1">Accepted</option>
                                    <option value="2">Received</option>
                                    <option value="3">Approved</option>
                                    <option value="4">Reject</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Remarks</label>
                            <textarea wire:model="remarks" rows="3" class="form-control" placeholder="Remarks..."></textarea>
                        </div>

                        <div class="btn-list">
                            <button class="btn btn-primary" type="submit">
                                <span wire:loading.remove>Save Return Request</span>
                                <span wire:loading>Saving...</span>
                            </button>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('livewire:initialized', () => {

                // Initialize Select2
                $('#customer-select').select2({
                    placeholder: "Search Customer by Name or Mobile",
                    allowClear: true,
                    width: '100%' // Fix width issue
                });

                // On Change Event: Update Livewire Property
                $('#customer-select').on('change', function(e) {
                    var data = $(this).val();
                    @this.set('user_id', data);
                });

                // Optional: Handle Auto-selection from Component (if needed)
                Livewire.on('update-customer-select', ({
                    value
                }) => {
                    $('#customer-select').val(value).trigger('change');
                });
            });
        </script>
    @endpush

</div>

<div wire:ignore.self class="modal fade" id="gitcardItemCreateModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Create Gift Card Item</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    wire:click="resetField"></button>
            </div>
            <form action="" wire:submit.prevent="giftCardItemCreate">
                <div class="modal-body">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="" class="form-label">Title</label>
                        <input type="text" class="form-control" placeholder="Enter Title" wire:model="title"
                            required />
                        @error('title')
                            <span class="text text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    @if ($is_edit == false)
                        <div class="form-group mb-3">
                            <label for="" class="form-label">Quantity</label>
                            <input type="text" class="form-control" placeholder="Enter Title" wire:model="quantity"
                                required />
                            @error('quantity')
                                <span class="text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        wire:click="resetField">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- edit code  -->
<div wire:ignore.self class="modal fade" id="gitcardItemEditModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="fs-5" id="exampleModalLabel">Edit Gift Card Item</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    wire:click="resetField"></button>
            </div>
            <form action="" wire:submit.prevent="giftCardItemUpdate">
                <div class="modal-body">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="" class="form-label">Title</label>
                        <input type="text" class="form-control" placeholder="Enter Title" wire:model="title"
                            required />
                        @error('title')
                            <span class="text text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        wire:click="resetField">Close</button>
                    <button type="submit" class="btn btn-warning">Update changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div wire:ignore.self class="modal fade" id="gitcardCreateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Create Gift Card</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="resetField"></button>
            </div>
            <form action="" wire:submit.prevent="giftCardGroupCreate">
                <div class="modal-body">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="" class="form-label">Price</label>
                        <input type="number" class="form-control" placeholder="Enter Price" wire:model="price" required/> 
                        @error('price') 
                        <span class="text text-danger">{{$message}}</span> 
                        @enderror
                    </div>

                    <div class="form-group form-check mb-3">
                        <input type="checkbox" class="form-check-input" wire:model="showCustomer" />
                        <label for="" class="form-label">Show Customer</label>
                    </div>

                    <div class="form-group form-check mb-3">
                        <input type="checkbox" class="form-check-input" wire:model="status" />
                        <label for="" class="form-label">Status</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="resetField">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div> 

<!-- edit code  -->
<div wire:ignore.self class="modal fade" id="gitcardEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="fs-5" id="exampleModalLabel">Edit Gift Card</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="resetField"></button>
            </div>
            <form action="" wire:submit.prevent="giftCardGroupUpdate">
                <div class="modal-body">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="" class="form-label">Price</label>
                        <input type="number" class="form-control" placeholder="Enter Price" wire:model="price" required/> 
                        @error('price') 
                        <span class="text text-danger">{{$message}}</span> 
                        @enderror
                    </div>

                    <div class="form-group form-check mb-3">
                        <input type="checkbox" class="form-check-input" wire:model="showCustomer" />
                        <label for="" class="form-label">Show Customer</label>
                    </div>

                    <div class="form-group form-check mb-3">
                        <input type="checkbox" class="form-check-input" wire:model="status" />
                        <label for="" class="form-label">Status</label>
                    </div>

                    <div class="form-group form-check mb-3">
                        <input type="checkbox" class="form-check-input" wire:model="isCustom" />
                        <label for="" class="form-label">Is Custom</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="resetField">Close</button>
                    <button type="submit" class="btn btn-warning">Edit changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
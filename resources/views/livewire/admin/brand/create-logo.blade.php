<div class="card meta-boxes">
    <div class="card-header">
        <h4 class="card-title">
            <label class="form-label" for="logo">
                Logo
            </label>
        </h4>
    </div>


    <div class=" card-body">
        <div class="image-box image-box-logo" action="select-image" data-counter="250">


            <div style="width: 8rem" class="preview-image-wrapper mb-1">
                <div class="preview-image-inner">
                    @if ($image)
                        <img class="preview-image default-image"
                            data-default="{{ asset('vendor/core/core/base/images/placeholder.png') }}"
                            src="{{ $image->temporaryUrl() }}" alt="Preview image" />
                    @else
                        <img class="preview-image default-image"
                            data-default="{{ asset('vendor/core/core/base/images/placeholder.png') }}"
                            src="{{ asset('vendor/core/core/base/images/placeholder.png') }}"
                            alt="Preview image" />
                    @endif
                </div>
            </div>

            <a href="javascript:void(0);" id="choose-image" onclick="selectImage();">
                Choose image
            </a>
            <input type="file" id="image-input" style="display: none;"
                accept="image/*"
                wire:model="image">
            @error('image')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>
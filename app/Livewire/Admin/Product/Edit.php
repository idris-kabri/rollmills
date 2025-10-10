<?php

namespace App\Livewire\Admin\Product;

use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeAssign;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use App\Models\ProductCategoryAssign;
use App\Models\ProductCategoryRelation;
use App\Models\ProductRelation;
use App\Traits\HasToastNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads, HasToastNotification;
    public $selectedOptions = [];
    public $productAttributes;
    public $productCategories;
    public $brands;
    public $selectedAttribute;
    public $selectedVariation = [];
    public $selectedVariationOption = [];
    public $selectedCategories = [];
    public $categoriesSearch;
    public $name;
    public $main_description;
    public $short_description;
    public $gallery_images = [];
    public $sku;
    public $price = 0;
    public $discount = 0;
    public $stock_status;
    public $weight = 0;
    public $length = 0;
    public $width = 0;
    public $height = 0;
    public $status;
    public $brand_id = [];
    public $featured_image;
    public $seo_title;
    public $seo_description;
    public $seo_meta;
    public $youtube_link;
    public $shipping_margin = 0;
    public $shipping_margin_br = 0;
    public $return_days = 0;
    public $replacement_days = 0;
    public $specifications = [];
    public $is_bulk_inquiry_supported = 0;
    public $pincode_excluded;
    public $discount_start_date;
    public $discount_end_date;
    public $product_warranty = 0;
    public $is_featured = 0;
    public $is_active;
    public $openAccordions = [];
    public $productId;
    public $defaultFeaturedImage;
    public $default_gallery_images;
    public $related_products = [];
    public $all_products = [];
    public $linked_products = [];
    public $sale_default_price = 0;

    public function mount($id)
    {
        $this->productAttributes = ProductAttribute::with('getAttibuteItems')->get();
        $this->brands = Brand::all();
        $this->all_products = Product::all();
        $this->buildCategoryTree();
        if ($id) {
            $this->loadProduct($id);
        }
    }

    function buildCategoryTree()
    {
        $categories_array = [];
        if (isset($this->categoriesSearch) && $this->categoriesSearch != '' && $this->categoriesSearch != null) {
            $categories = ProductCategory::where('name', 'LIKE', "%{$this->categoriesSearch}%")->get();
            foreach ($categories as $cat) {
                $categories_array[$cat->id] = [
                    'id' => $cat->id,
                    'name' => $cat->name
                ];
            }
        } else {
            $categories = ProductCategory::where('parent_id', null)->get();
            foreach ($categories as $cat) {
                $child_category = ProductCategory::where('parent_id', $cat->id)->get();
                $categories_array[$cat->id] = [
                    'id' => $cat->id,
                    'name' => $cat->name,
                    'items' => []
                ];
                if (isset($child_category) && count($child_category) > 0) {
                    foreach ($child_category as $child) {
                        $categories_array[$cat->id]['items'][] = [
                            'id' => $child->id,
                            'name' => $child->name,
                            'parent_id' => $child->parent_id
                        ];
                    }
                }
            }
        }

        $this->productCategories = $categories_array;
    }

    public function loadProduct($id)
    {
        $product = Product::findOrFail($id);

        $sub_product = Product::where('parent_id', $id)->pluck('id')->toArray();
        // Load attributes
        $this->selectedOptions = [];
        $attributeAssigns = ProductAttributeAssign::whereIn('product_id', $sub_product)->get();

        foreach ($attributeAssigns as $assign) {
            $attribute = ProductAttribute::with('getAttibuteItems')->find($assign->product_set_id);

            if ($attribute) {
                if (!isset($this->selectedOptions[$attribute->id])) {
                    $this->selectedOptions[$attribute->id] = [
                        'id' => $attribute->id,
                        'name' => $attribute->name,
                        'items' => [$assign->title],
                        'is_default' => null,
                        'remove' => false
                    ];
                }

                // dd($assign->title, $this->selectedOptions[$attribute->id]['items']);
                // Add the assigned attribute value
                $items = $this->selectedOptions[$attribute->id]['items'] ?? [];
                if (is_array($items) && !in_array($assign->title, $items)) {
                    $this->selectedOptions[$attribute->id]['items'][] = $assign->title;
                }

                if ($assign->is_default == 1) {
                    $index = array_search($assign->title, $this->selectedOptions[$attribute->id]['items']);
                    $this->selectedOptions[$attribute->id]['is_default'] = $index;
                }
            }
        }

        //Load variations
        $this->selectedVariationOption = [];
        $variations = Product::where('parent_id', $id)->get();
        foreach ($variations as $variation) {

            $attrAssign = ProductAttributeAssign::where('product_id', $variation->id)->get();
            $compositeKeyParts = [];
            $nameParts = [];

            foreach ($attrAssign as $item) {

                $items = $this->selectedOptions[$item->product_set_id]['items'];
                $key = array_search($item->title, $items);

                if ($key !== false) {
                    $compositeKeyParts[] = $item->product_set_id . ',' . $key;
                    $nameParts[] = $items[$key];
                }
            }

            if (!empty($compositeKeyParts)) {
                $compositeKey = implode('|', $compositeKeyParts);

                $this->selectedVariationOption[$compositeKey] = [
                    'details' => [
                        'id' => $variation->id,
                        'gallery_images' => [],
                        'existing_gallery_images' => !empty($variation->images) ? json_decode($variation->images, true) : [],
                        'sku' => $variation->SKU ?? '',
                        'stock_status' => (bool) ($variation->out_of_stock ?? false),
                        'is_active' => $variation->active_inactive_status,
                        'regular_price' => $variation->price ?? 0,
                        'sale_default_price' => $variation->sale_default_price ?? 0,
                        'sale_price' => $variation->sale_price ?? 0,
                        'shipping_margin_br' => $variation->shipping_margin_br ?? 0,
                        'from_date' => $variation->sale_from_date ?? null,
                        'sale_date' => $variation->sale_to_date ?? null,
                        'weight' => $variation->weight ?? 0,
                        'length' => $variation->length ?? 0,
                        'width' => $variation->width ?? 0,
                        'height' => $variation->height ?? 0,
                        'description' => $variation->description ?? '',
                        'existing_featured_image' => $variation->featured_image ?? null,
                        'remove' => false
                    ]
                ];
            }
        }

        $this->productId = $product->id;
        $this->name = $product->name;
        $this->main_description = $product->description;
        $this->short_description = $product->short_description;
        $this->youtube_link = $product->youtube_video_link;
        $this->sku = $product->SKU;
        $this->price = $product->price;
        $this->discount = $product->sale_price;
        $this->discount_start_date = $product->sale_from_date;
        $this->discount_end_date = $product->sale_to_date;
        $this->stock_status = $product->out_of_stock; 
        $this->is_bulk_inquiry_supported = $product->bulk_supported;
        $this->weight = $product->weight;
        $this->length = $product->length;
        $this->width = $product->width;
        $this->height = $product->height;
        $this->shipping_margin = $product->extra_shipping_margin;
        $this->shipping_margin_br = $product->shipping_margin_br;
        $this->pincode_excluded = $product->pincode_excluded;
        $this->product_warranty = $product->product_waranty;
        $this->return_days = $product->product_return_days;
        $this->replacement_days = $product->product_replacement_days;
        $this->seo_title = $product->seo_title;
        $this->seo_meta = $product->seo_meta;
        $this->seo_description = $product->seo_description;
        $this->status = $product->status;
        $this->is_featured = $product->is_featured;
        $this->is_active = $product->active_inactive_status;
        $this->specifications = json_decode($product->specifications, true);
        $this->selectedCategories = $product->categoryAssigns->pluck('category_id')->toArray();
        $this->brand_id = $product->brands->pluck('brand_id')->toArray();
        $this->related_products = $product->productRelation->where('type', 'Related')->pluck('related_product_id')->toArray();
        $this->linked_products = $product->productRelation->where('type', 'Linked')->pluck('related_product_id')->toArray();
        $this->defaultFeaturedImage = $product->featured_image;
        $this->default_gallery_images = json_decode($product->images, true) ?? [];
        $this->sale_default_price = $product->sale_default_price;
    }

    public function addOption()
    {
        if ($this->selectedAttribute) {
            $attribute = ProductAttribute::with('getAttibuteItems')->find($this->selectedAttribute);

            if ($attribute && !isset($this->selectedOptions[$attribute->id])) {
                $this->selectedOptions[$attribute->id] = [
                    'id' => $attribute->id,
                    'name' => $attribute->name,
                    'items' => $attribute->getAttibuteItems->pluck('name')->toArray(), // Fetch item names 
                    'remove' => true
                ];
            }

            $this->selectedAttribute = null;
        }
    }

    public function removeOption($attributeId, $index)
    {
        if (isset($this->selectedOptions[$attributeId]['items'][$index])) {

            unset($this->selectedOptions[$attributeId]['items'][$index]);

            $this->selectedOptions[$attributeId]['items'] = array_values($this->selectedOptions[$attributeId]['items']);

            if (empty($this->selectedOptions[$attributeId]['items'])) {
                unset($this->selectedOptions[$attributeId]);
            }
        }
    }

    public function addRow($attributeId)
    {
        if (isset($this->selectedOptions[$attributeId])) {
            $this->selectedOptions[$attributeId]['items'][] = "";
        }
    }

    public function addOptionFromGlobal()
    {
        if (!empty($this->selectedVariation)) {
            $sortedVariation = [];
            foreach ($this->selectedOptions as $attrId => $option) {
                foreach ($this->selectedVariation as $key => $value) {
                    $parts = explode(',', $value);
                    if ($parts[0] == $attrId) {
                        $sortedVariation[$key] = $value;
                    }
                }
            }

            $compositeKey = implode('|', $sortedVariation);

            // Initialize the array structure with all required keys
            $this->selectedVariationOption[$compositeKey] = [
                'details' => [
                    'id' => null,
                    'gallery_images' => [],               // For new uploads
                    'existing_gallery_images' => [],               // For new uploads
                    'existing_featured_image' => null, // For existing images
                    'sku' => '',
                    'weight' => $this->weight,
                    'length' => $this->length,
                    'width' => $this->width,
                    'height' => $this->height,
                    'regular_price' => 0,
                    'is_active' => 1,
                    'shipping_margin_br' => 0,
                    'remove' => true
                    // ... other default fields
                ]
            ];
        }
    }

    public function removeVariation($index, $variationId = null)
    {
        if (isset($this->selectedVariationOption[$index])) {
            if ($variationId != null) {
                Product::where('id', $variationId)->delete();
            }
            unset($this->selectedVariationOption[$index]);
        }

        $this->selectedVariationOption = array_merge($this->selectedVariationOption);
    }

    public function removeGallaryImage($type, $index, $key = null)
    {
        if ($type === 'existing') {
            unset($this->default_gallery_images[$index]);
            $this->default_gallery_images = array_values($this->default_gallery_images);
        } elseif ($type === 'new') {
            unset($this->gallery_images[$index]);
            $this->gallery_images = array_values($this->gallery_images);
        } elseif ($type === 'variationsExisting') {
            if (isset($this->selectedVariationOption[$index]['details']['existing_gallery_images'])) {
                unset($this->selectedVariationOption[$index]['details']['existing_gallery_images'][$key]);
                $this->selectedVariationOption[$index]['details']['existing_gallery_images'] = array_values(
                    $this->selectedVariationOption[$index]['details']['existing_gallery_images']
                );
            }
        } elseif ($type === 'variationsNew') {
            unset($this->selectedVariationOption[$index]['details']['gallery_images'][$key]);
            $this->selectedVariationOption[$index]['details']['gallery_images'] = array_values(
                $this->selectedVariationOption[$index]['details']['gallery_images']
            );
        }
    }

    public function formSubmit()
    {
        $validator = Validator::make($this->all(), [
            'name' => 'required',
            'main_description' => 'required',
            'short_description' => 'required',
            'youtube_link' => 'sometimes|nullable',
            'gallery_images' => 'sometimes|nullable|array',
            'gallery_images.*' => 'sometimes|nullable',
            'sku' => 'sometimes|nullable',
            'price' => 'required|min:1',
            'sale_default_price' => 'nullable|sometimes',
            'discount' => 'sometimes|nullable',
            'discount_start_date' => 'sometimes|nullable',
            'discount_end_date' => 'sometimes|nullable',
            'stock_status' => 'sometimes|nullable',
            'is_bulk_inquiry_supported' => 'sometimes|nullable',
            'weight' => 'required',
            'length' => 'required',
            'width' => 'required',
            'height' => 'required',
            'shipping_margin' => 'sometimes|nullable',
            'pincode_excluded' => 'sometimes|nullable',
            'product_warranty' => 'sometimes|nullable',
            'return_days' => 'sometimes|nullable',
            'replacement_days' => 'sometimes|nullable',
            'seo_title' => 'sometimes|nullable',
            'seo_meta' => 'sometimes|nullable',
            'seo_description' => 'sometimes|nullable',
            'status' => 'required',
            'is_featured' => 'required',
            'selectedCategories' => 'required|array',
            'selectedCategories.*' => 'required|exists:product_categories,id',
            'brand_id' => 'sometimes|nullable|array',
            // 'brand_id.*' => 'sometimes|nullable|exists:brands,id',
            'featured_image' => 'sometimes',
            'specifications' => 'sometimes|nullable|array',
            'specifications.*.name' => 'sometimes|nullable',
            'specifications.*.value' => 'sometimes|nullable',
            'selectedOptions' => 'sometimes|nullable|array',
            'selectedOptions.*.id' => 'sometimes|nullable|exists:product_attributes,id',
            'selectedOptions.*.items' => 'sometimes|nullable|array',
            'selectedVariationOption' => 'sometimes|nullable|array',
            'selectedVariationOption.*.details' => 'sometimes|nullable|array',
            'selectedVariationOption.*.details.*.image' => 'sometimes|nullable',
            'selectedVariationOption.*.details.*.sku' => 'sometimes|nullable',
            'selectedVariationOption.*.details.*.regular_price' => 'sometimes|nullable',
            'selectedVariationOption.*.details.*.sale_default_price' => 'sometimes|nullable',
            'selectedVariationOption.*.details.*.sale_price' => 'sometimes|nullable',
            'selectedVariationOption.*.details.*.from_date' => 'sometimes|nullable',
            'selectedVariationOption.*.details.*.sale_date' => 'sometimes|nullable',
            'selectedVariationOption.*.details.*.weight' => 'sometimes|nullable',
            'selectedVariationOption.*.details.*.length' => 'sometimes|nullable',
            'selectedVariationOption.*.details.*.width' => 'sometimes|nullable',
            'selectedVariationOption.*.details.*.height' => 'sometimes|nullable',
            'selectedVariationOption.*.details.*.description' => 'sometimes|nullable',
        ]);

        if ($validator->fails()) {
            $this->dispatch('validation-errors', [
                'errors' => $validator->errors()
            ]);
        } else {
            try {
                sleep(1);
                $product_id = [];
                $product = Product::findOrFail($this->productId);
                $product->name = $this->name;
                $product->description = $this->main_description;
                $product->short_description = $this->short_description;
                $product->youtube_video_link = $this->youtube_link;
                $product->SKU = $this->sku;
                $product->price = $this->price;
                $product->sale_default_price = $this->sale_default_price;
                $product->sale_price = $this->discount ?? 0;
                $product->sale_from_date = $this->discount_start_date;
                $product->sale_to_date = $this->discount_end_date;
                $product->out_of_stock = $this->stock_status;
                $product->bulk_supported = $this->is_bulk_inquiry_supported;
                $product->weight = $this->weight;
                $product->length = $this->length;
                $product->width = $this->width;
                $product->height = $this->height;
                $product->extra_shipping_margin = $this->shipping_margin;
                $product->shipping_margin_br = $this->shipping_margin_br;
                $product->pincode_excluded = $this->pincode_excluded;
                $product->product_waranty = $this->product_warranty;
                $product->product_return_days = $this->return_days;
                $product->product_replacement_days = $this->replacement_days;
                $product->seo_title = $this->seo_title;
                $product->seo_meta = $this->seo_meta;
                $product->seo_description = $this->seo_description;
                $product->status = $this->status == 'published' ? 1 : 0;
                $product->is_featured = $this->is_featured;
                if ($this->is_active == false) {
                    $product->active_inactive_status = 0;
                } else {
                    $product->active_inactive_status = 1;
                }
                $product->specifications = json_encode($this->specifications ?? []);

                if ($this->featured_image instanceof \Illuminate\Http\UploadedFile && $this->featured_image) {
                    // Store the image in the 'product' folder under the 'public' disk
                    $imagePath = $this->featured_image->store('product', 'public');
                    $product->featured_image = $imagePath;
                }


                // Handle gallery images - UPDATED VERSION
                $existingImages = $this->default_gallery_images ?? [];
                $newImages = [];

                if (!empty($this->gallery_images)) {
                    foreach ($this->gallery_images as $image) {
                        if ($image instanceof \Illuminate\Http\UploadedFile) {
                            $path = $image->store('product', 'public');

                            if (!in_array($path, $existingImages)) {
                                $newImages[] = $path;
                            }
                        }
                    }
                }

                $allImages = array_merge($existingImages, $newImages);
                $product->images = json_encode($allImages);


                $product->save();

                $product_id[] = $product->id;


                // dd($this, $this->selectedVariationOption);
                if ($this->selectedVariationOption != null && isset($this->selectedVariationOption) && count($this->selectedVariationOption) > 0) {
                    foreach ($this->selectedVariationOption as $key => $option) {
                        $product_variation = (isset($option['details']['id']) && $option['details']['id'])
                            ? Product::find($option['details']['id'])
                            : new Product();

                        // Set common properties
                        $product_variation->name = $this->name;
                        $product_variation->description = $option['details']['description'] ?? $this->main_description;
                        $product_variation->short_description = $this->short_description;
                        $product_variation->youtube_video_link = $this->youtube_link;
                        $product_variation->SKU = $option['details']['sku'] ?? $this->sku;
                        $product_variation->price = $option['details']['regular_price'] ?? $this->price;
                        $product_variation->sale_price = $option['details']['sale_price'] ?? $this->discount ?? 0;
                        $product_variation->sale_default_price = $option['details']['sale_default_price'] ?? $this->sale_default_price ?? 0;
                        $product_variation->sale_from_date = $option['details']['from_date'] ?? $this->discount_start_date;
                        $product_variation->sale_to_date = $option['details']['sale_date'] ?? $this->discount_end_date;
                        $product_variation->out_of_stock = isset($option['details']['stock_status'])
                            ? ($option['details']['stock_status'] == false ? 0 : 1)
                            : $this->stock_status;
                        if ($option['details']['is_active'] == false) {
                            $product_variation->active_inactive_status = 0;
                        } else {
                            $product_variation->active_inactive_status = 1;
                        }
                        $product_variation->bulk_supported = $this->is_bulk_inquiry_supported;
                        $product_variation->weight = $option['details']['weight'] ?? $this->weight;
                        $product_variation->length = $option['details']['length'] ?? $this->length;
                        $product_variation->width = $option['details']['width'] ?? $this->width;
                        $product_variation->height = $option['details']['height'] ?? $this->height;
                        $product_variation->extra_shipping_margin = $this->shipping_margin;
                        $product_variation->shipping_margin_br = $option['details']['shipping_margin_br'] ?? $this->shipping_margin_br;
                        $product_variation->pincode_excluded = $this->pincode_excluded;
                        $product_variation->product_waranty = $this->product_warranty;
                        $product_variation->product_return_days = $this->return_days;
                        $product_variation->product_replacement_days = $this->replacement_days;
                        $product_variation->seo_title = $this->seo_title;
                        $product_variation->seo_meta = $this->seo_meta;
                        $product_variation->seo_description = $this->seo_description;
                        $product_variation->status = $this->status == 'published' ? 1 : 0;
                        $product_variation->is_featured = $this->is_featured;
                        $product_variation->specifications = json_encode($this->specifications ?? []);

                        $product_variation->parent_id = $product->id;

                        // Handle featured image
                        if (isset($option['details']['image']) && $option['details']['image'] instanceof \Illuminate\Http\UploadedFile) {
                            $imagePath = $option['details']['image']->store('product', 'public');
                            $product_variation->featured_image = $imagePath;
                        } elseif (!empty($option['details']['existing_featured_image'])) {
                            $product_variation->featured_image = $option['details']['existing_featured_image'];
                        } else {
                            $product_variation->featured_image = $product->featured_image;
                        }

                        $gallaries = $option['details']['existing_gallery_images'] ?? [];

                        foreach ($option['details']['gallery_images'] ?? [] as $image) {
                            if ($image instanceof \Illuminate\Http\UploadedFile) {
                                $gallaries[] = $image->store('product', 'public');
                            }
                        }
                        $product_variation->images = !empty($gallaries) ? json_encode($gallaries) : $product->images;

                        $product_variation->save();
                        $product_id[] = $product_variation->id;

                        // Handle attributes - first delete existing ones if updating
                        if ($product_variation->exists) {
                            ProductAttributeAssign::where('product_id', $product_variation->id)->delete();
                        }

                        $attributes = [];
                        $attributes_name = [];
                        $keys_array = explode('|', $key);
                        $name = '';
                        foreach ($keys_array as $value) {
                            $value_array = explode(',', $value);
                            $attributeId = $value_array[0];
                            $itemIndex = $value_array[1];
                            $name .= $this->selectedOptions[$value_array[0]]['items'][$value_array[1]] . ' ';
                            $isDefaultIndex = $this->selectedOptions[$attributeId]['is_default'] ?? null;
                            $isDefault = $isDefaultIndex == $itemIndex;

                            $attributes_assign = new ProductAttributeAssign;
                            $attributes_assign->product_id = $product_variation->id;
                            $attributes_assign->product_set_id = $value_array[0];
                            $attributes_assign->title = $this->selectedOptions[$value_array[0]]['items'][$value_array[1]];
                            $attributes_assign->is_default = $isDefault ? 1 : 0;
                            $attributes_assign->save();

                            $attributes[] = $attributes_assign->id;
                            $attributes_name[] = $this->selectedOptions[$value_array[0]]['items'][$value_array[1]];
                        }

                        $product_variation->name = $this->name . " " . $name;
                        $product_variation->attribute_id = implode(',', $attributes);
                        $product_variation->attributes_name = implode(',', $attributes_name);
                        $product_variation->save();
                    }
                }

                if (!empty($this->selectedCategories)) {
                    foreach ($product_id as $item) {
                        $existingCategories = ProductCategoryAssign::where('product_id', $item)
                            ->pluck('category_id')
                            ->toArray();
                        $categoriesToDelete = array_diff($existingCategories, $this->selectedCategories);
                        if (!empty($categoriesToDelete)) {
                            ProductCategoryAssign::where('product_id', $item)
                                ->whereIn('category_id', $categoriesToDelete)
                                ->delete();
                        }
                        foreach ($this->selectedCategories as $category) {
                            $exists = ProductCategoryAssign::where('product_id', $item)
                                ->where('category_id', $category)
                                ->exists();

                            if (!$exists) {
                                ProductCategoryAssign::create([
                                    'product_id' => $item,
                                    'category_id' => $category
                                ]);
                            }
                        }
                    }
                }


                if (isset($this->brand_id)) {
                    // Get current brand associations for all products being updated
                    $currentBrands = ProductBrand::whereIn('product_id', $product_id)
                        ->pluck('brand_id')
                        ->toArray();

                    // Only make changes if brands were actually modified
                    if (array_diff($this->brand_id, $currentBrands) || array_diff($currentBrands, $this->brand_id)) {
                        ProductBrand::whereIn('product_id', $product_id)->delete();

                        if (!empty($this->brand_id)) {
                            foreach (array_unique($this->brand_id) as $brand) {
                                foreach ($product_id as $item) {
                                    $product_brand = new ProductBrand;
                                    $product_brand->product_id = $item;
                                    $product_brand->brand_id = $brand;
                                    $product_brand->save();
                                }
                            }
                        }
                    }
                }

                // Related Products
                ProductRelation::whereIn('product_id', $product_id)
                    ->where('type', 'Related')
                    ->delete();
                if (count($this->related_products) > 0) {
                    foreach ($this->related_products as $related_product) {
                        foreach ($product_id as $item) {
                            $product_relation_related = new ProductRelation();
                            $product_relation_related->product_id = $item;
                            $product_relation_related->related_product_id = $related_product;
                            $product_relation_related->type = 'Related';
                            $product_relation_related->save();
                        }
                    }
                }


                // Linked Products
                ProductRelation::whereIn('product_id', $product_id)
                    ->where('type', 'Linked')
                    ->delete();
                // Add new relations if any exist
                if (count($this->linked_products) > 0) {
                    foreach ($this->linked_products as $linked_product) {
                        foreach ($product_id as $item) {
                            $product_relation_linked = new ProductRelation;
                            $product_relation_linked->product_id = $item;
                            $product_relation_linked->related_product_id = $linked_product;
                            $product_relation_linked->type = 'Linked';
                            $product_relation_linked->save();
                        }
                    }
                }

                DB::commit();
                $this->toastSuccess('Product Updated Successfully!');
                $this->redirectWithDelay('/admin/product/');
            } catch (\Exception $e) {
                DB::rollBack();
                dd($e);
                // $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }

    public function updateCategories($id)
    {
        $category = ProductCategory::find($id);
        if ($category->parent_id != null) {
            if (array_search($category->parent_id, $this->selectedCategories) === false) {
                $this->selectedCategories[] = $category->parent_id;
            }
            $this->updateCategories($category->parent_id);
        }
    }

    public function addSpecificationAttribute()
    {
        $this->specifications[] = [
            'name' => '',
            'value' => ''
        ];
    }

    public function removeSpecificationAttribute($index)
    {
        unset($this->specifications[$index]);
        $this->specifications = array_values($this->specifications);
    }

    public function toggleAccordion($index)
    {
        if (isset($this->openAccordions[$index]) && $this->openAccordions[$index] == true) {
            $this->openAccordions[$index] = false;
        } else {
            $this->openAccordions[$index] = true;
        }
    }

    public function render()
    {
        return view('livewire.admin.product.edit', ['productCategories' => $this->productCategories])->layout('layouts.admin.app');
    }
}

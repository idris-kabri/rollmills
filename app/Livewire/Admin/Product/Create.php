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
use Illuminate\Support\Str;

class Create extends Component
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
    public $stock_status = 0;
    public $weight = 0;
    public $length = 0;
    public $width = 0;
    public $height = 0;
    public $status = 'published';
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
    public $related_products = [];
    public $all_products = [];
    public $linked_products = [];
    public $sale_default_price = 0;
    public $new_images = [];
    public $tempImages = [];
    public $slug;

    public function mount()
    {
        $this->productAttributes = ProductAttribute::with('getAttibuteItems')->get();
        $this->all_products = Product::all();
        $this->brands = Brand::all();
    }

    public function updatedName($value)
    {
        $this->slug = Str::slug($value, '-');
    }

    public function updatedTempImages($value, $keyPath)
    {
        // Extract the key from the path (e.g., "tempImages.0" from "tempImages.0.1")
        // dd($value, $keyPath);
        $key = $keyPath;

        if (!empty($this->tempImages[$keyPath])) {
            // Initialize if not exists
            if (!isset($this->selectedVariationOption[$key]['details']['gallery_images'])) {
                $this->selectedVariationOption[$key]['details']['gallery_images'] = [];
            }

            // Add new images
            foreach ($this->tempImages[$key] as $image) {
                $this->selectedVariationOption[$key]['details']['gallery_images'][] = $image;
            }

            // Clear temp storage
            unset($this->tempImages[$key]);
        }
    }

    public function updatedNewImages()
    {
        foreach ($this->new_images as $image) {
            $this->gallery_images[] = $image;
        }
        $this->new_images = [];
    }

    public function buildCategoryTree()
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

    public function updateValues($key, $value)
    {
        if (!is_array($value)) {
            $value = [$value];
        }

        $this->$key = array_unique(array_merge($this->$key, $value));
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

    public function removeGallaryImage($index, $key = null, $type = null)
    {
        if ($type == 'variations') {
            unset($this->selectedVariationOption[$index]['details']['gallery_images'][$key]);
            $this->selectedVariationOption[$index]['details']['gallery_images'] = array_values($this->selectedVariationOption[$index]['details']['gallery_images']);
        } else {
            unset($this->gallery_images[$index]);
            $this->gallery_images = array_values($this->gallery_images);
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
            $compositeKey = implode('|', array_map(function ($item) {
                return $item;
            }, $this->selectedVariation));

            if (!isset($this->selectedVariationOption)) {
                $this->selectedVariationOption = [];
            }

            $this->selectedVariationOption[$compositeKey]['details'] = [
                'gallery_images' => [],
                'weight' => $this->weight,
                'length' => $this->length,
                'width' => $this->width,
                'height' => $this->height,
                'is_active' => 1,
                'shipping_margin_br' => 0
            ];
        }
    }

    public function removeVariation($index)
    {
        if (isset($this->selectedVariationOption[$index])) {
            unset($this->selectedVariationOption[$index]);
        }

        $this->selectedVariationOption = array_merge($this->selectedVariationOption);
    }

    public function formSubmit()
    {
        $validator = Validator::make($this->all(), [
            'name' => 'required',
            'slug' => 'required',
            'main_description' => 'required',
            'short_description' => 'required',
            'youtube_link' => 'sometimes|nullable',
            'gallery_images' => 'required|nullable|array',
            'gallery_images.*' => 'required|nullable',
            'sku' => 'sometimes|nullable',
            'price' => 'required|min:1',
            'sale_default_price' => 'sometimes|nullable',
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
            'brand_id.*' => 'sometimes|nullable|exists:brands,id',
            'featured_image' => 'required',
            'specifications' => 'sometimes|nullable|array',
            'specifications.*.name' => 'sometimes|nullable',
            'specifications.*.value' => 'sometimes|nullable',
            'selectedOptions' => 'sometimes|nullable|array',
            'selectedOptions.*.id' => 'sometimes|nullable|exists:product_attributes,id',
            'selectedOptions.*.items' => 'sometimes|nullable|array',
            'selectedVariationOption' => 'sometimes|nullable|array',
            'selectedVariationOption.*.details' => 'sometimes|nullable|array',
            'selectedVariationOption.*.details.*.image' => 'sometimes|nullable',
            'selectedVariationOption.*.details.*.gallery_images' => 'required_if:selectedVariationOption.*.details,>,0',
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
                DB::beginTransaction();
                $product_id = [];
                $product = new Product;
                $product->name = $this->name;
                $product->slug = $this->slug;
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

                if ($this->featured_image != null && isset($this->featured_image) && $this->featured_image != '') {
                    $imagePath = $this->featured_image->store('product', 'public');
                    $product->featured_image = $imagePath;
                }

                $gallaries = [];
                if ($this->gallery_images != null && isset($this->gallery_images) && count($this->gallery_images) > 0) {
                    foreach ($this->gallery_images as $key => $image) {
                        $galleryImagePath = $image->store('product', 'public');
                        $gallaries[] = $galleryImagePath;
                    }
                    $product->images = json_encode($gallaries);
                }


                $product->save();

                $product_id[] = $product->id;

                if ($this->selectedVariationOption != null && isset($this->selectedVariationOption) && count($this->selectedVariationOption) > 0) {
                    foreach ($this->selectedVariationOption as $key => $option) {
                        $product_variation = new Product;

                        $product_variation->name = $this->name;
                        $product_variation->description = $option['details']['description'] ?? $this->main_description;
                        $product_variation->short_description = $this->short_description;
                        $product_variation->youtube_video_link = $this->youtube_link;
                        $product_variation->SKU = $option['details']['sku'] ?? $this->sku;
                        $product_variation->price = $option['details']['regular_price'] ?? $this->price;
                        $product_variation->sale_default_price = $option['details']['sale_default_price'] ?? $this->sale_default_price;
                        $product_variation->sale_price = $option['details']['sale_price'] ?? $this->discount ?? 0;
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

                        if (isset($option['details']['image'])  && $option['details']['image'] != null && $option['details']['image'] != '') {
                            $imagePath = $option['details']['image']->store('product', 'public');
                            $product_variation->featured_image = $imagePath;
                        } else {
                            $product_variation->featured_image = $product->featured_image;
                        }
                        $gallaries = [];
                        if ($option['details']['gallery_images'] != null && isset($option['details']['gallery_images']) && count($option['details']['gallery_images']) > 0) {
                            foreach ($option['details']['gallery_images'] as $image) {
                                $galleryImagePath = $image->store('product', 'public');
                                $gallaries[] = $galleryImagePath;
                            }
                            $product_variation->images = json_encode($gallaries);
                        }

                        $product_variation->save();

                        $product_id[] = $product_variation->id;

                        $attributes = [];
                        $attributes_names = [];
                        $keys_array = explode('|', $key);
                        $name = '';
                        foreach ($keys_array as $value) {
                            $value_array = explode(',', $value);
                            $attributeId = $value_array[0];
                            $itemIndex = $value_array[1];
                            if (
                                isset($value_array[0], $value_array[1]) &&
                                isset($this->selectedOptions[$value_array[0]]) &&
                                isset($this->selectedOptions[$value_array[0]]['items'][$value_array[1]])
                            ) {
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
                                $attributes_names[] = $this->selectedOptions[$value_array[0]]['items'][$value_array[1]];
                            }
                        }
                        $product_variation->name = $this->name . " " . $name;
                        $product_variation->attribute_id = implode(',', $attributes);
                        $product_variation->attributes_name = implode(',', $attributes_names);
                        $product_variation->slug = Str::slug($product_variation->name. '-');
                        $product_variation->save();
                    }
                }

                if ($this->selectedCategories != null && isset($this->selectedCategories) && count($this->selectedCategories) > 0) {
                    foreach ($this->selectedCategories as $category) {
                        foreach ($product_id as $item) {
                            $product_category = new ProductCategoryAssign;
                            $product_category->product_id = $item;
                            $product_category->category_id = $category;
                            $product_category->save();
                        }
                    }
                }

                if ($this->related_products != null && isset($this->related_products) && count($this->related_products) > 0) {
                    foreach ($this->related_products as $related_product) {
                        foreach ($product_id as $item) {
                            $product_relation_related = new ProductRelation;
                            $product_relation_related->product_id = $item;
                            $product_relation_related->related_product_id = $related_product;
                            $product_relation_related->type = 'Related';
                            $product_relation_related->save();
                        }
                    }
                }

                if ($this->linked_products != null && isset($this->linked_products) && count($this->linked_products) > 0) {
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

                if ($this->brand_id != null && isset($this->brand_id) && count($this->brand_id) > 0) {
                    foreach ($this->brand_id as $brand) {
                        foreach ($product_id as $item) {
                            $product_brand = new ProductBrand;
                            $product_brand->product_id = $item;
                            $product_brand->brand_id = $brand;
                            $product_brand->save();
                        }
                    }
                }

                DB::commit();
                $this->toastSuccess('Product Created Successfully!');
                $this->redirectWithDelay('/admin/product/');
            } catch (\Exception $e) {
                DB::rollBack();
                dd($e);
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
        $this->buildCategoryTree();

        return view('livewire.admin.product.create', ['productCategories' => $this->productCategories])->layout('layouts.admin.app');
    }
}

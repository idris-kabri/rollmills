<?php

namespace App\Livewire\User\Component;

use Livewire\Component;
use App\Traits\HasToastNotification;
use App\Models\Product;
use App\Models\ProductAttributeAssign;
use Carbon\Carbon;
use Cart;

class ProductCard extends Component
{
    use HasToastNotification;
    public $product = [];
    public $parameter = '';
    public $get_sold = false;
    public $selected_product = null;

    public function mount($product, $parameter = null, $get_sold = false)
    {
        $this->product = $product;
        if ($parameter != null && $parameter != '') {
            $this->parameter = $parameter;
        }
        $this->get_sold = $get_sold;
    }

    public function updatedSelectedProduct($id){
        $this->selected_product = $id;
        session()->put('selected_product', $id);
        dd("Hye");
    }

    public function getDefaultVariation($parentId)
    {
        $defaultAttributes = ProductAttributeAssign::whereHas('product', function ($q) use ($parentId) {
            $q->where('parent_id', $parentId);
        })
            ->where('is_default', 1)
            ->pluck('title')
            ->unique()
            ->toArray();

        if (!empty($defaultAttributes)) {
            $attributeName = implode(',', $defaultAttributes);

            return Product::where('parent_id', $parentId)->where('attributes_name', $attributeName)->first();
        } else {
            return Product::find($parentId);
        }
    }

    public function addToCart($id)
    {
        // $product = Product::find($id);
        $defaultProduct = $this->getDefaultVariation($id);

        $addToCart = finalAddToCart($defaultProduct, 1);
        if ($addToCart == false) {
            $this->toastWarning('Already Exist In Your Cart!');
        } else {
            $this->toastSuccess('Successfully Added In Your Cart!');
        }
    }

    public function addToWhishlist($id)
    {
        $product = Product::find($id);

        $addToWhishlist = finalAddToWhishlist($product);
        if ($addToWhishlist == true) {
            $this->toastSuccess('Successfully Added In Your Whishlist!');
        } else {
            $this->toastWarning('Already Exist In Your Wishlist!');
        }
    }

    public function render()
    {
        return view('livewire.user.component.product-card');
    }
}

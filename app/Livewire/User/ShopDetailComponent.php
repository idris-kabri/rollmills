<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\OrderItems;
use App\Models\Product;
use App\Models\ProductAttributeAssign;
use App\Models\ProductCategoryAssign;
use App\Models\ProductRelation;
use App\Models\ProductReview;
use App\Models\Setting;
use App\Traits\HasToastNotification;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\WithFileUploads;
use Carbon\Carbon;

class ShopDetailComponent extends Component
{
    use WithFileUploads, HasToastNotification;
    public $mainProduct;
    public $mainProduct_reviews;
    public $mainProduct_reviews_count;
    public $mainProduct_reviews_avg;
    public $mainProduct_reviews_percentage;
    public $relatedProducts = [];
    public $linkedProducts = [];
    public $groupedAttributes = [];
    public $clickCount = 0;
    public $selectedAttribute;
    public $id;
    public $main_image = '';
    public $quantity = 1;
    public $selectedProductId = null;
    public $review_rating;
    public $review_remark;
    public $review_name;
    public $review_email;
    public $review_image;
    public $check_user_can_review;

    protected $listeners = ['closeQuickView' => 'handleCloseQuickView'];

    public function mount($slug = null, $id)
    {
        $this->id = $id;
        $setting = Setting::where('label', 'surprise_gift_product_id')->first()->value;
        if($id == (int)$setting){
            return redirect('/');
        }
        $this->selectedAttribute = [];
        $this->mainProduct = Product::findOrFail($id);

        $this->mainProduct_reviews = ProductReview::where('status', 1)->where('product_id', $id)->get();
        $this->mainProduct_reviews_count = ProductReview::where('status', 1)->where('product_id', $id)->count();

        $this->mainProduct_reviews_avg = round($this->mainProduct_reviews->avg('ratings'), 1);

        $this->mainProduct_reviews_percentage = ($this->mainProduct_reviews_avg / 5) * 100;

        $relatedProduct = ProductRelation::where('product_id', $this->mainProduct->id)->where('type', 'Related')->pluck('related_product_id')->toArray();
        $linkedProduct = ProductRelation::where('product_id', $this->mainProduct->id)->where('type', 'Linked')->pluck('related_product_id')->toArray();

        $this->relatedProducts = Product::whereIn('id', $relatedProduct)->where('parent_id', null)->take(8)->get();
        $this->linkedProducts = Product::whereIn('id', $linkedProduct)->get();

        if (count($this->relatedProducts) <= 0) {
            $categoryIds = $this->mainProduct->categoryAssigns->pluck('category_id')->unique();

            $this->relatedProducts = Product::whereHas('categoryAssigns', function ($query) use ($categoryIds) {
                $query->whereIn('category_id', $categoryIds);
            })
                ->where('id', '!=', $id)
                ->take(8)
                ->get();
        }
        $subProduct = Product::where('parent_id', $id)->pluck('attribute_id')->toArray();
        $flatIds = [];
        foreach ($subProduct as $item) {
            $flatIds = array_merge($flatIds, explode(',', $item));
        }
        $flatIds = array_map('intval', $flatIds);
        $productAttributeAssign = ProductAttributeAssign::whereIn('id', $flatIds)->get();

        foreach ($productAttributeAssign as $assign) {
            $setIds = $assign->product_set_id;
            $attributeName = $assign->productAttribute->name;

            $assignItems = $assign->productAttribute->getAttibuteItems;

            // dd($assign,$attributeName,$assignItems);
            if (!isset($this->groupedAttributes[$setIds])) {
                $this->groupedAttributes[$setIds] = [
                    'name' => $attributeName,
                    'items' => [],
                ];

                $this->selectedAttribute[$setIds] = null;
            }
            if (!in_array($assign->title, $this->groupedAttributes[$setIds]['items'])) {
                $this->groupedAttributes[$setIds]['items'][] = $assign->title;
            }
            if ($assign->is_default == 1) {
                $this->handleAttributeClick($setIds, $assign->title);
            }
        }

        $productId = $this->mainProduct->id;
        $cart_check = Cart::instance('cart')
            ->search(function ($cartItem) use ($productId) {
                return $cartItem->id === $productId;
            })
            ->first();
        if ($cart_check) {
            $this->quantity = $cart_check->qty;
        }

        if (Auth::check()) {
            $this->check_user_can_review = OrderItems::whereHas('getOrder', function ($query) {
                $query->where('logged_in_user_id', Auth::user()->id)->whereNotIn('status', [0, 4]);
            })
                ->where('item_id', $id)
                ->first();
        }

        $this->jsonCreation();
    }

    public function reviewStore()
    {
        try {
            $this->validate([
                'review_rating' => 'required|integer|min:1|max:5',
                'review_name' => Auth::check() ? 'nullable' : 'required|string',
                'review_email' => Auth::check() ? 'nullable' : 'required|email',
                'review_remark' => 'required|string',
            ]);
            $review = new ProductReview();
            $review->product_id = $this->mainProduct->id;
            if (Auth::user()) {
                $review->user_id = Auth::user()->id;
                $review->name = Auth::user()->name;
                $review->email = Auth::user()->email;
            } else {
                $review->name = $this->review_name;
                $review->email = $this->review_email;
            }
            $review->ratings = $this->review_rating;
            $review->remarks = $this->review_remark;
            if ($this->review_image) {
                $path = $this->review_image->store('review', 'public');
                $review->image = $path;
            }
            $review->save();
            $this->toastSuccess('Thanks For Review This Product!');
            if ($this->mainProduct->slug) {
                $url = '/shop-detail/' . $this->mainProduct->slug . $this->mainProduct->id;
            } else {
                $url = '/shop-detail/no-slug/' . $this->mainProduct->id;
            }
            $this->redirectWithDelay($url);
        } catch (ValidationException $e) {
            $firstError = collect($e->validator->errors()->all())->first();
            $this->toastError($firstError);
        } catch (\Exception $e) {
            $this->toastError($e->getMessage());
        }
    }
    public function handleAttributeClick($key, $item)
    {
        $this->selectedAttribute[$key] = $item;
        $filtered = array_filter($this->selectedAttribute);
        $attributeName = implode(',', $filtered);
        $product = Product::where('parent_id', $this->id)->where('attributes_name', $attributeName)->first();
        if ($product) {
            $this->mainProduct = $product;
            $productId = $this->mainProduct->id;
            $cart_check = Cart::instance('cart')
                ->search(function ($cartItem) use ($productId) {
                    return $cartItem->id === $productId;
                })
                ->first();
            if ($cart_check) {
                $this->quantity = $cart_check->qty;
            } else {
                $this->quantity = 1;
            }
        }
        $this->jsonCreation();
    }

    public function changeMainImage($image)
    {
        $this->main_image = $image;
    }

    public function incrementQuantity()
    {
        $this->quantity++;
    }

    public function decrementQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function jsonCreation()
    {
        $sale_price = 0;
        $currentDate = Carbon::now();
        $sale_from_date = Carbon::parse($this->mainProduct->sale_from_date);
        $sale_to_date = Carbon::parse($this->mainProduct->sale_to_date);

        if ($this->mainProduct->sale_price > 0 && $currentDate->between($sale_from_date, $sale_to_date)) {
            $sale_price = $this->mainProduct->sale_price;
        } else {
            $sale_price = $this->mainProduct->sale_default_price;
        }
        $price = $this->mainProduct->price;
        $discount = 0;
        if ($sale_price > 0) {
            $price = $sale_price;
            $discount = $this->mainProduct->price > $sale_price ? round($this->mainProduct->price - $sale_price) : 0;
        }
        $category_assign = ProductCategoryAssign::where('product_id', $this->mainProduct->id)->orderBy('category_id', 'asc')->get();

        $items = [];
        $item = [
            'item_id' => $this->mainProduct->id,
            'item_name' => $this->mainProduct->name,
            'affiliation' => '',
            'coupon' => '',
            'discount' => (float) $discount,
            'index' => 0,
            'item_brand' => 'Roll Mills',
        ];

        foreach ($category_assign as $key => $category) {
            if ($key == 0) {
                $item['item_category'] = $category->category->name;
            } else {
                $item['item_category' . $key + 1] = $category->category->name;
            }
        }

        $item['item_list_id'] = '';
        $item['item_list_name'] = '';
        if ($this->mainProduct->attributes_name != null) {
            $attributes = explode(',', $this->mainProduct->attributes_name);
            foreach ($attributes as $key => $attribute) {
                $item['item_variant'] = $attribute;
            }
        }
        $item['location_id'] = '';
        $item['price'] = (float) $price;
        $item['quantity'] = 1;

        $items[] = $item;
        $this->dispatch('item-view', $items);
    }

    public function addToCart()
    {
        $existing_qauntity = 0;
        $cart = Cart::instance('cart')->search(function ($cartItem, $rowId) use (&$existing_qauntity) {
            if ($cartItem->id === $this->mainProduct->id) {
                $existing_qauntity = $cartItem->qty;
                return true;
            }
        });
        $addToCart = finalAddToCart($this->mainProduct, $this->quantity + $existing_qauntity, 'update-quantity');
        $sale_price = 0;
        $currentDate = Carbon::now();
        $sale_from_date = Carbon::parse($this->mainProduct->sale_from_date);
        $sale_to_date = Carbon::parse($this->mainProduct->sale_to_date);

        if ($this->mainProduct->sale_price > 0 && $currentDate->between($sale_from_date, $sale_to_date)) {
            $sale_price = $this->mainProduct->sale_price;
        } else {
            $sale_price = $this->mainProduct->sale_default_price;
        }
        $price = $this->mainProduct->price;
        $discount = 0;
        if ($sale_price > 0) {
            $price = $sale_price;
            $discount = $this->mainProduct->price > $sale_price ? round($this->mainProduct->price - $sale_price) : 0;
        }
        $category_assign = ProductCategoryAssign::where('product_id', $this->mainProduct->id)->orderBy('category_id', 'asc')->get();

        $items = [];
        $item = [
            'item_id' => $this->mainProduct->id,
            'item_name' => $this->mainProduct->name,
            'affiliation' => '',
            'coupon' => '',
            'discount' => (float) $discount,
            'index' => 0,
            'item_brand' => 'Roll Mills',
        ];

        foreach ($category_assign as $key => $category) {
            if ($key == 0) {
                $item['item_category'] = $category->category->name;
            } else {
                $item['item_category' . $key + 1] = $category->category->name;
            }
        }

        $item['item_list_id'] = '';
        $item['item_list_name'] = '';
        if ($this->mainProduct->attributes_name != null) {
            $attributes = explode(',', $this->mainProduct->attributes_name);
            foreach ($attributes as $key => $attribute) {
                $item['item_variant'] = $attribute;
            }
        }
        $item['location_id'] = '';
        $item['price'] = (float) $price;
        $item['quantity'] = $this->quantity;

        $items[] = $item;
        $this->dispatch('add-to-cart', $items);
        if ($addToCart) {
            $this->toastSuccess('Successfully Added In Your Cart!');
        } else {
            $this->toastSuccess('Product Quntity Change Successfully!');
        }
    }

    public function addToWhishlist()
    {
        $addToWhishlist = finalAddToWhishlist($this->mainProduct);
        $sale_price = 0;
        $currentDate = Carbon::now();
        $sale_from_date = Carbon::parse($this->mainProduct->sale_from_date);
        $sale_to_date = Carbon::parse($this->mainProduct->sale_to_date);

        if ($this->mainProduct->sale_price > 0 && $currentDate->between($sale_from_date, $sale_to_date)) {
            $sale_price = $this->mainProduct->sale_price;
        } else {
            $sale_price = $this->mainProduct->sale_default_price;
        }
        $price = $this->mainProduct->price;
        $discount = 0;
        if ($sale_price > 0) {
            $price = $sale_price;
            $discount = $this->mainProduct->price > $sale_price ? round($this->mainProduct->price - $sale_price) : 0;
        }
        $category_assign = ProductCategoryAssign::where('product_id', $this->mainProduct->id)->orderBy('category_id', 'asc')->get();

        $items = [];
        $item = [
            'item_id' => $this->mainProduct->id,
            'item_name' => $this->mainProduct->name,
            'affiliation' => '',
            'coupon' => '',
            'discount' => (float) $discount,
            'index' => 0,
            'item_brand' => 'Roll Mills',
        ];

        foreach ($category_assign as $key => $category) {
            if ($key == 0) {
                $item['item_category'] = $category->category->name;
            } else {
                $item['item_category' . $key + 1] = $category->category->name;
            }
        }

        $item['item_list_id'] = '';
        $item['item_list_name'] = '';
        if ($this->mainProduct->attributes_name != null) {
            $attributes = explode(',', $this->mainProduct->attributes_name);
            foreach ($attributes as $key => $attribute) {
                $item['item_variant'] = $attribute;
            }
        }
        $item['location_id'] = '';
        $item['price'] = (float) $price;
        $item['quantity'] = 1;

        $items[] = $item;
        $this->dispatch('add-to-wishlist', $items);
        if ($addToWhishlist == true) {
            $this->toastSuccess('Successfully Added In Your Whishlist!');
        } else {
            $this->toastWarning('Already Exist In Your Wishlist!');
        }
    }

    public function handleCloseQuickView()
    {
        $this->selectedProductId = null;
    }

    public function addPreviewProduct($id)
    {
        $this->selectedProductId = $id;
    }

    public function render()
    {
        // Define the OG Image
        // Check if mainProduct has an image, otherwise fallback to logo
        $ogImage = $this->mainProduct->featured_image ? asset('storage/' . $this->mainProduct->featured_image) : asset('assets/frontend/imgs/theme/logo.png');

        $metaTitle = $this->mainProduct->meta_title;
        $metaDescription = $this->mainProduct->seo_description;
        $metaKeywords = $this->mainProduct->seo_meta;

        // Prepare the data to pass to the layout
        $layoutData = [
            'meta_title' => $metaTitle,
            'meta_description' => $metaDescription,
            'meta_keywords' => $metaKeywords,
            'og_title' => $this->mainProduct->name,
            'og_type' => 'product',
            'og_url' => request()->url(),
            'og_image' => $ogImage,
        ];

        // Pass $layoutData as the second argument
        return view('livewire.user.shop-detail-component')->layout('layouts.user.app', $layoutData);
    }
}

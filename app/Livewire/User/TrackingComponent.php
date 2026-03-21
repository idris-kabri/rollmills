<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Order;
use App\Models\OrderAWB;
use App\Models\Product;
use App\Models\ProductRelation;
use App\Models\ProductCategoryAssign;
use App\Models\Transaction;
use App\Models\Coupon;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Attributes\Url;
use App\Traits\HasToastNotification;

class TrackingComponent extends Component
{
    use HasToastNotification;
    public $id;
    public $mainProduct;
    public $quantity = 1;

    // Payment Variables mapped to URL query string
    #[Url]
    public $transaction_id = '';
    #[Url]
    public $payment_id = '';

    public function mount($id)
    {
        $this->id = $id;

        // Catch URL parameters returning from Razorpay success
        $this->transaction_id = request()->query('transaction_id');
        $this->payment_id = request()->query('payment_id');

        if ($this->transaction_id) {
            $transaction = Transaction::find($this->transaction_id);

            // Ensure transaction exists and hasn't been processed yet
            if ($transaction && $transaction->status == 0) {
                // Update Transaction
                $transaction->status = 1; // Mark as Paid
                $transaction->payment_id = $this->payment_id;
                $transaction->save();

                $amount = $transaction->amount;
                $order = Order::find($this->id);

                if ($order && $order->is_cod == 1) {
                    $order->paid_amount = $amount;
                    $discount = $order->total - $amount;

                    // Update Order Financials
                    $order->total = $amount;
                    $order->total_bonus = $discount;
                    $order->remaining_amount = 0;
                    $order->is_cod = 0; // Converted to Prepaid

                    // Adjust Delivery Charges
                    $cod_charges = $order->cod_charges;
                    $order->cod_charges = 0;
                    $order->total_delievery_charges = $order->total_delievery_charges - $cod_charges;
                    $order->save();

                    // Update Order Items Bonus
                    $order_items = $order->getOrderItems;
                    foreach ($order_items as $order_item) {
                        $official_price = $order_item->sale_default_price;
                        $bonus_amount = ($official_price * 20) / 100;

                        $order_item->bonus = $bonus_amount;
                        $total = $order_item->total;

                        $order_item->total = $total - $bonus_amount * $order_item->quantity;
                        $order_item->save();
                    }

                    $parameters = [$order->getBillAddress->name ?? 'Customer', $order->id, $amount];

                    if (function_exists('sendParameterTemplateWawi')) {
                        sendParameterTemplateWawi('cod_conversion_success', 'en_us', $order->getBillAddress->mobile ?? '', $parameters);
                    }

                    if (method_exists($this, 'toastSuccess')) {
                        $this->toastSuccess('Successfully converted to Prepaid! 20% Discount applied.');
                    }
                }
            }
        }
    }

    public function payNow()
    {
        $order = Order::find($this->id);

        if (!$order || $order->is_cod != 1 || $order->status != 1) {
            return;
        }

        // Calculate 10% discount on items to find the exact payable amount
        $discount = 0;
        foreach ($order->getOrderItems as $item) {
            $discount += ($item->total * 20) / 100;
        }
        $final_amount = ceil($order->total - $discount - $order->cod_charges);

        $user_id = $order->logged_in_user_id ?? 1;

        $transaction = razorPayPayment($final_amount, $user_id, $order->id, 'orders', 'Order Placed Using Online Payment');

        $billAddress = $order->getBillAddress;

        $this->dispatch('initiate-razorpay', [
            'transaction_id' => $transaction->transaction_id,
            'razorpay_order_id' => $transaction->id,
            'amount' => $transaction->amount,
            'description' => $transaction->description,
            'name' => $billAddress->name ?? 'Customer',
            'email' => $billAddress->email ?? 'customer@example.com',
            'customer_name' => $billAddress->name ?? 'Customer',
            'customer_email' => $billAddress->email ?? 'customer@example.com',
            'id' => $order->id,
            'success_url' => route('tracking-info', ['id' => $order->id]), // Return to this exact tracking page
        ]);
    }

    public function addToCart($product_id)
    {
        $this->mainProduct = Product::find($product_id);

        if (!$this->mainProduct) {
            return;
        }

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
                $item['item_category'] = $category->category->name ?? '';
            } else {
                $item['item_category' . ($key + 1)] = $category->category->name ?? '';
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
            if (method_exists($this, 'toastSuccess')) {
                $this->toastSuccess('Successfully Added In Your Cart!');
            }
        } else {
            if (method_exists($this, 'toastSuccess')) {
                $this->toastSuccess('Product Quantity Changed Successfully!');
            }
        }
    }

    public function render()
    {
        $order = Order::with(['getOrderItems.getProduct.categoryAssigns', 'getOrderAWB'])->find($this->id);

        if (!$order) {
            abort(404);
        }

        $order_awb = $order->getOrderAWB;
        $product_ids = $order->getOrderItems->pluck('item_id')->toArray();

        $related_product_ids = ProductRelation::whereIn('product_id', $product_ids)->where('type', 'Related')->distinct()->pluck('related_product_id')->toArray();

        if (empty($related_product_ids)) {
            $related_product_ids = $order->getOrderItems
                ->flatMap(function ($item) {
                    return $item->getProduct->categoryAssigns->pluck('product_id');
                })
                ->unique()
                ->toArray();
        }

        $related_products = Product::whereIn('id', $related_product_ids)->where('status', 1)->where('out_of_stock', 0)->take(5)->get();
        $coupon = Coupon::where('order_id', $order->id)->first();

        return view('livewire.user.tracking-component', compact('order', 'order_awb', 'related_products', 'coupon'))->layout('layouts.user.app');
    }
}

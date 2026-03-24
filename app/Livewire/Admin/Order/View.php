<?php

namespace App\Livewire\Admin\Order;

use App\Models\Order;
use App\Models\OrderAWB;
use App\Models\Transaction;
use App\Models\Address;
use App\Models\Product;
use App\Models\OrderItems;
use App\Traits\HasToastNotification;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use function Symfony\Component\Clock\now;

class View extends Component
{
    use HasToastNotification;

    public $order;
    public $status;
    public $order_transaction;

    public $logistics = [];

    // Properties for Address Edit
    public $edit_address_id;
    public $edit_name;
    public $edit_email;
    public $edit_mobile;
    public $edit_address_line_1;
    public $edit_address_line_2;
    public $edit_city;
    public $edit_state;
    public $edit_zipcode;

    // Properties for Add Item Logic
    public $searchKeyword = '';
    public $searchResults = [];
    public $selectedProductId = null;
    public $selectedProductName = '';
    public $selectedProductQty = 1;

    // Properties for Edit Item Logic
    public $editOrderItemId = null;
    public $editOrderItemQty = 1;
    public $editOrderItemName = '';

    // --- Properties for Edit Discounts & Totals ---
    public $edit_special_discount = 0;
    public $edit_total_bonus = 0;
    public $edit_order_total = 0;

    // --- XpressBees Properties ---
    public $xpressbeesRates = [];
    public $xpressbeesError = null;

    protected $rules = [
        'logistics.*.aggregator' => 'nullable|string|max:255',
        'logistics.*.provider' => 'nullable|string|max:255',
        'logistics.*.awb_number' => 'required|string|max:255',
        'logistics.*.charges' => 'nullable|numeric',
    ];

    public function mount($id)
    {
        $this->order = Order::find($id);
        $this->order_transaction = Transaction::where('refrence_id', $id)->where('refrence_table', 'orders')->first();

        $this->status = $this->order->status;

        $order_awbs = OrderAWB::where('order_id', $this->order->id)->get();
        if (count($order_awbs) > 0) {
            foreach ($order_awbs as $order_awb) {
                $this->logistics[] = [
                    'aggregator' => $order_awb->aggregator,
                    'provider' => $order_awb->provider,
                    'awb_number' => $order_awb->awb_number,
                    'charges' => $order_awb->charges_taken,
                ];
            }
        }
    }

    // --- XPRESSBEES LOGIC ---

    public function checkExpressBees()
    {
        $this->xpressbeesRates = [];

        $login_data = xpressBeesLogin();
        if ($login_data['status'] == true) {
            $token = $login_data['data'];
            $availability_data = serviceabilityCheck($token, $this->order);
            if ($availability_data['status'] == true) {
                $this->xpressbeesRates = $availability_data['data'];
                $this->dispatch('open-xpressbees-modal');
            } else {
                $this->toastError($availability_data['message']);
            }
        } else {
            $this->toastError($login_data['message']);
        }
    }

    // --- ADD ITEM TO ORDER LOGIC ---

    public function updatedSearchKeyword()
    {
        if (strlen($this->searchKeyword) > 1) {
            $this->searchResults = Product::where('name', 'like', '%' . $this->searchKeyword . '%')
                ->orWhere('SKU', 'like', '%' . $this->searchKeyword . '%')
                ->where('status', 1)
                ->take(10)
                ->get();
        } else {
            $this->searchResults = [];
        }
    }

    public function selectProduct($id)
    {
        $product = Product::find($id);
        if ($product) {
            $this->selectedProductId = $product->id;
            $this->selectedProductName = $product->name;
            $this->searchKeyword = '';
            $this->searchResults = [];
        }
    }

    public function clearSelectedProduct()
    {
        $this->selectedProductId = null;
        $this->selectedProductName = '';
        $this->selectedProductQty = 1;
        $this->searchKeyword = '';
        $this->searchResults = [];
    }

    public function addItemToOrder()
    {
        $this->validate([
            'selectedProductId' => 'required|exists:products,id',
            'selectedProductQty' => 'required|integer|min:1',
        ]);

        $product = Product::find($this->selectedProductId);

        $sale_price = 0;
        $currentDate = now();
        $sale_from_date = \Carbon\Carbon::parse($product->sale_from_date);
        $sale_to_date = \Carbon\Carbon::parse($product->sale_to_date);

        if ($product->sale_price > 0 && $currentDate->between($sale_from_date, $sale_to_date)) {
            $sale_price = $product->sale_price;
        } elseif ($product->sale_default_price > 0) {
            $sale_price = $product->sale_default_price;
        }

        $price = $sale_price > 0 ? $sale_price : $product->price;
        $subtotal = $this->selectedProductQty * $price;

        $orderItem = new OrderItems();
        $orderItem->order_id = $this->order->id;
        $orderItem->item_id = $product->id;
        $orderItem->quantity = $this->selectedProductQty;
        $orderItem->regular_price = $product->price;
        $orderItem->sale_price = $product->sale_price ?? 0;
        $orderItem->sale_default_price = $product->sale_default_price ?? 0;
        $orderItem->sale_price_start_date = $product->sale_from_date;
        $orderItem->sale_price_end_date = $product->sale_to_date;
        $orderItem->subtotal = $subtotal;
        $orderItem->offer_id = null;
        $orderItem->offer_discount = 0;
        $orderItem->bonus = 0;
        $orderItem->total = $subtotal;
        $orderItem->item_return_days = $product->product_return_days;
        $orderItem->gst = $product->gst ?? 0;
        $orderItem->gst_amount = $subtotal - ($subtotal * 100) / (100 + ($product->gst ?? 0));
        $orderItem->item_replacement_days = $product->product_replacement_days;
        $orderItem->delivery_at = now();
        $orderItem->is_gift_item = 0;
        $orderItem->save();

        $this->order->subtotal += $subtotal;
        $this->order->total += $subtotal;

        if ($this->order->is_cod == 1 || $this->order->status == 0) {
            $this->order->remaining_amount += $subtotal;
        }
        $this->order->save();

        $this->clearSelectedProduct();
        $this->order = Order::find($this->order->id); // refresh

        $this->dispatch('close-add-item-modal');
        $this->toastSuccess('Item successfully added to the order!');
    }

    // --- EDIT / REMOVE ITEM LOGIC ---

    public function editItem($itemId)
    {
        $orderItem = OrderItems::find($itemId);
        if ($orderItem) {
            $this->editOrderItemId = $orderItem->id;
            $this->editOrderItemQty = $orderItem->quantity;
            $this->editOrderItemName = $orderItem->getProduct->name;
        }
    }

    public function updateItem()
    {
        $this->validate([
            'editOrderItemQty' => 'required|integer|min:1',
        ]);

        $orderItem = OrderItems::find($this->editOrderItemId);
        if ($orderItem) {
            $oldSubtotal = $orderItem->subtotal;
            $oldTotal = $orderItem->total;

            $price = $orderItem->sale_price > 0 ? $orderItem->sale_price : ($orderItem->sale_default_price > 0 ? $orderItem->sale_default_price : $orderItem->regular_price);
            $newSubtotal = $this->editOrderItemQty * $price;

            $orderItem->quantity = $this->editOrderItemQty;
            $orderItem->subtotal = $newSubtotal;

            $newTotal = $newSubtotal - $orderItem->offer_discount - $orderItem->bonus;
            $orderItem->total = $newTotal;
            $orderItem->gst_amount = $newTotal - ($newTotal * 100) / (100 + ($orderItem->gst ?? 0));
            $orderItem->save();

            $subtotalDiff = $newSubtotal - $oldSubtotal;
            $totalDiff = $newTotal - $oldTotal;

            $this->order->subtotal += $subtotalDiff;
            $this->order->total += $totalDiff;

            if ($this->order->is_cod == 1 || $this->order->status == 0) {
                $this->order->remaining_amount += $totalDiff;
            }
            $this->order->save();

            $this->dispatch('close-edit-item-modal');
            $this->toastSuccess('Item quantity updated successfully!');
            $this->order = Order::find($this->order->id); // refresh
        }
    }

    public function removeItem($itemId)
    {
        $orderItem = OrderItems::find($itemId);
        if ($orderItem) {
            $this->order->subtotal -= $orderItem->subtotal;
            $this->order->total -= $orderItem->total;

            if ($this->order->is_cod == 1 || $this->order->status == 0) {
                $this->order->remaining_amount -= $orderItem->total;
            }
            $this->order->save();
            $orderItem->delete();

            $this->toastSuccess('Item removed from order!');
            $this->order = Order::find($this->order->id); // refresh
        }
    }

    // --- EDIT DISCOUNTS LOGIC ---

    public function editDiscounts()
    {
        $this->edit_special_discount = $this->order->special_discount ?? 0;
        $this->edit_total_bonus = $this->order->total_bonus ?? 0;
    }

    public function updateDiscounts()
    {
        $this->validate([
            'edit_special_discount' => 'nullable|numeric|min:0',
            'edit_total_bonus' => 'nullable|numeric|min:0',
        ]);

        $old_special = $this->order->special_discount ?? 0;
        $old_bonus = $this->order->total_bonus ?? 0;

        $new_special = $this->edit_special_discount ?: 0;
        $new_bonus = $this->edit_total_bonus ?: 0;

        $discount_increase = $new_special + $new_bonus - ($old_special + $old_bonus);

        $this->order->special_discount = $new_special;
        $this->order->total_bonus = $new_bonus;

        $this->order->total -= $discount_increase;

        if ($this->order->total < 0) {
            $this->order->total = 0;
        }

        if ($this->order->is_cod == 1 || $this->order->status == 0) {
            $this->order->remaining_amount -= $discount_increase;
            if ($this->order->remaining_amount < 0) {
                $this->order->remaining_amount = 0;
            }
        }

        $this->order->save();

        $this->dispatch('close-edit-discounts-modal');
        $this->toastSuccess('Order discounts updated successfully!');
        $this->order = Order::find($this->order->id); // refresh
    }

    // --- EDIT ORDER TOTAL LOGIC ---

    public function editOrderTotal()
    {
        $this->edit_order_total = $this->order->total ?? 0;
    }

    public function updateOrderTotal()
    {
        $this->validate([
            'edit_order_total' => 'required|numeric|min:0',
        ]);

        $old_total = $this->order->total;
        $new_total = $this->edit_order_total;
        $diff = $new_total - $old_total;

        $this->order->total = $new_total;

        if ($this->order->is_cod == 1 || $this->order->status == 0) {
            $this->order->remaining_amount += $diff;
            if ($this->order->remaining_amount < 0) {
                $this->order->remaining_amount = 0;
            }
        }

        $this->order->save();

        $this->dispatch('close-edit-total-modal');
        $this->toastSuccess('Order total updated successfully!');
        $this->order = Order::find($this->order->id); // refresh
    }

    // --- LOGISTICS LOGIC ---

    public function addLogisticsRow()
    {
        $this->logistics[] = [
            'aggregator' => '',
            'provider' => '',
            'awb_number' => '',
            'charges' => '',
        ];
    }

    public function removeLogisticsRow($index)
    {
        unset($this->logistics[$index]);
        $this->logistics = array_values($this->logistics);
    }

    public function saveLogistics()
    {
        $this->validate();

        $order = Order::find($this->order->id);
        $sum = 0;
        OrderAWB::where('order_id', $order->id)->delete();
        foreach ($this->logistics as $logistic) {
            OrderAWB::create([
                'order_id' => $order->id,
                'aggregator' => $logistic['aggregator'],
                'provider' => $logistic['provider'],
                'awb_number' => $logistic['awb_number'],
                'charges_taken' => $logistic['charges'],
                'remarks' => 'Forward Shipping Charges',
            ]);

            $sum += (float) $logistic['charges'];
        }
        $order->total_delievery_charges = $sum;
        $order->save();

        $this->toastSuccess('Logistics details updated successfully!');
    }

    public function orderStatusChange()
    {
        $this->order->status = $this->status;

        if ($this->status == 2) {
            $this->order->shipped_at = now();
        } elseif ($this->status == 3) {
            $this->order->complete_at = now();
            $coupon_code = claimCoupon($this->order->id);
            $billing_address = json_decode($this->order->billing_address_details, true);
            $customerName = $billing_address['name'] ?? $this->order->getBillAddress->name;
            sendParameterTemplateWawi('order_delivered_2', 'en_US', $this->order->getBillAddress->mobile, [$customerName, (string) $this->order->id, "$coupon_code"]);
            if ($this->order->is_cod == 1) {
                $this->order->paid_amount = $this->order->total;
                $this->order->remaining_amount = 0;
            }
        }

        $this->order->save();
        $this->toastSuccess('Order Status Change Successfully!');

        $url = '/admin/orders/view/' . $this->order->id;
        $this->redirectWithDelay($url);
    }

    public function sendConfirmationMessage()
    {
        $items = '';

        foreach ($this->order->getOrderItems as $key => $item) {
            if ($key > 0) {
                $items .= "\n";
            }
            $items .= $item->getProduct->name . ' x ' . $item->quantity;
        }

        $address = $this->order->getBillAddress->address_line_1 . ' ' . $this->order->getBillAddress->address_line_2 . ', ' . $this->order->getBillAddress->city . ', ' . $this->order->getBillAddress->state . ', ' . $this->order->getBillAddress->zipcode;

        $totalAmount = (string) $this->order->total;

        if (strlen($items) > 1024 || strlen($address) > 1024) {
            \Log::error('WhatsApp Error: Variable too long', ['items_len' => strlen($items), 'addr_len' => strlen($address)]);
        }

        $paramters = [$this->order->getBillAddress->name, $items, $totalAmount, $this->order->getBillAddress->name, $this->order->getBillAddress->mobile, $address];

        sendParameterTemplateWawi('confirmation_message', 'en_us', $this->order->getBillAddress->mobile, $paramters);

        $this->toastSuccess('Confirmation Message Sent Successfully!');
    }

    public function editAddress()
    {
        $shippAddress = json_decode($this->order->ship_different_address_details);

        $this->edit_address_id = $shippAddress->id ?? null;
        $this->edit_name = $shippAddress->name ?? '';
        $this->edit_email = $shippAddress->email ?? '';
        $this->edit_mobile = $shippAddress->mobile ?? '';
        $this->edit_address_line_1 = $shippAddress->address_line_1 ?? '';
        $this->edit_address_line_2 = $shippAddress->address_line_2 ?? '';
        $this->edit_city = $shippAddress->city ?? '';
        $this->edit_state = $shippAddress->state ?? '';
        $this->edit_zipcode = $shippAddress->zipcode ?? '';
    }

    public function updateAddress()
    {
        $this->validate([
            'edit_name' => 'required|string|max:255',
            'edit_mobile' => 'required|string|max:20',
            'edit_address_line_1' => 'required|string|max:255',
            'edit_city' => 'required|string|max:255',
            'edit_state' => 'required|string|max:255',
            'edit_zipcode' => 'required|string|max:20',
        ]);

        $shippAddress = json_decode($this->order->ship_different_address_details, true) ?? [];
        $shippAddress['name'] = $this->edit_name;
        $shippAddress['email'] = $this->edit_email;
        $shippAddress['mobile'] = $this->edit_mobile;
        $shippAddress['address_line_1'] = $this->edit_address_line_1;
        $shippAddress['address_line_2'] = $this->edit_address_line_2;
        $shippAddress['city'] = $this->edit_city;
        $shippAddress['state'] = $this->edit_state;
        $shippAddress['zipcode'] = $this->edit_zipcode;

        $this->order->ship_different_address_details = json_encode($shippAddress);
        $this->order->save();

        if ($this->edit_address_id) {
            $address = Address::find($this->edit_address_id);
            if ($address) {
                $address->name = $this->edit_name;
                $address->email = $this->edit_email;
                $address->mobile = $this->edit_mobile;
                $address->address_line_1 = $this->edit_address_line_1;
                $address->address_line_2 = $this->edit_address_line_2;
                $address->city = $this->edit_city;
                $address->state = $this->edit_state;
                $address->zipcode = $this->edit_zipcode;
                $address->save();
            }
        }

        $this->toastSuccess('Shipping address updated successfully!');
        $this->redirectWithDelay('/admin/orders/view/' . $this->order->id);
    }

    public function render()
    {
        return view('livewire.admin.order.view')->layout('layouts.admin.app');
    }
}

<?php

namespace App\Livewire\Admin\Order;

use App\Models\Order;
use App\Models\OrderAWB;
use App\Models\Transaction;
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

    // 1. Array to hold multiple logistics entries
    public $logistics = [];

    // 2. Validation rules for the logistics array
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

    /**
     * Add a new empty row to the logistics form
     */
    public function addLogisticsRow()
    {
        $this->logistics[] = [
            'aggregator' => '',
            'provider' => '',
            'awb_number' => '',
            'charges' => '',
        ];
    }

    /**
     * Remove a specific row by index and re-index the array
     */
    public function removeLogisticsRow($index)
    {
        unset($this->logistics[$index]);
        $this->logistics = array_values($this->logistics);
    }

    /**
     * Save the logistics data to the database
     */
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
            if ($this->order->is_cod == 1) {
                $this->order->paid_amount = $this->order->total;
                $this->order->remaining_amount = 0;
            }

            // Whatsapp logic (commented out as per your original file)
            // ...
        }

        $this->order->save();
        $this->toastSuccess('Order Status Change Successfully!');

        // Reload page
        $url = '/admin/orders/view/' . $this->order->id;
        $this->redirectWithDelay($url);
    }

    public function sendConfirmationMessage()
    {
        $items = '';

        // 1. Build Item String with Standard Newline
        foreach ($this->order->getOrderItems as $key => $item) {
            if ($key > 0) {
                // Use "\n" (Double quotes, single backslash)
                // This creates a real new line byte.
                $items .= "\n";
            }
            $items .= $item->getProduct->name . ' x ' . $item->quantity;
        }

        $address = $this->order->getBillAddress->address_line_1 . ' ' . $this->order->getBillAddress->address_line_2 . ', ' . $this->order->getBillAddress->city . ', ' . $this->order->getBillAddress->state . ', ' . $this->order->getBillAddress->zipcode;

        // 3. Ensure Total is a string
        $totalAmount = (string) $this->order->total;

        // 4. Debug: Check length (Must be < 1024)
        if (strlen($items) > 1024 || strlen($address) > 1024) {
            \Log::error('WhatsApp Error: Variable too long', ['items_len' => strlen($items), 'addr_len' => strlen($address)]);
        }

        $paramters = [$this->order->getBillAddress->name, $items, $totalAmount, $this->order->getBillAddress->name, $this->order->getBillAddress->mobile, $address];

        sendParameterTemplateWawi('confirmation_message', 'en_us', $this->order->getBillAddress->mobile, $paramters);

        $this->toastSuccess('Confirmation Message Sent Successfully!');
    }

    public function render()
    {
        return view('livewire.admin.order.view')->layout('layouts.admin.app');
    }
}

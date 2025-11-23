<?php

namespace App\Livewire\Admin\OrderItemReturn;

use App\Models\Order;
use App\Models\OrderItems;
use App\Models\OrderReturnRequest;
use App\Models\Transaction;
use App\Models\User;
use App\Traits\HasToastNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class View extends Component
{ 
    use HasToastNotification;
    public $orderRetrun;
    public $status;
    public $changed_remarks;
    public function mount($id){ 
        $this->orderRetrun = OrderReturnRequest::find($id); 
        $this->changed_remarks = $this->orderRetrun->changed_remarks;
        $this->status = $this->orderRetrun->status;
    } 

    public function orderReturnSubmit(){  
        try{  

            $return = OrderReturnRequest::find($this->orderRetrun->id);  
            $orderItem = OrderItems::find($return->order_item_id); 
            $fetchOrder = Order::find($return->order_id);
            $fetchUser = User::find($fetchOrder->logged_in_user_id);
            if($this->status == 3){ 
                $orderItem->status = 3; 
                
                if($fetchOrder->coupon_discount > 0 && $fetchOrder->coupon_id != null){ 
                    $proportionalDiscount = ($fetchOrder->coupon_discount * $orderItem->total) / $fetchOrder->total;
                    $walletRefund = $orderItem->total - $proportionalDiscount;
                }else{ 
                    $walletRefund = $orderItem->total;
                } 

                $transaction = Transaction::where('refrence_table','orders')->where('refrence_id',$fetchOrder->id)->orderBy('id','desc')->first();
                $fetchUser->wallet_balance += $walletRefund;
                $token = generateShipRocketToken();
                placeShipment($transaction->refrence_id);

            }elseif($this->status == 4){ 
                $orderItem->status = 4;
            }elseif($this->status == 0){ 
                $orderItem->status = 2;
            }
            $return->status = $this->status;
            $return->changed_remarks = $this->changed_remarks; 
            $return->changed_by = Auth::user()->id; 
            $return->changed_at = now(); 

            $return->save();  
            $fetchUser->save();  
            $orderItem->save();

            $this->toastSuccess('Order Return Status Updated Successfully!'); 
            $url = 'order-return/view/'.$this->orderRetrun->id;
            $this->redirectWithDelay(route('admin.order-return.view', $this->orderRetrun->id));
        }catch(\Exception $e){ 
            $this->toastError($e->getMessage());
        }
        
    }
    public function render()
    {
        return view('livewire.admin.order-item-return.view')->layout('layouts.admin.app');
    }
}

<?php

namespace App\Livewire\Admin\GiftCardItem;

use App\Mail\GiftCardItemMail;
use App\Models\GiftCardItem;
use App\Traits\HasToastNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Mail;
use Pdf;

class Index extends Component
{
    use HasToastNotification, WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $giftCardGroup_id;
    public $title;
    public $gitcardItemId;
    public $search;
    public $quantity = 1;
    public $is_edit = false;

    public function mount($id)
    {
        $this->giftCardGroup_id = intval($id);
    }
    public function giftCardItemCreate()
    {
        $this->validate([
            'title' => 'required',
        ]);
        try { 
            sleep(1); 
            DB::beginTransaction();
            $ids_array = [];
            for ($i = 0; $i < $this->quantity; $i++) {
                $gift_Item = new GiftCardItem();
                $gift_Item->gift_card_group_id = $this->giftCardGroup_id;
                $gift_Item->title = $this->title;
                $gift_Item->gift_code = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6);
                $gift_Item->created_by = Auth::user()->id;
                $gift_Item->save();
                $ids_array[] = $gift_Item->id;
            }

            $items = GiftCardItem::whereIn('id', $ids_array)->get();
            DB::commit();
            $this->toastSuccess('Gift Card Item Created Successfully!');
            $this->dispatch('gift-item-model-close');

            // $front_pdf = Pdf::loadView('prints.gift-card-item-front', compact('items'))->setPaper('a4', 'landscape');
            // return response()->streamDownload(function () use ($front_pdf) {
            //     echo $front_pdf->stream();
            // }, 'gift-card-item-front.pdf');

            // $back_pdf = Pdf::loadView('prints.gift-card-item-back', compact('items'))->setPaper('a4', 'landscape');
            // return response()->streamDownload(function () use ($back_pdf) {
            //     echo $back_pdf->stream();
            // }, 'gift-card-item-back.pdf'); 

            $email = config('app.admin_email');
            $front_pdf = Pdf::loadView('prints.gift-card-item-front', compact('items'))->setPaper('a4', 'landscape')->output();
            $back_pdf = Pdf::loadView('prints.gift-card-item-back', compact('items'))->setPaper('a4', 'landscape')->output();
            
            Mail::to($email)->send(new GiftCardItemMail($front_pdf, $back_pdf)); 

            $url = '/admin/gift-card-items/' . $this->giftCardGroup_id;
            $this->redirectWithDelay($url);

        } catch (\Exception $e) {
            DB::rollBack();
            $this->toastError($e->getMessage());
        }
    }
    public function gitcardItemEdit($gitcardItem_Id)
    {
        $this->gitcardItemId = $gitcardItem_Id;
        $gift_Item = GiftCardItem::findOrFail($this->gitcardItemId);
        $this->title = $gift_Item->title;
        $this->is_edit = true;
    }

    public function giftCardItemUpdate()
    {
        $this->validate([
            'title' => 'required',
        ]);
        try {
            DB::beginTransaction();
            $gift_Item = GiftCardItem::findOrFail($this->gitcardItemId);
            $gift_Item->title = $this->title;
            $gift_Item->save();
            $this->toastSuccess('Gift Card Item Updated Successfully!');
            $this->dispatch('gift-item-model-close');
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->toastError($e->getMessage());
        }
    }
    public function resetField()
    {
        $this->title = null;
        $this->resetValidation();
        $this->resetErrorBag();
    }
    public function render()
    {
        $giftCardItems = GiftCardItem::where('gift_card_group_id', $this->giftCardGroup_id)
            ->where(function ($query) {
                $query->where('title', 'like', "%{$this->search}%")->orWhere('gift_code', 'like', "%{$this->search}%");
            })
            ->paginate(10);

        return view('livewire.admin.gift-card-item.index', compact('giftCardItems'))->layout('layouts.admin.app');
    }
}

<?php

namespace App\Livewire\Admin\Post;

use App\Models\PostPlatform;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $post_id;
    public $keyword;
    public $message;
    public $number_of_comment;
    public $product_id;
    public $platform = "Instagram";
    public $postId;
    public $disable = false;

    public function store()
    {
        if ($this->postId) {
            $store_settings = PostPlatform::find($this->postId);
        } else {
            $store_settings = new PostPlatform;
        }

        $store_settings->post_id = $this->post_id;
        $store_settings->keyword = $this->keyword;
        $store_settings->message = $this->message;
        $store_settings->number_of_comment = $this->number_of_comment;
        $store_settings->product_id = $this->product_id;
        $store_settings->platform = $this->platform;
        $store_settings->save();

        $this->reset(["post_id", "keyword", "message", "number_of_comment", "product_id", "platform", "disable", "postId"]);
        $this->platform = "Instagram";
    }

    public function loadSetting($id)
    {
        $setting = PostPlatform::find($id);

        $this->post_id = $setting->post_id;
        $this->keyword = $setting->keyword;
        $this->message = $setting->message;
        $this->number_of_comment = $setting->number_of_comment;
        $this->product_id = $setting->product_id;
        $this->platform = $setting->platform;

        $this->postId = $setting->id;
        $this->disable = true;

        $this->dispatch('refreshSelect2');
    }


    public function cancelEdit()
    {
        $this->reset(["post_id", "keyword", "message", "number_of_comment", "product_id", "platform", "postId", "disable"]);
        $this->platform = "Instagram";
        $this->dispatch('clearSelect2'); 
    }

    public function delete($id)
    {
        PostPlatform::find($id)?->delete();
    }

    public function render()
    {
        $posts = PostPlatform::orderBy("id", "desc")->paginate(10);
        $products = Product::all();
        return view('livewire.admin.post.index', compact("posts", "products"))->layout('layouts.admin.app');
    }
}

<?php

namespace App\Livewire\Admin\Settings;

use App\Models\Setting;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $label;
    public $value;
    public $settingId;
    public $disable = false;

    public function store()
    {
        if ($this->settingId) {
            $store_settings = Setting::find($this->settingId);
        } else {
            $store_settings = new Setting;
        }
        $store_settings->label = $this->label; 
        $store_settings->value = $this->value;
        $store_settings->save();
        $this->reset(["label","value","disable","settingId"]);
    }

    public function loadSetting($id)
    {
        $setting = Setting::find($id);
        $this->label = $setting->label;
        $this->settingId = $setting->id;
        $this->value = $setting->value;
        $this->disable = true;
    }

    public function cancelEdit()
    {
      $this->reset(["label","value","settingId","disable"]);
    }

    public function delete($id)
    {
        $delete = Setting::find($id);
        $delete->delete();
    }

    public function render()
    {
        $settings = Setting::orderBy("id", "desc")->paginate(10);
        return view('livewire.admin.settings.index', compact("settings"))->layout('layouts.admin.app');
    }
}

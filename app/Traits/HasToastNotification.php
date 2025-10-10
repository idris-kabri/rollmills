<?php

namespace App\Traits;

trait HasToastNotification
{
    public function toastSuccess($message)
    {
        $this->dispatch('success', message: $message);
    }

    public function toastWarning($message)
    {
        $this->dispatch('warning', message: $message);
    }
    public function toastError($message)
    {
        $this->dispatch('error', message: $message);
    }

    public function redirectWithDelay($url)
    {
        $this->dispatch('redirectAfterDelay', ['url' => $url]);
    }
}

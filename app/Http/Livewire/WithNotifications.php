<?php

namespace App\Http\Livewire;

trait WithNotifications
{
    public function notify($message, $level = 'info')
    {
        $this->emit('notify', [
            'message' => $message,
            'level' => $level
        ]);

        return true;
    }
}

<?php

namespace App\Events;

use App\Session;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class SessionUpdated
{
    use SerializesModels;

    /** @var Session */
    public $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

//
//    public function broadcastOn()
//    {
//        return new PrivateChannel('session.'.$this->session->slug);
//    }
}

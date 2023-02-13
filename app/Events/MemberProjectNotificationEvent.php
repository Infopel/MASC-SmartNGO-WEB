<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MemberProjectNotificationEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $email_subject;
    public $email_content;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($email_subject = null, $email_content,$user)
    {
        $this->email_subject = $email_subject;
        $this->email_content = $email_content;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}

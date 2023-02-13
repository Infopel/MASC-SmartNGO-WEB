<?php

namespace App\Events;

use App\Models\User;
use App\Models\ApprovementFLow;
use App\Models\ApprovementFlowModels;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ApprovementFlowNotificationEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $resource;
    public $approvement;
    public $email_content;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, $resource, ApprovementFlowModels $approvement, $email_content = null)
    {
        $this->user = $user;
        $this->resource = $resource;
        $this->approvement = $approvement;
        $this->email_content = $email_content;
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

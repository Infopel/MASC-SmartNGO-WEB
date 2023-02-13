<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SolicitacaoFundosNotificationEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $title;
    public $email_content;
    public $email_to;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, $email_content, string $email_subject, array $email_to)
    {
        $this->user = $user;
        $this->title = $email_subject;
        $this->email_content = $email_content;
        $this->email_to = $email_to;
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

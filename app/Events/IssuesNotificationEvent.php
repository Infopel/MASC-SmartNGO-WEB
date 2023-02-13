<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class IssuesNotificationEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $email_content;
    public $issue;
    public $allowed_permission;
    public $role;
    public $useRole;

    /**
     * Create a new event instance.
     *
     * @param mixed $issue
     * @param User $user
     * @param mixed $email_content
     * @param string $email_subject
     * @param string $email_subject
     * @param string $allowed_permission
     * @param mixed $role
     * @param mixed $useRole
     * @return void
     */
    public function __construct($issue = null, $user, $email_content, string $email_subject, array $allowed_permission, $role = null, $useRole = false)
    {
        $this->user = $user;
        $this->issue = $issue;
        $this->email_content = $email_content;
        $this->title = $email_subject;
        $this->allowed_permission = $allowed_permission;
        $this->role = $role;
        $this->useRole = $useRole;
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

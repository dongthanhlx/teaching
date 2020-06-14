<?php

namespace App\Events;

use App\ClassModel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TestCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $class;

    /**
     * TestCreated constructor.
     * @param $class
     */
    public function __construct(ClassModel $class)
    {
        $this->class = $class;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('class');
    }

    /**
     * @return string
     */
    public function broadcastAs()
    {
        return 'test.created';
    }
}

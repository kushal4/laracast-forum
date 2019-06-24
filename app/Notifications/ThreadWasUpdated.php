<?php
namespace App\Notifications;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class ThreadWasUpdated extends Notification
{
    /**
     * The thread that was updated.
     *
     * @var \App\Thread
     */
    protected $thread;
    /**
     * The new reply.
     *
     * @var \App\Reply
     */
    protected $reply;
    /**
     * Create a new notification instance.
     *
     * @param \App\Thread $thread
     * @param \App\Reply  $reply
     */
    public function __construct($thread, $reply)
    {
        Log::alert("THread Was  updated constructor initialised");
        $this->thread = $thread;
        $this->reply = $reply;
    }
    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via()
    {
        return ['database'];
    }


    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->reply->owner->name . ' replied to ' . $this->thread->title,
            'link' => $this->reply->path()
        ];
    }
    /**
     * Get the array representation of the notification.
     *
     * @return array
     */
    public function toArray()
    {
        //Log::alert("To array initiated");
        return [
            //'message' => $this->reply->owner->name . ' replied to ' . $this->thread->title,
            //'link' => $this->reply->path()

        ];
    }
}
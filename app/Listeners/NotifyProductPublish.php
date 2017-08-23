<?php

namespace App\Listeners;

use App\Events\ProductHasPublished;
use App\Notifications\ProductCreated;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class NotifyProductPublish implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ProductHasPublished $event
     * @return void
     */
    public function handle(ProductHasPublished $event)
    {
        $user = User::find($event->product->user_id);
        \Log::info($user);
        Notification::send($user, new ProductCreated($event->product));
    }
}

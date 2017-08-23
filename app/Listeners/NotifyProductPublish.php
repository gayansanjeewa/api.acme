<?php

namespace App\Listeners;

use App\Events\ProductHasPublished;
use App\Notifications\ProductCreated;
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
        \Log::info($event->product->toArray());
        Notification::send(auth()->user(), new ProductCreated($event->product));
    }
}

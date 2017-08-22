<?php

namespace App\Listeners;

use App\Events\ProductHasPublished;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
    }
}

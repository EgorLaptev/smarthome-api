<?php

namespace App\Listeners;

use App\Providers\MacroActivated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MacroNotification
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(MacroActivated $event)
    {
        dd(
            $event->macro->name
        );
    }
}

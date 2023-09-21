<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Http\Request;
// use Session;

class AddToSessionAfterLogin
{
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        // session(['emrDB' => 'sitapura']);
        // \Session::put("emrDB","sitapura");
        // \Session::save();
        // Session::put("emrDB","sitapura");
        // Session::save();
    }
}

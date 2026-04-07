<?php

namespace App\Http\Controllers;

abstract class Controller
{
    //
    public function create()
    {
        $slots = Slot::all();

        return view('booking.index', compact('slots'));
    }
}

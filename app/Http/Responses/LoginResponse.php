<?php

namespace App\Http\Responses;

use Inertia\Inertia;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        return $request->inertia()
            ? Inertia::location(config('fortify.home'))
            : redirect()->intended(config('fortify.home'));
    }
}

<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('isNotAuthorized')) {
    function isNotAuthorized($userId)
    {
        if (Auth::user()->id !== $userId) {
            return false;
        }
    }
}

<?php

if (!function_exists('getUserByCache')) {
    function getUserByCacheId(): int
    {
        return auth()->user()->id;
    }
}

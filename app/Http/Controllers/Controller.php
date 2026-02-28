<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function checkStatusForAdmin(string $route, int|string|null $param = null): ?RedirectResponse
    {
        $user = Auth::user();

        if (!$user->isAdmin()) {
            return redirect(route($route, [$param]))
                ->withErrors(['errors' => 'Не достаточно прав!']);
        }

        return null;
    }
}

<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{

    public function __construct(
        private readonly UserRepository $userRepository
    )
    {
    }

    public function index(Request $request): View
    {
        $query = User::query()->with('phones.phoneBrand');

        return view('users.index', [
            'users' => $query
                ->apply($request)
                ->paginate(10)
                ->withQueryString(),
        ]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(UserStoreRequest $userStoreRequest)
    {
        return redirect()->route(
            'users.show',
            $this->userRepository->store($userStoreRequest)
        );
    }

    public function show(User $user)
    {
        return view('users.show', [
            'user' => $user,
        ]);
    }

    public function update(
        UserUpdateRequest $userUpdateRequest,
        User              $user
    ): RedirectResponse
    {
        return redirect()->route(
            'users.show',
            $this->userRepository->update($userUpdateRequest, $user))
            ->with('success', 'Пользователь успешно обновлен!');
    }

    public function destroy(User $user)
    {
        $userRemoveResult = $this->userRepository->destroy($user);

        if ($userRemoveResult) {
            return redirect()->
            back()->
            with('success', 'Пользователь удален!');
        }

        return redirect()->
        back()->
        withErrors('errors', 'Ошибка при удалении!');
    }

    public function edit(string $slug)
    {
        return view('users.show', [
            'user' => User::query()->where('slug', $slug)->first(),
        ]);
    }
}

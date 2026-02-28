<?php

namespace App\Repository;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Avatar;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UserRepository
{
    final public function store(UserStoreRequest $userStoreRequest): User
    {
        DB::beginTransaction();
        try {
            $user = new User();
            $user->name = $userStoreRequest->name;
            $user->email = $userStoreRequest->email;
            $user->password = Hash::make($userStoreRequest->password);
            $user->slug = Str::slug($user->name);
            $user->save();

            if ($userStoreRequest->hasFile('avatar')) {
                $filePath = 'storage/' . $userStoreRequest->file('avatar')->store('avatars', 'public');
                Avatar::query()->create([
                    'user_id' => $user->id,
                    'path' => $filePath,
                ]);
            }
            DB::commit();
        }catch (\Exception $exception){
            Log::critical($exception->getMessage());
            DB::rollBack();
            throw new BadRequestHttpException($exception->getMessage());
        }

        return $user;
    }

    final public function update(UserUpdateRequest $userUpdateRequest, User $user): User
    {
        $validated = $userUpdateRequest->validated();
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = $validated['password'];
        }
        $user->slug = Str::slug($user->name);
        $user->save();

        return $user->refresh();
    }

    final public function destroy(User $user): bool
    {
       return $user->delete();
    }
}

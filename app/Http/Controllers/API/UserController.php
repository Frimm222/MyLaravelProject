<?php

namespace App\Http\Controllers\API;

use App\Traits\Filters;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    private const PER_PAGE = 10;

    public function __construct(
        private readonly UserRepository $userRepository
    ){
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $query = User::query()
            ->with([
                'phones:id,number,user_id,phone_brand_id',
                'phones.phoneBrand:id,name',
                'avatar']);

        return UserResource::collection(
            $query->apply($request)->paginate($request->get('per_page', self::PER_PAGE))
        );
    }

    public function store(UserStoreRequest $request): UserResource
    {
        return new UserResource($this->userRepository->store($request));
    }

    public function update(UserUpdateRequest $request, User $user): UserResource
    {
        return new UserResource($this->userRepository->update($request, $user));
    }

    public function show(User $user): UserResource
    {
        return new UserResource($user->load([
            'phones:id,number,user_id,phone_brand_id',
            'phones.phoneBrand:id,name',
            'avatar'
        ]));
    }

    public function destroy(User $user): JsonResponse
    {
        return response()->json([
            'status' => $this->userRepository->destroy($user) ? 'success' : 'failure',
        ], JsonResponse::HTTP_OK);
    }
}

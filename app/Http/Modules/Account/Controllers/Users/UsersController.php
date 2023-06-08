<?php

namespace App\Http\Modules\Account\Controllers\Users;

use App\Domain\Modules\Account\Actions\Users\CreateUserAction;
use App\Domain\Modules\Account\Actions\Users\LoginUserAction;
use App\Domain\Modules\Account\Actions\Users\LogoutUserAction;
use App\Domain\Modules\Account\Actions\Users\UpdateUserAction;
use App\Http\Modules\Account\Requests\Users\CreateUserRequest;
use App\Http\Modules\Account\Requests\Users\LoginUserRequest;
use App\Http\Modules\Account\Requests\Users\UpdateUserRequest;
use App\Http\Modules\Account\Resources\TokenResource;
use App\Http\Modules\Account\Resources\UsersResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class UsersController
 *
 * @package App\Http\Modules\Account\Controllers\Users
 */
class UsersController
{
    /**
     * Формирует новую запись.
     *
     * @param CreateUserRequest $request
     * @param CreateUserAction $action
     *
     * @return UsersResource
     */
    public function create(CreateUserRequest $request, CreateUserAction $action): UsersResource
    {
        return new UsersResource($action->execute($request->validated()));
    }

    /**
     * Обновляет запись.
     *
     * @param int $id Значение первичного ключа.
     * @param UpdateUserRequest $request
     * @param UpdateUserAction $action
     *
     * @return UsersResource
     */
    public function update(int $id, UpdateUserRequest $request, UpdateUserAction $action):UsersResource
    {
        return new UsersResource($action->execute($id, $request->validated()));
    }

    /**
     * Формирует уникальный токен пользователя активной сессии системы.
     *
     * @param LoginUserRequest $request
     * @param LoginUserAction $action
     *
     * @return TokenResource
     */
    public function login(LoginUserRequest $request, LoginUserAction $action): TokenResource
    {
        return new TokenResource($action->execute($request->validated()));
    }

    /**
     *  Выходит из системы путём удаления токена сессии пользователя.
     *
     * @param LogoutUserAction $action
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function logout(LogoutUserAction $action, Request $request):JsonResponse
    {
        $action->execute($request->user());

        return response()->json(['message' => 'Logged Out', 'data' => []]);
    }

    /**
     * @param Request $request
     *
     * @return UsersResource
     */
    public function current(Request $request): UsersResource
    {
        return new UsersResource($request->user()->load('profile'));
    }
}

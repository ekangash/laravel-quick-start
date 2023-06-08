<?php

use App\Domain\Modules\Account\Models\User;
use function Pest\Laravel\{post};

const ROUTE_PASSWORD_EMAIL = 'password.email';
const ROUTE_PASSWORD_REQUEST = 'password.request';
const ROUTE_PASSWORD_RESET = 'password.reset';
const ROUTE_PASSWORD_RESET_SUBMIT = 'password.reset.submit';

const USER_ORIGINAL_PASSWORD = 'secret';

it('Должен отправить почтовое сообщение пользователю, если почтовый адрес определен в базе данных', function () {
    /** @var User $user */
    $user = User::factory()->create();
    $this->authorize($user);

    $response = post('/api/account/users/password/send-reset-notice', [
        'email' => $user->email,
    ]);
    $response->assertStatus(201);
});

it('Должен потерпеть неудачу при отправке почтовое сообщение пользователю, если почтовый адрес не определен в базе данных', function () {
    /** @var User $user */
    $user = User::factory()->make();

    $response = post('/api/account/users/password/send-reset-notice', [
        'email' => $user->email,
    ]);
    $response->assertStatus(418);
});

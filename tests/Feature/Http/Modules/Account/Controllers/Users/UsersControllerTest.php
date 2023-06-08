<?php

use App\Domain\Modules\Account\Models\User;
use Illuminate\Support\Arr;
use Nette\Utils\Json;
use function Pest\Laravel\{get, post, patch};

it('Должен зарегистрировать нового пользователя', function () {
    /** @var User $user */
    $user = User::factory()->make();
    $payload = ['email' => $user->email, 'password' => 'password'];

    $response = post('/api/account/users', $payload);
    $response->assertCreated();
    $this->assertDatabaseHas('account.users', ['email' => $user->email]);
});

it('Должен потерпеть неудачу, если учетная запись не авторизированна', function() {
    $this->withHeader('Authorization', "Bearer test");

    $response = get('/api/account/users/current');
    $response->assertUnauthorized();
});

it('Должен вернуть данные текущего авторизованного учетной записи', function() {
    /** @var User $user */
    $user = User::factory()->create();
    $this->authorize($user);

    $response = get('/api/account/users/current');
    $response->assertOk();
    $response->assertJsonFragment([$user->email]);
});

it('Должен обновить почтовый адрес авторизованной учетной записи', function() {
    /** @var User $user */
    $user = User::factory()->create();
    $this->authorize($user);
    $payload =  ['email' => 'adela@example.com'];

    $response = patch("/api/account/users/{$user->id}", $payload);
    $response->assertOk();
    $response->assertJsonFragment([$payload['email']]);
    $this->assertDatabaseHas('account.users', ['id' => $user->id, 'email' => $payload['email']]);
});

it('Должен авторизовать нового пользователя в систему и вернуть его токен', function() {
    /** @var User $user */
    $user = User::factory()->create();

    // Формирование нового токена
    $responseLogin = post("/api/account/users/login", [
        'email' => $user->email,
        'password' => 'secret',
        'token_name' => 'str'
    ]);
    $responseLogin->assertOk();
    $token = Arr::get(Arr::get(Json::decode($responseLogin->content(), true), 'data', []), 'token', '');
    expect($token)->not->toBeEmpty();
    $this->assertDatabaseHas('account.personal_access_tokens', ['tokenable_id' => $user->id]);

    // Проверка валидности токена
    $this->withHeader('Authorization', "Bearer $token");
    $response = get('/api/account/users/current');
    $response->assertOk();
    $response->assertJsonFragment([$user->email]);

    // Удаление токена
    $responseLogout = post('/api/account/users/logout');
    $responseLogout->assertOk();
    $responseLogout->assertJsonFragment(['Logged Out']);
    $this->assertDatabaseMissing('account.personal_access_tokens', ['tokenable_id' => $user->id]);
});

<?php

use App\Domain\Modules\Account\Models\User;
use function Pest\Laravel\{get, post};

beforeEach(function() {
    /** @var User $user */
    $user = User::factory()->create();
    $this->user = $user;
    $this->profile = $user->profile;
});

it('Должен получить пользователя по идентификатору', function () {
    $response = get("/api/account/profiles/{$this->profile->id}");

    $response->assertOk();
    $response->assertSee(['firstname' => $this->profile->firstname, 'lastname' => $this->profile->lastname]);
    $response->assertJsonFragment(['firstname' => $this->profile->firstname, 'lastname' => $this->profile->lastname]);

    $this->assertJson($response->getContent());
    $this->assertIsArray(json_decode($response->getContent(), true));
});

$payload = ['firstname' => 'Brendon', '_method' => 'PATCH'];

it('Должен пропустить обновление имени пользователя по идентификатору, если он не авторизирован', function () use($payload) {
    $response = post("/api/account/profiles/{$this->profile->id}", $payload);

    $response->assertUnauthorized();
    $this->assertDatabaseHas('account.profiles', ['id' => $this->profile->id, 'firstname' => $this->profile->firstname]);
});


it('Должен обновить имя пользователя по идентификатору, если он авторизирован', function () use($payload) {
    $this->authorize($this->user);

    $response = post("/api/account/profiles/{$this->profile->id}", $payload);

    $response->assertOk();
    $this->assertDatabaseHas('account.profiles', ['id' => $this->profile->id, 'firstname' => $payload['firstname']]);
});

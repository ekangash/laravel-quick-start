<?php

use App\Domain\Modules\Account\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

use function Pest\Laravel\{get, post};

it('Должен отправить уведомление на подтверждение почтового адреса', function () {
    /** @var User $user */
    $user = User::factory()->create();
    $this->authorize($user);
    Notification::fake();

    $response = get('/api/account/users/email/send-verification-notice');
    $response->assertStatus(201);

    Notification::assertSentTo($user,VerifyEmail::class,  function ($notification, $channels, $notifiableUser) use ($user) {
        return $notifiableUser->email === $user->email;
    });
});

it('Должен не отправлять уведомление на подтверждение почтового адреса', function () {
    /** @var User $user */
    $user = User::factory()->create(['email_verified_at' => Carbon::now()]);
    $this->authorize($user);
    Notification::fake();

    $response = get('/api/account/users/email/send-verification-notice');
    $response->assertStatus(200);
    $response->assertJsonFragment(['id' => $user->id, 'email_verified' => true, 'email_verified_at' => $user->email_verified_at]);

    Notification::assertNotSentTo($user,VerifyEmail::class);
});

it('Должен подтвердить адрес электронной почты по временной ссылки', function () {
    /** @var User $user */
    $user = User::factory()->create();

    $userEmailVerifyUrl = URL::temporarySignedRoute(
        'verification.verify',
        Carbon::now()->addMinutes(60),
        ['id' => $user->getKey(), 'hash' => sha1($user->getEmailForVerification())],
        false
    );

    $response = get($userEmailVerifyUrl);
    $response->assertStatus(200);
});

it('Должен вернуть 403 код не авторизированного пользователя, если временный маршрут истёк', function () {
    /** @var User $user */
    $user = User::factory()->create();

    $userEmailVerifyUrl = URL::temporarySignedRoute(
        'verification.verify',
        Carbon::now()->subMinutes(10),
        ['id' => $user->getKey(), 'hash' => sha1($user->getEmailForVerification())],
        false
    );

    $response = get($userEmailVerifyUrl);
    $response->assertStatus(403);
});


it('Должен вернуть 418 код, если почтовый адрес уже подтверждён', function () {
    /** @var User $user */
    $user = User::factory()->create(['email_verified_at' => Carbon::now()]);

    $userEmailVerifyUrl = URL::temporarySignedRoute(
        'verification.verify',
        Carbon::now()->addMinutes(60),
        ['id' => $user->getKey(), 'hash' => sha1($user->getEmailForVerification())],
        false
    );

    $response = get($userEmailVerifyUrl);
    $response->assertStatus(418);
});

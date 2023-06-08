<?php

namespace App\Providers;

use App\Domain\Modules\Account\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->overrideVerifyEmailUsing();
        $this->overrideResetPasswordUsing();
    }

    /**
     * @return void
     */
    private function overrideResetPasswordUsing()
    {
        ResetPassword::toMailUsing(function(User $notifiableUser, string $token) {
            $url = $this->buildSpaUrl('/auth/password/reset', [
                'token' => $token,
                'email' => $notifiableUser->getEmailForPasswordReset()
            ]);
            $urlExpired = Arr::get(config('auth.passwords.'.config('auth.defaults.passwords')), 'expire', 60);

            return (new MailMessage)
                ->subject('Уведомление о сбросе пароля')
                ->line('Вы получаете это электронное письмо, потому что мы получили запрос на сброс пароля для вашей учетной записи.')
                ->action('Сбросить пароль', $url)
                ->line("Срок действия этой ссылки для сброса пароля истечет через: $urlExpired")
                ->line(Lang::get('Если вы не запрашивали сброс пароля, никаких дальнейших действий не требуется.'));
        });
    }

    /**
     * @return void
     */
    private function overrideVerifyEmailUsing(): void
    {
        VerifyEmail::createUrlUsing(function(User $notifiableUser) {

            return URL::temporarySignedRoute(
                'verification.verify',
                Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
                [
                    'id' => $notifiableUser->getKey(),
                    'hash' => sha1($notifiableUser->getEmailForVerification()),
                ],
                false
            );
        });

        VerifyEmail::toMailUsing(function(User $notifiableUser, string $url) {
            parse_str(Arr::get(parse_url($url), 'query', ''), $params);

            return (new MailMessage())
                ->subject('Подтверждение почтового адреса')
                ->line('Нажмите на кнопку ниже, чтобы подтвердить свой адрес электронной почты.')
                ->action('Подтвердите адрес электронной почты', $url);
        });
    }

    /**
     * Формирует путь с параметрами до SPA приложения клиента.
     *
     * @param string $path Путь конечного маршрута
     * @param array $params Параметры строки запроса.
     *
     * @return string
     */
    private function buildSpaUrl(string $path, array $params = []): string
    {
        $separator = empty($params) ? '' : '?';

        return $path . $separator . Arr::query($params);
    }
}

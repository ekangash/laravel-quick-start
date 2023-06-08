<?php

namespace App\Domain\Modules\Account\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as UserAuthenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\NewAccessToken;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/**
 * App\Domain\Auth\Models\User
 *
 * @property int $id Идентификатор
 * @property string $email Почта
 * @property NewAccessToken $token Токен.
 * @property Carbon $email_verified_at Время верификации почты
 * @property string $password Пароль
 * @property Carbon $created_at Дата создания записи
 * @property Carbon $updated_at Дата обновления записи
 *
 * @property-read  Profile $profile
 * @property-read DatabaseNotification[] $notifications
 *
 * @property-read int|null $notifications_count
 *
 * @method static Builder newModelQuery()
 * @method static Builder newQuery()
 * @method static Builder query()
 * @method static Builder whereChannelId($value)
 * @method static Builder whereCreatedAt($value)
 * @method static Builder whereDescription($value)
 * @method static Builder whereId($value)
 * @method static Builder whereParentId($value)
 * @method static Builder wherePublishedAt($value)
 * @method static Builder whereQueue($value)
 * @method static Builder whereSign($value)
 * @method static Builder whereTitle($value)
 * @method static Builder whereUpdatedAt($value)
 *
 * @mixin Builder
 **/
class User extends UserAuthenticatable implements MustVerifyEmail, CanResetPasswordContract
{
    use HasApiTokens, HasFactory, Notifiable, CanResetPassword;

    /**
     * Заполняемые поля модели
     */
    const FILLABLE = [
        'email',
        'password',
        'confirmed_at',
        'email_verified_at',
    ];

    /**
     * {@inheritdoc}
     */
    protected $table = 'account.users';

    /**
     * {@inheritdoc}
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = self::FILLABLE;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = ['password'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = ['email_verified_at' => 'datetime'];

    /**
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = $value ? self::encryptPassword($value): null;
    }

    /**
     * @param $password
     *
     * @return string
     */
    public static function encryptPassword($password): string
    {
        return Hash::make($password);
    }

    /**
     * @param $password
     *
     * @return bool
     */
    public function checkPassword($password): bool
    {
        return Hash::check($password, $this->password);
    }

    /**
     * @return HasOne
     */
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class, 'user_id', 'id');
    }

    /**
     * @param string $email
     *
     * @return User|null
     */
    public static function findByEmail(string $email): ?User
    {
        return self::where('email', $email)->first();
    }
}

<?php

namespace App\Domain\Modules\Account\Models;

use App\Domain\Modules\Edition\Models\Channel;
use App\Domain\Modules\Edition\Models\Redactor;
use App\Domain\Model\AppModelWithMedia;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Domain\Modules\Account\Models\Profile
 *
 * @property int $id Идентификатор
 * @property string $firstname Имя
 * @property string $lastname Фамилия
 * @property int $user_id Идентификатор пользователя.
 * @property string $login Уникальный признак профиля
 * @property string $status Статус
 * @property array $overview Статус
 * @property string $cover Обложка
 * @property string $avatar Аватар
 * @property string $city Город.
 * @property string $country Страна.
 * @property string $gender Пол.
 * @property Carbon $birthday Дата рождения.
 * @property string $role Роль.
 * @property Carbon $confirmed_at Дата подтверждения пользователя
 * @property Carbon $created_at Дата создания записи
 * @property Carbon $updated_at Дата обновления записи
 *
 * @property-read Channel[] $channels
 * @property-read Friend $actedFriend
 * @property-read Friend $relatedFriend
 */
class Profile extends AppModelWithMedia
{
    /**
     * Заполняемые поля модели
     */
    const FILLABLE = [
        'user_id',
        'role',
        'firstname',
        'lastname',
        'overview',
        'status',
        'city',
        'login',
        'country',
        'gender',
        'birthday',
        'confirmed_at',
        'cover',
        'avatar'
    ];

    /**
     * @inheritdoc
     */
    protected $casts = [
        'overview' => 'json',
    ];

    /**
     * {@inheritdoc}
     */
    protected $table = 'account.profiles';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = self::FILLABLE;

    /**
     * @return HasMany
     */
    public function channels():HasMany
    {
        return $this->hasMany(Channel::class);
    }

    /**
     * @return HasMany
     */
    public function friends(): HasMany
    {
        return $this->hasMany(Friend::class, 'acted_profile_id', 'id')
            ->whereNotNull('confirmed_at')
            ->whereNotNull('related_friend_id');
    }

    /**
     * @param Builder $query
     * @param $value
     *
     * @return Builder
     */
    public function scopeFullname(Builder $query, $value): Builder
    {
        return $query
            ->orWhere('firstname', 'ilike', "%$value%")
            ->orWhere('lastname', 'ilike', "%$value%");
    }

    /**
     * @param Builder $query
     * @param $channelId
     *
     * @return Builder
     */
    public function scopeByChannel(Builder $query, $channelId):Builder
    {
        $profileIdsBelongsToChannel = Redactor::select('profile_id')->where('channel_id', $channelId)->get();
        //where('confirmed_at', 'is not', null)

        return $query->whereIn('id', $profileIdsBelongsToChannel);
    }

    /**
     * @param Builder $query
     * @param ...$ids
     *
     * @return Builder
     */
    public function scopeNotInIds(Builder $query, ...$ids):Builder
    {
        return $query->whereNotIn('id', $ids);
    }
}

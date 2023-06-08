<?php

namespace App\Domain\Model;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;

/**
 * App\Domain\Modules\Public\Models\AppModel
 *
 * @property-read DatabaseNotification[] $notifications
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
 */
class AppModel extends Model
{
    use HasFactory, Notifiable;

    const FILLABLE = [];

    /**
     * Ищет и удаляет модель по ее первичному ключу или создаёт исключение.
     *
     * @param int $id Значение первичного ключа.
     *
     * @return bool|null
     *
     * @throws ModelNotFoundException
     */
    public static function fiendOrFailAndDelete(int $id): ?bool
    {
        $model = static::findOrFail($id);

        return $model->delete();
    }

    /**
     * Формирует запись с заполняемыми полями.
     *
     * @param array $attributes Атрибуты записи.
     *
     * @return $this
     */
    public static function createWithFillable(array $attributes = []): static
    {
        return static::create(Arr::only($attributes, static::FILLABLE));
    }

    /**
     * Обновляет запись с заполняемыми полями.
     *
     * @param int $id Значение первичного ключа.
     * @param array $attributes Атрибуты записи.
     *
     * @return bool
     *
     * @throws ModelNotFoundException
     */
    public static function updateWithFillable(int $id, array $attributes): bool
    {
        return static::findOrFail($id)->update(Arr::only($attributes, static::FILLABLE));
    }

    /**
     * Заполняет запись с заполняемыми полями.
     *
     * @param array $attributes Атрибуты записи.
     *
     * @return $this
     */
    public function fillWithFillable(array $attributes): static
    {
        return $this->fill(Arr::only($attributes, static::FILLABLE));
    }

    /**
     * Проверяет, определена ли запись.
     *
     * @param int|array|Closure $condition Условия фильтрации.
     *
     * @return bool
     */
    public static function defined(int|array|Closure $condition):bool
    {
        if (is_array($condition)){
            $receivedResponse = static::where($condition)->exists();
        } else if (is_int($condition)) {
            $receivedResponse = static::where('id', $condition)->exists();
        } else if ($condition instanceof Closure) {
            $receivedResponse = static::where($condition)->exists();
        } else {
            $receivedResponse = false;
        }

        return $receivedResponse;
    }
}

<?php

namespace App\Domain\Modules\Public\Models;

use Carbon\Carbon;
use App\Domain\Model\AppModelWithMedia;

/**
 * App\Domain\Modules\Public\Models\Topic
 *
 * @property int $id Идентификатор
 * @property string $title Заголовок
 * @property string $description Описание
 * @property string $sign Уникальный признак
 * @property string cover Ссылка к ресурсу обложки
 * @property int $queue Очередь
 * @property int $parent_id Идентификатор родительской категории
 * @property Carbon $created_at Дата создания записи
 * @property Carbon $updated_at Дата обновления записи
 */
class Topic extends AppModelWithMedia
{
    /**
     * @inheritdoc
     */
    protected $table = 'topics';

    /**
     * Заполняемые поля модели
     */
    const FILLABLE = [
        'title',
        'sign',
        'description',
        'parent_id',
        'queue',
        'cover'
    ];

    const MEDIA = ['cover', 'description'];

    /**
     * @inheritdoc
     */
    protected $casts = [
        'description' => 'array',
    ];

    /**
     * @var array
     */
    protected $fillable = self::FILLABLE;
}

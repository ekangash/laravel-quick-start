<?php

use App\Domain\Modules\Public\Models\Topic;
use Illuminate\Http\UploadedFile;

test('Должен загрузить изображение', function () {
    $coverFileName = 'under.jpg';
    $cover = UploadedFile::fake()->image($coverFileName);

    /** @var Topic $topic */
    $topic = Topic::factory()->create();
    $uploadedMediaUrl = $topic->uploadMedia('cover', $cover);

    $this->assertDatabaseHas('public.media', ['file_name' => $coverFileName]);
    expect($topic->getFirstMediaUrl('cover'))->toBe($uploadedMediaUrl);
});

test('Должен пропустить загрузку несуществующего изображения', function () {
    /** @var Topic $topic */
    $topic = Topic::factory()->create();
    $uploadedMedia = $topic->uploadMedia('cover', '');

    $this->assertDatabaseMissing('public.media', ['file_name' => 'under.jpg']);
    expect($uploadedMedia)->toBeNull();
});


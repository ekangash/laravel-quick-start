<?php

use App\Domain\Modules\Public\Models\Topic;
use Illuminate\Http\UploadedFile;

test('Должен создать тему и загрузить изображения, а затем файлы и тему', function () {
    $fields =  [
        "title" => "LEAN",
        "description" => [
            ["type" => "paragraph", "children" => [["text" => "Развлечение — деятельность ради удовольствия, проведение досуга."]]],
            ["type" => "image", "children" => [["text" => "Удовольствия, проведение досуга.", "src" => UploadedFile::fake()->image('mountain.jpg')]]],
            ["type" => "image", "children" => [["text" => "Подпись под картинкой описывающее сюжет", "src" => UploadedFile::fake()->image('thumbnail.jpg')]]]
        ],
        "sign" => "lean",
        "queue" => "0",
        "cover" => UploadedFile::fake()->image('cover.jpg')
    ];

    /** @var Topic $topic */
    $topic = Topic::createWithFillableAndUploadMedia($fields);

    $this->assertDatabaseHas('public.media', ['model_id' => $topic->id, 'file_name' => 'mountain.jpg']);
    $this->assertDatabaseHas('public.media', ['model_id' => $topic->id, 'file_name' => 'thumbnail.jpg']);
    $this->assertDatabaseHas('public.media', ['model_id' => $topic->id, 'file_name' => 'cover.jpg']);

    expect(Topic::deleteAndClearMedia($topic->id))->toBeTrue();

    $this->assertDatabaseMissing('public.media', ['model_id' => $topic->id, 'file_name' => 'mountain.jpg']);
    $this->assertDatabaseMissing('public.media', ['model_id' => $topic->id, 'file_name' => 'thumbnail.jpg']);
    $this->assertDatabaseMissing('public.media', ['model_id' => $topic->id, 'file_name' => 'cover.jpg']);
});

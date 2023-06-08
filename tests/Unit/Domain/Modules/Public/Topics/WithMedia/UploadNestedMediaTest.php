<?php

use App\Domain\Modules\Public\Models\Topic;
use App\Support\Helpers\Fls;
use Illuminate\Http\UploadedFile;

test('Должен загрузить изображения из вложенной структуре данных', function () {
    $original = [
        ["type" => "paragraph", "children" => [["text" => "Развлечение — деятельность ради удовольствия, проведение досуга."]]],
        ["type" => "image", "src" => UploadedFile::fake()->image('mountain.jpg'), "children" => [["text" => "Удовольствия, проведение досуга."]]],
        ["type" => "image", "src" => UploadedFile::fake()->image('thumbnail.jpg'), "children" => [["text" => "Подпись под картинкой описывающее сюжет"]]]
    ];

    /** @var Topic $topic */
    $topic = Topic::factory()->create();
    $uploadedOriginal = $topic->uploadNestedMedia('description', $original);

//    $expected = [
//        ["type" => "paragraph", "children" => [["text" => "Развлечение — деятельность ради удовольствия, проведение досуга."]]],
//        ["type" => "image", "src" => '/media-trash/{media_id}/mountain.jpg', "children" => [["text" => "Удовольствия, проведение досуга."]]],
//        ["type" => "image", "src" => '/media-trash/{media_id}/thumbnail.jpg', "children" => [["text" => "Подпись под картинкой описывающее сюжет"]]]
//    ];

    expect(Fls::hasUploadedFile($uploadedOriginal))->toBeFalse();
    expect($uploadedOriginal)->toBeArray();
    expect($uploadedOriginal)->not->toBeEmpty();
    $this->assertDatabaseHas('public.media', ['file_name' => 'mountain.jpg']);
    $this->assertDatabaseHas('public.media', ['file_name' => 'thumbnail.jpg']);
});

test('Должен не изменять исходную структуру данных, если нет доступных изображений для загрузки', function () {
    $original = [
        ["type" => "paragraph", "children" => [["text" => "Развлечение — деятельность ради удовольствия, проведение досуга."]]],
        ["type" => "image", "src" => '/media-trash/1/mountain.jpg', "children" => [["text" => "Удовольствия, проведение досуга."]]],
        ["type" => "image", "src" => '/media-trash/2/thumbnail.jpg', "children" => [["text" => "Подпись под картинкой описывающее сюжет"]]]
    ];

    /** @var Topic $topic */
    $topic = Topic::factory()->create();
    $uploadedOriginal = $topic->uploadNestedMedia('description', $original);

    expect($uploadedOriginal)->toEqual($original);
});

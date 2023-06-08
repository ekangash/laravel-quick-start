<?php

use Illuminate\Http\UploadedFile;
use App\Support\Helpers\Fls;

it('Должен утверждать, что вложенная структура имеет файлом загрузки', function() {
    $structure =  [
        "title" => "LEAN",
        "description" => [
            ["type" => "paragraph", "children" => [["text" => "Развлечение — деятельность ради удовольствия, проведение досуга."]]],
            ["type" => "image", "children" => [["text" => "Удовольствия, проведение досуга.", "src" => UploadedFile::fake()->image('mountain.jpg')]]],
            ["type" => "image", "children" => [["text" => "Подпись под картинкой описывающее сюжет", "src" => UploadedFile::fake()->image('thumbnail.jpg')]]]
        ],
        "sign" => "lean",
        "queue" => "0",
        "cover" => "/media/26/03b35a17-46ac-42c4-abe5-37b9b7ca2e88.jpe"
    ];

    expect(Fls::hasUploadedFile($structure))->toBeTrue();
});


it('Должен утверждать, что вложенная структура не имеет файл загрузки', function() {
    $structure =  [
        "title" => "LEAN",
        "description" => [["type" => "paragraph", "children" => [["text" => "Развлечение — деятельность ради удовольствия, проведение досуга."]]]],
        "sign" => "lean",
        "queue" => "0",
        "cover" => "/media/26/03b35a17-46ac-42c4-abe5-37b9b7ca2e88.jpe"
    ];

    expect(Fls::hasUploadedFile($structure))->toBeFalse();
});

it('Должен утверждать, что структура является файлом загрузки', function() {
    $structure = UploadedFile::fake()->image('mountain.jpg');

    expect(Fls::hasUploadedFile($structure))->toBeTrue();
});


it('Должен утверждать, что структура не является файлом загрузки', function() {
    $structure = [null, [], false, true, '', 0];

    foreach ($structure as $item) {
        expect(Fls::hasUploadedFile($item))->toBeFalse();
    }

});

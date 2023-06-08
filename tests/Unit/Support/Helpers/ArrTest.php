<?php

use App\Support\Helpers\Arr;

it('Должно вернуть значения свойств, вложенной структуры', function() {
    $structure =  [
        ["type" => "paragraph", "children" => [["text" => "Развлечение — деятельность ради удовольствия, проведение досуга."]]],
        ["type" => "image", "children" => [["text" => "Удовольствия, проведение досуга.", "src" => "/media/39/03b35a17-46ac-42c4-abe5-37b9b7ca2e88.jpe"]]],
        ["type" => "image", "children" => [["text" => "Подпись под картинкой описывающее сюжет", "src" => "/media/40/03b35a17-46ac-42c4-abe5-37b9b7ca2e88.jpe"]]]
    ];

    $expect = ["/media/39/03b35a17-46ac-42c4-abe5-37b9b7ca2e88.jpe", "/media/40/03b35a17-46ac-42c4-abe5-37b9b7ca2e88.jpe"];

    expect(Arr::onlyFromNested($structure, ['src']))->toEqual($expect);
});

it('Должно вернуть пустое значение, вложенной структуры если нет совпадений', function() {
    $structure =  [
        ["type" => "paragraph", "children" => [["text" => "Развлечение — деятельность ради удовольствия, проведение досуга."]]],
        ["type" => "image", "children" => [["text" => "Удовольствия, проведение досуга.", "src" => "/media/39/03b35a17-46ac-42c4-abe5-37b9b7ca2e88.jpe"]]],
        ["type" => "image", "children" => [["text" => "Подпись под картинкой описывающее сюжет", "src" => "/media/40/03b35a17-46ac-42c4-abe5-37b9b7ca2e88.jpe"]]]
    ];

    $expect = [];

    expect(Arr::onlyFromNested($structure, ['href']))->toEqual($expect);
});

it('Должно исключить переданные ключи из массива', function() {
    $structure = [
        "title" => "LEAN",
        "description" => [
            ["type" => "paragraph", "children" => [["text" => "Развлечение — деятельность ради удовольствия, проведение досуга."]]],
        ],
        "sign" => "lean",
        "queue" => "0",
        "cover" => null
    ];

    $expect = [
        "title" => "LEAN",
        "description" => [
            ["type" => "paragraph", "children" => [["text" => "Развлечение — деятельность ради удовольствия, проведение досуга."]]],
        ],
        "queue" => "0",
    ];

    expect(Arr::omit($structure, ['cover', 'sign']))->toEqual($expect);
});


it('Должно не изменять исходную структуру, если не передавать не одного имени ключа', function() {
    $structure = [
        "title" => "LEAN",
        "description" => [
            ["type" => "paragraph", "children" => [["text" => "Развлечение — деятельность ради удовольствия, проведение досуга."]]],
        ],
        "sign" => "lean",
        "queue" => "0",
        "cover" => null
    ];

    expect(Arr::omit($structure, []))->toEqual($structure);
});

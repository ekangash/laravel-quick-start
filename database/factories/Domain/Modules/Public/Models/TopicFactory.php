<?php

namespace Database\Factories\Domain\Modules\Public\Models;

use App\Domain\Modules\Public\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

/**
 * Class TopicFactory
 *
 * @package Database\Factories\Domain\Public\Models
 */
class TopicFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Topic::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "title" => $this->faker->title(),
            "description" => [
                ["type" => "paragraph", "children" => [["text" => "Развлечение — деятельность ради удовольствия, проведение досуга."]]],
                ["type" => "image", "children" => [["text" => "Удовольствия, проведение досуга.", "src" => null]]],
                ["type" => "image", "children" => [["text" => "Подпись под картинкой описывающее сюжет", "src" => null]]]
            ],
            "sign" => "lean",
            "queue" => "0",
            "cover" => null
        ];
    }
}

<?php

use App\Domain\Modules\Public\Models\Topic;
use Illuminate\Http\UploadedFile;
use function Pest\Laravel\{get, post, delete};

beforeEach(function() {
   $this->attributes = [
       "title" => "LEAN",
       "description" => [
           ["type" => "paragraph", "children" => [["text" => "Развлечение — деятельность ради удовольствия, проведение досуга."]]],
           ["type" => "image", "children" => [["text" => "Удовольствия, проведение досуга.", "src" => UploadedFile::fake()->image('mountain.jpg')]]],
           ["type" => "image", "children" => [["text" => "Подпись под картинкой описывающее сюжет", "src" => UploadedFile::fake()->image('thumbnail.jpg')]]]
       ],
       "sign" => "lean",
       "queue" => "0",
       "cover" => UploadedFile::fake()->image('thumbnail.jpg')
   ];
});

test('Должен сформировать новую тему', function () {
    $response = post("/api/topics", $this->attributes);
    $response->assertCreated();
});

it('Должен получить тему по идентификатору', function () {
    /** @var Topic $topic */
    $topic = Topic::factory()->create();
    $response = get("/api/topics/{$topic->id}");

    $response->assertOk();
    $response->assertSee(['cover' => $topic->cover, 'title' => $topic->title]);
    $response->assertJsonFragment(['cover' => $topic->cover, 'title' => $topic->title]);

    $this->assertJson($response->getContent());
    expect(empty($response->json()))->toBeFalse();
});

it('Должен обновить заголовок темы', function () {
    $topic = Topic::createWithFillableAndUploadMedia($this->attributes);

    expect($topic->title)->toBe($this->attributes['title']);
    $this->assertDatabaseHas('public.topics', ['title' => $topic->title]);

    $topicUpdateTitle = 'Над пропастью во ржи';
    $response = post("/api/topics/{$topic->id}", ['_method' => 'PATCH', 'title' => $topicUpdateTitle]);
    $response->assertOk();
    $this->assertDatabaseHas('public.topics', ['id' => $topic->id, 'title' => $topicUpdateTitle]);
});

$payload = ['firstname' => 'Brendon', '_method' => 'PATCH'];

it('Должен удалить тему и все его медиа файлы', function () {
    $topic = Topic::createWithFillableAndUploadMedia($this->attributes);
    $this->assertDatabaseHas('public.topics', ['id' => $topic->id, 'title' => $topic->title]);

    $response = delete("/api/topics/{$topic->id}");
    $response->assertOk();

    $this->assertDatabaseMissing('public.topics', ['id' => $topic->id, 'title' => $topic->title]);
});

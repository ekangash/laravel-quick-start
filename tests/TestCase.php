<?php

namespace Tests;

use Illuminate\Notifications\Notification;
use App\Domain\Modules\Account\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

/**
 * @method void assertViewIs(string $view)
 * @method void assertViewHas(string|array $key, mixed $value = null)
 * @method void assertViewMissing(string $key)
 * @method void assertViewHasAll(array $bindings)
 * @method void assertViewCollection(string $view, \Illuminate\Support\Collection|array $data)
 * @method void assertViewCount(string $view, int $count)
 * @method void assertJsonFragment(array $data, $response = null)
 * @method void assertJsonMissing(array $data, $response = null)
 * @method void assertJsonMissingExact(array $data, $response = null)
 * @method void assertJsonStructure(array $structure = null, $responseData = null, $negate = false)
 * @method void assertJson($actual, $response = null)
 * @method void assertJsonStringEqualsJsonString($expectedJson, $actualJson, $message = '')
 * @method void assertJsonStringNotEqualsJsonString($expectedJson, $actualJson, $message = '')
 * @method void assertJsonStringEqualsJsonFile($expectedFile, $actualJson, $message = '')
 * @method void assertJsonStringNotEqualsJsonFile($expectedFile, $actualJson, $message = '')
 * @method void assertJsonFileEqualsJsonFile($expectedFile, $actualFile, $message = '')
 * @method void assertJsonFileNotEqualsJsonFile($expectedFile, $actualFile, $message = '')
 * @method void assertSuccessful($response = null)
 * @method void assertOk($response = null)
 * @method void assertNotFound($response = null)
 * @method void assertForbidden($response = null)
 * @method void assertUnauthorized($response = null)
 * @method void assertRedirect($uri, $response = null)
 * @method void assertHeader($headerName, $value = null, $response = null)
 * @method void assertCookie($cookieName, $value = null, $response = null)
 * @method void assertPlainCookie($cookieName, $value = null, $response = null)
 * @method void assertCookieExpired($cookieName, $response = null)
 * @method void assertCookieNotExpired($cookieName, $response = null)
 * @method void assertCookieMissing($cookieName, $response = null)
 * @method void assertDatabaseHas($table, array $data, string $connection = null)
 * @method void assertDatabaseMissing($table, array $data, string $connection = null)
 * @method void assertSoftDeleted($table, array $data, string $connection = null)
 * @method void assertNotSoftDeleted($table, array $data, string $connection = null)
 * @method void assertSessionHas($key, $value = null)
 * @method void assertSessionHasAll(array $bindings)
 * @method void assertSessionMissing($key)
 * @method void assertExactHtml($expectedHtml, $actualHtml, $message = '')
 * @method void assertHtmlStringEqualsHtmlString($expectedHtml, $actualHtml, $message = '')
 * @method void assertHtmlStringNotEqualsHtmlString($expectedHtml, $actualHtml, $message = '')
 * @method void assertSelectorExists($selector, $actualHtml, $negate = false)
 * @method void assertSelectorNotExists($selector, $actualHtml)
 * @method void assertSee($value, $escaped = true)
 * @method void assertDontSee($value, $escaped = true)
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Авторизовывает учетную запись в систему.
     *
     * @param User|null $user
     *
     * @return void
     */
    public function authorize(User $user = null): void {
        $user = $user ?? User::factory()->create();
        $token = $user->createToken('secret');
        $this->actingAs($user);
        $this->withHeader('Authorization', "Bearer $token->plainTextToken");
    }
}


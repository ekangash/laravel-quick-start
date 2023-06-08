<?php

namespace Database\Factories\Domain\Modules\Account\Models;

use App\Domain\Modules\Account\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class UserFactory
 *
 * @package Database\Factories\Domain\Account\Models
 */
class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => null,
            'role' => null,
            'password' => 'secret', // password
        ];
    }

    /**
     * @return UserFactory
     */
    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            $user->profile()->create([
                'firstname' => $this->faker->firstName(),
                'lastname' => $this->faker->lastName(),
                'overview' => $this->faker->words(),
                'user_id' => $user->id,
            ]);
        });
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return Factory
     */
    public function unverified(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}

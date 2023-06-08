<?php


namespace Database\Seeders;

use App\Domain\Modules\Account\Models\User;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Class AccountUsersTableSeeder
 * @package Database\Seeders
 */
class AccountUsersTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        User::create(array(
            'email' => 'alexwsears@gmail.com',
            'first_name' => 'Alex',
            'last_name' => 'Sears',
            'password' => Hash::make('secret')
        ));

        User::create(array(
            'email' => 'george@foreman.com',
            'first_name' => 'George',
            'last_name' => 'Foreman',
            'password' => Hash::make('secret')
        ));

        User::create(array(
            'email' => 'tony@thetiger.com',
            'first_name' => 'Tony',
            'last_name' => 'Tiger',
            'password' => Hash::make('secret')
        ));

        User::create(array(
            'email' => 'fred@flintstone.com',
            'first_name' => 'Fred',
            'last_name' => 'Flintstone',
            'password' => Hash::make('secret')
        ));
    }

}

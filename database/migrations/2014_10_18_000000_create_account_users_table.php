<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateAccountUsersTable
 */
class CreateAccountUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account.users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email', 100)->unique()->comment('Почтовый адрес');
            $table->integer('role')->nullable()->comment('Роль аккаунта');
            $table->timestamp('email_verified_at')->nullable()->comment('Дата подтверждения почтового адреса');
            $table->string('password')->comment('Пароль');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account.users');
    }
}

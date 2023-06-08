<?php

use App\Domain\Modules\Account\Enums\ProfileRoles;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateAccountProfilesTable
 */
class CreateAccountProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account.profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unique()->comment('Идентификатор пользователя');
            $table->string('firstname', 100)->nullable()->comment('Имя');
            $table->string('lastname', 100)->nullable()->comment('Фамилия');
            $table->string('login', 100)->nullable()->unique()->comment('Уникальный признак аккаунта');
            $table->text('status')->nullable()->comment('Статус');
            $table->jsonb('overview')->nullable()->comment('Краткая информация');
            $table->text('cover')->nullable()->comment('Обложка');
            $table->text('avatar')->nullable()->comment('Аватарка');
            $table->string('role', 100)->default(ProfileRoles::getElias(ProfileRoles::READER))->comment('Роль');
            $table->string('city', 100)->nullable()->comment('Город');
            $table->string('country', 100)->nullable()->comment('Страна');
            $table->string('gender', 100)->nullable()->comment('Пол');
            $table->timestamp('birthday', 100)->nullable()->comment('Дата рождения');
            $table->timestamp('confirmed_at', 100)->nullable()->comment('Дата подтверждения пользователя');
            $table->timestamp('last_activity_at')->nullable()->comment('Дата последней активности');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account.profiles');
    }
}

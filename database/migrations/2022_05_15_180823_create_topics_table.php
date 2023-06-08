<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateTopicsTable
 */
class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Заголовок темы');
            $table->jsonb('description')->nullable()->comment('Описание подробностей');
            $table->string('sign', 100)->nullable()->unique()->comment('Уникальный признак');
            $table->text('cover')->nullable()->comment('Обложка');
            $table->integer('queue')->default(0)->comment('Очередь');
            $table->integer('parent_id')->nullable()->default(null)->comment('Идентификатор родительской темы');
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
        Schema::dropIfExists('topics');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaggablesTable extends Migration
{
    public function up()
    {
        Schema::create('taggables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tag_id');
            $table->unsignedBigInteger('taggable_id');
            $table->string('taggable_type');
            $table->timestamps();

            $table->unique(['tag_id', 'taggable_id', 'taggable_type']);

            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
            $table->foreign('taggable_id')->references('id')->on('articles')->onDelete('cascade');
            // Замените 'articles' на имя вашей таблицы для статей
            // Также, убедитесь, что у вас есть таблица 'tags' для хранения тегов.
        });
    }

    public function down()
    {
        Schema::dropIfExists('taggables');
    }
}

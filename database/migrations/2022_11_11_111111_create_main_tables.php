<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateMainTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('main_wallpapers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->index();
            $table->integer('user_id')->index()->nullable();
            $table->text('name');
            $table->text('url')->nullable();
            $table->integer('views')->default(0);
            $table->integer('downloads')->default(0);
            $table->integer('likes')->default(0);
            $table->integer('date_create')->index();
        });

        Schema::create('main_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('link', 100)->unique();
        });

        Schema::create('main_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('link', 100)->unique();
        });

        Schema::create('main_wallpapers_tags_options', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('wallpaper_id')->index();
            $table->integer('tag_id')->index();
        });

        $categories = [
            [
                'name' => 'Топ картинок',
                'link' => 'top-kartinok',
            ],
            [
                'name' => 'Самые популярные',
                'link' => 'samie-populyarnie',
            ],
            [
                'name' => 'Топ скачиваемых',
                'link' => 'top-skachivaemih',
            ],
            [
                'name' => 'Машины',
                'link' => 'mashini',
            ],
            [
                'name' => 'Аниме',
                'link' => 'anime',
            ],
            [
                'name' => 'Девушки',
                'link' => 'devushki',
            ],
            [
                'name' => 'Эстетичные',
                'link' => 'estetichnie',
            ],
            [
                'name' => 'Фильмы',
                'link' => 'filmi',
            ],
            [
                'name' => 'Мультфильмы',
                'link' => 'multfilmi',
            ],
            [
                'name' => 'Игры/Геймерские',
                'link' => 'igri-geymerskie',
            ],
            [
                'name' => 'Символика',
                'link' => 'simvolika',
            ],
        ];
        DB::table('main_categories')->insert($categories);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('main_wallpapers');
        Schema::dropIfExists('main_categories');
        Schema::dropIfExists('main_tags');
        Schema::dropIfExists('main_wallpapers_tags_options');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalleriesAndImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('title');
            $table->timestamps();

            /*
             * Foreign key to table users to know the author of the gallery.
             */
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade');
        });

        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent')->unsigned()->nullable()->default(null);
            $table->integer('user_id')->unsigned();
            $table->integer('post_id')->unsigned()->nullable()->default(null);
            $table->integer('gallery_id')->unsigned()->nullable()->default(null);
            $table->string('title');
            $table->string('image');
            $table->enum('size', ['original', 'thumbnail', 'featured', 'featured_thumbnail']);
			$table->integer('width')->unsigned()->nullable()->default(null);
			$table->integer('height')->unsigned()->nullable()->default(null);
            $table->integer('order');
            $table->timestamps();

            /**
             * Foreign key to table images to know the parent.
             */
            $table->foreign('parent')
                ->references('id')
                ->on('images')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            /*
             * Foreign key to table users to know who has uploaded the image.
             */
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade');

            /*
             * Foreign key to table posts to know the post where the image has been uploaded.
             */
            $table->foreign('post_id')
                ->references('id')
                ->on('posts')
                ->onUpdate('cascade');

            /*
             * Foreign key to table galleries to know the gallery where the image has been uploaded.
             */
            $table->foreign('gallery_id')
                ->references('id')
                ->on('galleries')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
        Schema::dropIfExists('galleries');
    }
}

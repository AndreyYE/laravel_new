<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertAdvertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advert_adverts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedInteger('region_id')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('advert_categories')->onDelete('cascade');
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');

            $table->string('title');
            $table->integer('price');
            $table->text('address');
            $table->text('content');
            $table->string('reject_reason')->nullable();
            $table->string('status',16);
            $table->integer('view')->nullable()->default(null);
            $table->integer('click')->nullable()->default(null);
            $table->boolean('promotion')->nullable()->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
        Schema::create('advert_advert_values', function(Blueprint $table){
            $table->unsignedInteger('advert_id');
            $table->unsignedInteger('attribute_id');

            $table->foreign('advert_id')->references('id')->on('advert_adverts')->onDelete('cascade');
            $table->foreign('attribute_id')->references('id')->on('advert_attributes')->onDelete('cascade');


            $table->string('value');
            $table->primary(['advert_id','attribute_id']);
        });
        Schema::create('advert_advert_photos', function(Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('advert_id');

            $table->foreign('advert_id')->references('id')->on('advert_adverts')->onDelete('cascade');

            $table->string('file');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('advert_adverts');
        Schema::dropIfExists('advert_advert_values');
        Schema::dropIfExists('advert_advert_photos');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

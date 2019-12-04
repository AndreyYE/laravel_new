<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advert_favorites', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('advert_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->foreign('advert_id')->references('id')->on('advert_adverts')->onDelete('CASCADE');

            $table->primary(['user_id','advert_id']);
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
        Schema::dropIfExists('advert_favorites');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDialogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dialogs', function (Blueprint $table) {
           $table->bigIncrements('id');

            $table->unsignedInteger('advert_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('client_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('advert_id')->references('id')->on('advert_adverts')->onDelete('cascade');

            $table->integer('user_new_messages')->default(0);
            $table->integer('client_new_messages')->default(0);
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
//        Schema::table('dialogs',function (Blueprint $table){
//            $table->dropForeign('user_id');
//            $table->dropForeign('client_id');
//        });
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('dialogs');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

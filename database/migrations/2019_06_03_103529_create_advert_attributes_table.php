<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advert_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('type');
            $table->unsignedBigInteger('category_id');
            $table->boolean('required');
            $table->json('variants');
            $table->integer('sort');
        });
        Schema::table('advert_attributes',function(Blueprint $table){
            $table->foreign('category_id')->references('id')->on('advert_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::table('advert_attributes',function(Blueprint $table){
//            $table->dropForeign('category_id');
//        });
        Schema::dropIfExists('advert_attributes');
    }
}

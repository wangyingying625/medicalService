<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndicatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indicators', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_en',30)->nullable();
            $table->string('name_ch',10)->nullable();
            $table->string('unit',20)->nullable();
            $table->double('upper_limit')->nullable();
            $table->double('lower_limit')->nullable();
            $table->double('value')->nullable();
            $table->integer('image_id');
            $table->boolean('important')->default(false);
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
        Schema::dropIfExists('indicators');
    }
}

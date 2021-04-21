<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSelectParamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('select_params', function (Blueprint $table) {
            $table->id();
            $table->string('param_name_ar')->nullable();
            $table->string('param_name_en')->nullable();
            $table->unsignedBigInteger('param_id')->nullable();

            $table->foreign('param_id')->references('id')->on('cat_parameters')->onDelete('cascade');
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
        Schema::dropIfExists('select_params');
    }
}

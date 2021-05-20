<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();
            $table->string('auction_title')->nullable();
            $table->unsignedBigInteger('member_id')->nullable();
            $table->decimal('price',8,2)->nullable();
            $table->string('address')->nullable();
            $table->decimal('price_opining',8,2)->nullable();
            $table->decimal('price_closing',8,2)->nullable();
            $table->date('start_data')->nullable();
            $table->date('end_data')->nullable();
            $table->text('detials',8,2)->nullable();
            $table->string('status')->nullable()->default(0);
            $table->boolean('is_slider')->nullable()->default(0);
            $table->text('desc_ar')->nullable();
            $table->text('desc_en')->nullable();
            $table->boolean('is_finished')->nullable()->default(0);
            $table->boolean('share_location')->nullable()->default(0);
            $table->unsignedBigInteger('cat_id')->nullable();
            $table->unsignedBigInteger('type_id')->nullable();
            $table->unsignedBigInteger('gover_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();

            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('cat_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('auction_types')->onDelete('cascade');
            $table->foreign('gover_id')->references('id')->on('governorates')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
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
        Schema::dropIfExists('auctions');
    }
}

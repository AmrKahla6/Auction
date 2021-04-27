<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id')->nullable();
            $table->unsignedBigInteger('auction_id')->nullable();
            $table->decimal('price',8,2)->nullable();
            $table->boolean('is_winner')->nullable()->default(0);
            $table->boolean('is_finished')->nullable()->default(0);
            $table->string('endData')->nullable();

            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('auction_id')->references('id')->on('auctions')->onDelete('cascade');
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
        Schema::dropIfExists('tenders');
    }
}

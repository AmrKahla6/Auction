<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('username')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('password')->nullable();
            $table->string('img')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('commercial_record')->nullable();
            $table->string('id_number')->nullable();
            $table->string('type')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('forgetcode')->nullable();
            $table->string('activation_code')->nullable();
            $table->rememberToken()->nullable();

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
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
        Schema::dropIfExists('members');
    }
}

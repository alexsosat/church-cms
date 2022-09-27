<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('user_from_id')->unsigned();
            $table->foreign('user_from_id')->references('id')->on('users')->onDelete('cascade');

            $table->bigInteger('user_to_id')->unsigned();
            $table->foreign('user_to_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('requests');
    }
};

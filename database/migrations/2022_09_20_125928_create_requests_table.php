<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();

            // 1-> Sending, 2-> Receiving
            $table->integer('type')->unsigned();

            // 1-> Accepted, 0 -> Rejected, 2 -> Pending, 3-> Cancelled
            $table->integer('status')->unsigned();

            $table->bigInteger('member_id')->unsigned();
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');


            $table->bigInteger('requesting_user_id')->unsigned();
            $table->foreign('requesting_user_id')->references('id')->on('users')->onDelete('cascade');

            $table->bigInteger('authorizing_user_id')->unsigned();
            $table->foreign('authorizing_user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('requests');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQueryMessagesTable extends Migration
{
    public function up()
    {
        Schema::create('query_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reference')->unique();
            $table->string('type')->nullable();
            $table->longText('message')->nullable();
            $table->integer('tokens')->nullable();
            $table->string('ai_model')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}

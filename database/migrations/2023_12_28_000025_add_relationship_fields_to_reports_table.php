<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToReportsTable extends Migration
{
    public function up()
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->unsignedBigInteger('query_id')->nullable();
            $table->foreign('query_id', 'query_fk_9343472')->references('id')->on('queries');
            $table->unsignedBigInteger('query_message_id')->nullable();
            $table->foreign('query_message_id', 'query_message_fk_9343473')->references('id')->on('query_messages');
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->foreign('created_by_id', 'created_by_fk_9343478')->references('id')->on('users');
        });
    }
}

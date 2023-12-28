<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToModerationsTable extends Migration
{
    public function up()
    {
        Schema::table('moderations', function (Blueprint $table) {
            $table->unsignedBigInteger('query_message_id')->nullable();
            $table->foreign('query_message_id', 'query_message_fk_9343625')->references('id')->on('query_messages');
            $table->unsignedBigInteger('data_source_id')->nullable();
            $table->foreign('data_source_id', 'data_source_fk_9343626')->references('id')->on('data_sources');
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->foreign('created_by_id', 'created_by_fk_9343528')->references('id')->on('users');
        });
    }
}

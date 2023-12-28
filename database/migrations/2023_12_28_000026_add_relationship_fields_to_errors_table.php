<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToErrorsTable extends Migration
{
    public function up()
    {
        Schema::table('errors', function (Blueprint $table) {
            $table->unsignedBigInteger('query_id')->nullable();
            $table->foreign('query_id', 'query_fk_9343515')->references('id')->on('queries');
            $table->unsignedBigInteger('data_source_id')->nullable();
            $table->foreign('data_source_id', 'data_source_fk_9343516')->references('id')->on('data_sources');
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->foreign('created_by_id', 'created_by_fk_9343520')->references('id')->on('users');
        });
    }
}

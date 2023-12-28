<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToQueryMessagesTable extends Migration
{
    public function up()
    {
        Schema::table('query_messages', function (Blueprint $table) {
            $table->unsignedBigInteger('query_id')->nullable();
            $table->foreign('query_id', 'query_fk_9343043')->references('id')->on('queries');
            $table->unsignedBigInteger('report_id')->nullable();
            $table->foreign('report_id', 'report_fk_9343479')->references('id')->on('reports');
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->foreign('created_by_id', 'created_by_fk_9343048')->references('id')->on('users');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataSourceQueryPivotTable extends Migration
{
    public function up()
    {
        Schema::create('data_source_query', function (Blueprint $table) {
            $table->unsignedBigInteger('query_id');
            $table->foreign('query_id', 'query_id_fk_9343029')->references('id')->on('queries')->onDelete('cascade');
            $table->unsignedBigInteger('data_source_id');
            $table->foreign('data_source_id', 'data_source_id_fk_9343029')->references('id')->on('data_sources')->onDelete('cascade');
        });
    }
}

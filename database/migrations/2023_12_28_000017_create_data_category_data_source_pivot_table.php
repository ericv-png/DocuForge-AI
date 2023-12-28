<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataCategoryDataSourcePivotTable extends Migration
{
    public function up()
    {
        Schema::create('data_category_data_source', function (Blueprint $table) {
            $table->unsignedBigInteger('data_source_id');
            $table->foreign('data_source_id', 'data_source_id_fk_9342864')->references('id')->on('data_sources')->onDelete('cascade');
            $table->unsignedBigInteger('data_category_id');
            $table->foreign('data_category_id', 'data_category_id_fk_9342864')->references('id')->on('data_categories')->onDelete('cascade');
        });
    }
}

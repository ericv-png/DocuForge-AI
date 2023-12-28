<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtractedDatasTable extends Migration
{
    public function up()
    {
        Schema::create('extracted_datas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('excerpt')->nullable();
            $table->longText('summary')->nullable();
            $table->longText('extracted_data');
            $table->integer('tokens')->nullable();
            $table->string('ai_model')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}

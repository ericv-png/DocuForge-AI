<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('org_name')->nullable();
            $table->longText('footer_text')->nullable();
            $table->boolean('registration_admin_approve')->default(0)->nullable();
            $table->string('ai_service_provider')->nullable();
            $table->string('ai_service_provider_credentials')->nullable();
            $table->string('ai_processing_model')->nullable();
            $table->boolean('api_status')->default(0)->nullable();
            $table->string('image_file_processing')->nullable();
            $table->string('image_file_processing_model')->nullable();
            $table->longText('image_file_processing_credentials')->nullable();
            $table->string('text_file_processing')->nullable();
            $table->string('text_file_processing_model')->nullable();
            $table->longText('text_file_processing_credentials')->nullable();
            $table->longText('mail_credentials')->nullable();
            $table->string('host_url')->nullable();
            $table->boolean('moderation')->default(0)->nullable();
            $table->boolean('registration')->default(0)->nullable();
            $table->integer('max_report_simu_process')->nullable();
            $table->integer('max_data_source_simu_process')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProvisionRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provision_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('category_code');
            $table->string('provider_code');
            $table->bigInteger('configuration_id');
            $table->string('function_name');
            $table->text('parameter_data');
            $table->string('result_status')->nullable()->default(null);
            $table->string('result_message')->nullable()->default(null);
            $table->text('result_data')->nullable()->default(null);
            $table->float('execution_time')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provision_requests');
    }
}

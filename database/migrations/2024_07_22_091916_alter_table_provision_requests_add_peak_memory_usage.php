<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('provision_requests', function (Blueprint $table) {
            $table->string('peak_memory_usage')->nullable()->after('execution_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('provision_requests', function (Blueprint $table) {
            $table->dropColumn('peak_memory_usage');
        });
    }
};

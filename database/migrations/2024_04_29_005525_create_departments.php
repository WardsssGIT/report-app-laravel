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
    Schema::create('departments', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('report_table_id')->nullable();
        $table->foreign('report_table_id')->references('id')->on('report_table');

        // Assuming department_involved is a string column in the report_table table
        $table->string('department_involved')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};

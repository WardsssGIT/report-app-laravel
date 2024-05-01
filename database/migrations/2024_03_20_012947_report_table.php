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
        //
        Schema::create('Report_table', function (Blueprint $table) {
            $table->id();  
            $table->unsignedBigInteger('rtuser_id');
            $table->foreign('rtuser_id')->references('id')->on('users');
            
            $table->string('date_of_report')->nullable();
            $table->string('report_type')->nullable();
            $table->string('report_name')->nullable();
            $table->string('department_involved')->nullable();
            $table->text('description')->nullable(); 
            $table->boolean('is_active')->default(1);
            $table->integer('user_verify_id')->nullable();
            $table->boolean('report_status')->nullable();
            $table->text('remarks')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Report_table');
    }
};

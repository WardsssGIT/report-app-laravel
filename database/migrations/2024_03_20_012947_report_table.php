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
            
            $table->string('Date_of_report')->nullable();
            $table->string('Report_type')->nullable();
            $table->string('Report_name')->nullable();
            $table->string('Department_involved')->nullable();
            $table->text('Description')->nullable(); 
            $table->boolean('is_Active')->default(1);
            $table->integer('User_verify_id')->nullable();
            $table->boolean('Report_status')->nullable();
            $table->text('Remarks')->nullable();
            
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

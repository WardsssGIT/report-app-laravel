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
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');//foreign key from users table

            $table->string('date_of_report')->nullable();
            $table->string('report_type')->nullable();
            $table->string('report_name')->nullable();
            $table->text('description')->nullable();
            $table->string('report_pdf')->nullable();
            $table->boolean('is_active')->default(1);

            $table->unsignedBigInteger('department_id')->nullable();
            $table->foreign('department_id')->references('id')->on('departments'); //foreign key from users table
            
            $table->unsignedBigInteger('report_status_id')->nullable();
            $table->foreign('report_status_id')->references('id')->on('report_status'); //foreign key from report_status table

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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employee_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->string('department')->nullable();
            $table->string('position')->nullable();
            $table->string('company')->nullable();
            $table->string('sss')->nullable();
            $table->string('tin')->nullable();
            $table->string('philhealth')->nullable();
            $table->string('hdmf')->nullable();
            $table->timestamps();

            // $table->foreign('employee_id')->references('id')->on('employee')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employee');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_details');
    }
};

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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('cashier_id');
            $table->decimal('amount');
            $table->date('payment_date');
            $table->string('payment_method')->nullable();
            $table->string('reference_number')->nullable();
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('student')->onDelete('cascade');
            $table->foreign('cashier_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

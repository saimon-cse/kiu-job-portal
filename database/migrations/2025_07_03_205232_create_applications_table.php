<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('applications_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->nullable()->constrained('jobs')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            // $table->text('applicant_data')->nullable(); // for JSON
            // $table->decimal('amount', 10, 2);
            $table->decimal('due_amount', 10, 2)->default(0.00); // For future use, if needed
            $table->decimal('paid_amount', 10, 2)->default(0.00); // Amount paid by the user
            $table->text('currency')->default('BDT');
            $table->text('transaction_id')->nullable();
            $table->text('payment_data')->nullable();
            $table->enum('status', ['pending', 'submitted', 'rejected', 'accepted'])->default('pending');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};

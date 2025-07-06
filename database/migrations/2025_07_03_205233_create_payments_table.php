<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {

        // Schema::create('payments', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        //     $table->foreignId('application_id')->nullable()->constrained('applications_history')->onDelete('cascade');
        //     $table->text('transaction_id')->unique();
        //     $table->text('payment_type')->default('job_application'); // Extendable for future
        //     $table->decimal('amount', 10, 2);
        //     $table->decimal('due_amount', 10, 2)->default(0.00); // For future use, if needed
        //     $table->decimal('paid_amount', 10, 2)->default(0.00); // Amount paid by the user
        //     $table->text('currency')->default('BDT');
        //     // $table->text('status')->default('Pending'); // Pending, Success, Failed, etc.
        //     $table->text('payment_status')->default('Pending'); // Pending, Success, Failed, etc.
        //     $table->text('ssl_response')->nullable();
        //     $table->timestamps();

        // });
    }
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

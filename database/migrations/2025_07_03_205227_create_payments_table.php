<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('transaction_id')->unique();
            $table->string('payment_type')->default('job_application'); // Extendable for future
            $table->decimal('amount', 10, 2);
            $table->string('currency')->default('BDT');
            $table->string('payment_status')->default('Pending'); // Pending, Success, Failed, etc.
            $table->json('ssl_response')->nullable();
            $table->timestamps();

        });
    }
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

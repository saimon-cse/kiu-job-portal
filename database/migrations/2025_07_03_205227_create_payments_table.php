<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->unique()->constrained()->onDelete('cascade');
            $table->decimal('amount', 8, 2);
            $table->string('transaction_id')->nullable();
            $table->string('payment_method');
            $table->enum('status', ['pending', 'successful', 'failed'])->default('pending');
            $table->timestamp('payment_date')->nullable();
            $table->string('bank_draft_no')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('branch_name')->nullable();
            $table->date('draft_date')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('payments');
    }
};

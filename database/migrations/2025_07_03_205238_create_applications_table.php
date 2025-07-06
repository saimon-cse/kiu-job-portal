<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->nullable()->constrained('jobs')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('payment_id')->nullable()->constrained('payments')->onDelete('set null');
            $table->text('applicant_data')->nullable(); // for JSON
            $table->enum('status', ['pending', 'submitted', 'reviewed', 'rejected', 'accepted', 'shortlisted'])->default('pending');
            $table->timestamps();


        });
    }
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};


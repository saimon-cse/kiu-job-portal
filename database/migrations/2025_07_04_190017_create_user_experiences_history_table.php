<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('user_experiences_history', function (Blueprint $table) {
            $table->id();
             $table->foreignId('job_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // $table->foreignId('application_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('institute_name', 5000)->nullable();
            $table->string('institute_type', 5000)->nullable(); // e.g., University, College, School, Government/ Autonomous/Private
            $table->string('post_and_scale', 5000)->nullable();
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->string('courses_taught')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('user_experiences_history');
    }
};

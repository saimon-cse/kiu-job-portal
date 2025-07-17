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
            $table->text('institute_name')->nullable();
            $table->text('institute_type')->nullable(); // e.g., University, College, School, Government/ Autonomous/Private
            $table->text('post_and_scale')->nullable();
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->text('courses_taught')->nullable();
            $table->text('salary_scale')->nullable();
            $table->text('rank')->nullable(); // e.g., Professor, Associate Professor, Assistant Professor, Lecturer
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('user_experiences_history');
    }
};

<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('user_educations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // $table->foreignId('application_id')->nullable()->constrained()->onDelete('cascade');
            $table->text('institution_name')->nullable();
            $table->text('period_from')->nullable();
            $table->text('period_to')->nullable();
            $table->text('exam_name')->nullable();
            $table->text('gpa_or_cgpa')->nullable();
            $table->text('passing_year')->nullable();
            $table->text('document_path')->nullable();
            // $table->integer('rank')->nullable()->default(0);
            // $table->text('course_studied')->nullable();
            $table->integer('rank')->nullable()->default(0);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('user_educations');
    }
};

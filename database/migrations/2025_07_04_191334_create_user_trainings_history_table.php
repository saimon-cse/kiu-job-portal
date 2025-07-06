<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('user_trainings_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // $table->foreignId('application_id')->nullable()->constrained()->onDelete('cascade');
            $table->text('training_name')->nullable();
            $table->text('institute_name')->nullable();
            $table->text('period_from')->nullable();
            $table->text('period_to')->nullable();
            $table->text('document_path')->nullable();
            $table->integer('rank')->nullable()->default(0);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('user_trainings_history');
    }
};

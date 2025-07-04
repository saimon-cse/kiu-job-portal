<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('language_proficiencies_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // $table->foreignId('application_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('language', 5000)->nullable();
            // $table->enum('efficiency', ['excellent', 'good', 'poor']);
            $table->string('efficiency', 5000)->nullable()->default('good');
            $table->integer('rank')->nullable()->default(0);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('language_proficiencies_history');
    }
};

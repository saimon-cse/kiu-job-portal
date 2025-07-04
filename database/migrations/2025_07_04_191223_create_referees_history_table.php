<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('referees_history', function (Blueprint $table) {
            $table->id();
             $table->foreignId('job_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // $table->foreignId('application_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('name', 5000)->nullable();
            $table->string('designation',5000)->nullable();
            $table->string('organization', 5000)->nullable();
            $table->string('email', 5000)->nullable();
            $table->string('phone')->nullable();
            $table->string('address', 5000)->nullable();
            // $table->text('relationship')->nullable();
            $table->integer('rank')->nullable()->default(0);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('referees_history');
    }
};

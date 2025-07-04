<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('circular_no');
            $table->string('post_name')->nullable(false);
            $table->string('department_office')->nullable();
            $table->text('description')->nullable();
            $table->date('date')->nullable();
            $table->decimal('application_fee', 8, 2)->default(0);
            $table->date('last_date_of_submission')->nullable();
            $table->enum('status', ['open', 'closed', 'archived'])->default('open');
            $table->unsignedBigInteger('rank')->nullable()->default(0);
            $table->foreignId('created_by')->constrained('users');

            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('jobs');
    }
};

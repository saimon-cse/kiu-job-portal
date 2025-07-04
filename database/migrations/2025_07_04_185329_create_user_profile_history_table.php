<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('user_profiles_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // $table->foreignId('application_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('full_name_bn', 5000)->nullable();
            $table->string('full_name_en', 5000)->nullable();
            $table->string('father_name_bn', 5000)->nullable();
            $table->string('father_name_en', 5000)->nullable();
            $table->string('mother_name_en', 5000)->nullable();
            $table->string('mother_name_bn', 5000)->nullable();
            $table->string('spouse_name_en', 5000)->nullable();
            $table->string('spouse_name_bn', 5000)->nullable();
            $table->date('dob')->nullable();
            $table->string('place_of_birth', 5000)->nullable();
            $table->string('nationality', 5000)->nullable()->default('Bangladeshi');
            $table->string('religion', 5000)->nullable();
            $table->string('marital_status', 5000)->nullable();
            $table->string('permanent_address_bn', 5000)->nullable();
            $table->string('permanent_address_en', 5000)->nullable();
            $table->string('present_address_bn', 5000)->nullable();
            $table->string('present_address_en', 5000)->nullable();
            $table->string('phone_mobile', 5000)->nullable();
            // $table->string('phone_mobile');
            $table->string('additional_information', 5000)->nullable();
            $table->string('quota_information', 5000)->nullable();
            $table->integer('rank')->nullable()->default(0);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('user_profiles_history');
    }
};

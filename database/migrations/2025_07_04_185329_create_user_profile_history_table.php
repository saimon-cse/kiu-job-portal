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
            $table->text('full_name_bn')->nullable();
            $table->text('full_name_en')->nullable();
            $table->text('father_name_bn')->nullable();
            $table->text('father_name_en')->nullable();
            $table->text('mother_name_en')->nullable();
            $table->text('mother_name_bn')->nullable();
            $table->text('spouse_name_en')->nullable();
            $table->text('spouse_name_bn')->nullable();
            $table->date('dob')->nullable();
            $table->text('place_of_birth')->nullable();
            $table->text('nationality')->nullable()->default('Bangladeshi');
            $table->text('religion')->nullable();
            $table->text('marital_status')->nullable();
            $table->text('permanent_address_bn')->nullable();
            $table->text('permanent_address_en')->nullable();
            $table->text('present_address_bn')->nullable();
            $table->text('present_address_en')->nullable();
            $table->text('phone_mobile')->nullable();
            $table->text('signature_path')->nullable();
            // $table->text('phone_mobile');
            $table->text('additional_information')->nullable();
            $table->text('quota_information')->nullable();
            $table->text('service_obligation_details')->nullable();
            $table->text('dismissal_reason')->nullable();
            $table->integer('rank')->nullable()->default(0);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('user_profiles_history');
    }
};

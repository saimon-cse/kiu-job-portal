<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('application_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('full_name_bn')->nullable();
            $table->string('full_name_en')->nullable();
            $table->string('father_name_bn')->nullable();
            $table->string('father_name_en')->nullable();
            $table->string('mother_name_en')->nullable();
            $table->string('mother_name_bn')->nullable();
            $table->string('spouse_name_en')->nullable();
            $table->string('spouse_name_bn')->nullable();
            $table->date('dob')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->string('nationality')->nullable()->default('Bangladeshi');
            $table->string('religion')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('permanent_address_bn')->nullable();
            $table->string('permanent_address_en')->nullable();
            $table->text('present_address_bn')->nullable();
            $table->text('present_address_en')->nullable();
            $table->string('phone_mobile')->nullable();
            // $table->string('phone_mobile');
            $table->text('additional_information')->nullable();
            $table->text('quota_information')->nullable();
            $table->integer('rank')->nullable()->default(0);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('user_profiles');
    }
};

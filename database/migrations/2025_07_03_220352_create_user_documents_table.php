<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration for creating the 'user_documents' table.
 * This table stores paths and metadata for all documents uploaded by a user,
 * with the ability to create historical snapshots for each application.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_documents', function (Blueprint $table) {

            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // $table->foreignId('application_id')->nullable()->constrained(job)->onDelete('cascade');
            $table->text('document_type')->nullable(); // e.g., CV, Certificate, Transcript
            $table->text('file_path')->nullable();
            $table->text('mime_type')->nullable();
            $table->integer('rank')->nullable()->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_documents');
    }
};

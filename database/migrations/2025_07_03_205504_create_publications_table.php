<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('publications', function (Blueprint $table) {

            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('application_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('publication_type_id')->constrained()->onDelete('cascade');

            // The title of the publication (e.g., "A Novel Approach to AI").
            $table->string('title')->nullable();
            $table->string('journal_or_conference_name')->nullable();
            $table->string('publication_year', 4)->nullable();


            // Example: "Vol. 12, No. 3, pp. 110-125"
            $table->string('volume_issue_pages')->nullable();
            $table->string('doi_or_link')->nullable();
            $table->integer('rank')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publications');
    }
};

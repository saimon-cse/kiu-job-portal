<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('publication_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // e.g., "Journal Article", "Book", "Conference Paper"
            $table->string('slug')->unique(); // e.g., "journal-article", "book", "conference-paper"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('publication_types');
    }
};

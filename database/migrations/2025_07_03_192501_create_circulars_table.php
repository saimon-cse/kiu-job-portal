<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCircularsTable extends Migration
{
    public function up()
    {
        Schema::create('circulars', function (Blueprint $table) {
            $table->id();
            $table->string('circular_no')->unique();
            $table->date('post_date');
            $table->date('last_date_of_submission');
            $table->text('description')->nullable();
            $table->string('document_path', 5000)->nullable();
            $table->enum('status', ['open', 'closed', 'archived'])->default('open');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });

        // Set auto-increment start value
        DB::statement("ALTER TABLE circulars AUTO_INCREMENT = 1000000;");
    }

    public function down()
    {
        Schema::dropIfExists('circulars');
    }
}

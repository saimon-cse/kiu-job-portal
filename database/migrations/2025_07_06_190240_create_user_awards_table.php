<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAwardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_awards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
$table->foreignId('job_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('award_name')->nullable();
            $table->string('awarding_body')->nullable(); // The organization that gave the award
            $table->year('year_received')->nullable();
            $table->text('description')->nullable(); // Optional field for more details
            $table->text('country')->nullable(); // Optional field for the country of the awarding body
            $table->integer('rank')->default(0); // For drag-and-drop ordering
            $table->timestamps();
        });

        // This is the corresponding history table for snapshots
        Schema::create('user_awards_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('job_id')->constrained()->onDelete('cascade'); // Link to the specific job application

            $table->string('award_name')->nullable();
            $table->string('awarding_body')->nullable(); // The organization that gave the award
            $table->year('year_received')->nullable();
            $table->text('description')->nullable(); // Optional field for more details
            $table->text('country')->nullable(); // Optional field for the country of the awarding body
            $table->integer('rank')->default(0); // For drag-and-drop ordering
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_awards_history');
        Schema::dropIfExists('user_awards');
    }
}

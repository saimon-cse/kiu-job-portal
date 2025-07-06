<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('circular_id')->constrained()->onDelete('cascade');
            $table->string('post_name', 5000);
            $table->string('department_office', 5000)->nullable();
            $table->decimal('application_fee', 8, 2)->default(0);
            $table->integer('rank')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}

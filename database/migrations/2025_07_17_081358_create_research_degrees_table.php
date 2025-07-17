<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResearchDegreesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('research_degrees', function (Blueprint $table) {
            $table->id();
            $table->text('degree_name')->nullable();
            $table->text('subject')->nullable();
            $table->text('supervisor_name')->nullable();
            $table->text('supervisor_address')->nullable();
            $table->text('university')->nullable();
            $table->text('passing_year')->nullable();
            $table->integer('rank')->default(0);
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
        Schema::dropIfExists('research_degrees');
    }
}

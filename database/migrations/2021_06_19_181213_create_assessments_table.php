<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('submit_id');
            $table->string('nim', 20);
            $table->string('class', 50);
            $table->string('semester', 5);
            $table->tinyInteger('q_role_value');
            $table->tinyInteger('q_business_fields_value');
            $table->tinyInteger('q_achievement_value');
            $table->tinyInteger('q_insight_value');
            $table->tinyInteger('q_solution_to_problem_value');
            $table->tinyInteger('q_target_value');
            $table->tinyInteger('q_integrity_value');
            $table->tinyInteger('q_punctuality_value');
            $table->tinyInteger('q_expertise_value');
            $table->tinyInteger('q_team_work_value');
            $table->tinyInteger('q_communication_value');
            $table->tinyInteger('q_it_implementation_value');
            $table->tinyInteger('q_self_development_value');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('submit_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assessments');
    }
}

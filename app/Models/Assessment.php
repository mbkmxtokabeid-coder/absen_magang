<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'submit_id', 'nim', 'class', 'semester', 'q_integrity_value', 'q_punctuality_value', 'q_expertise_value', 'q_team_work_value', 'q_communication_value', 'q_it_implementation_value', 'q_self_development_value', 'q_role_value', 'q_business_fields_value', 'q_achievement_value', 'q_insight_value', 'q_solution_to_problem_value','q_target_value'];
}

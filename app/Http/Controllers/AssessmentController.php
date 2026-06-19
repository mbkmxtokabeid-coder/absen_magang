<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Profiles;
use App\Models\Supervisors;
use Storage;

class AssessmentController extends Controller
{
    public function index($userName, $userId)
    {
        $users = User::find($userId);
        $supervisors = Supervisors::all();
        $profiles = Profiles::find($userId);
        $assessment = Assessment::where('user_id', $users->id)->first();

        $user = (object)[
            'id'                    => $users->id,
            'name'                  => $users->name,
            'major'                 => $profiles->major,
            'semester'              => $profiles->semester,
            'job_role'              => $users->job_role,
            'profile_photo_url'     => $users->profile_photo_url
        ];

        return view('assessment/index', ['user' => $user, 'mode' => "edit", 'supervisors' => $supervisors, 'assessment' => $assessment]);
    }
    public function add($userName, $userId)
    {
      $_question = json_decode(Storage::disk('local')->get('question.min.json'), true);
      // dd($_question[0]['answer'][0]['4']);
      $users = User::find($userId);
      $supervisors = Supervisors::all();
      $profiles = Profiles::find($userId);
      $assessment = Assessment::where('user_id', $users->id)->first();

      $user = (object)[
          'id'                    => $users->id,
          'name'                  => $users->name,
          'major'                 => $profiles->major,
          'semester'              => $profiles->semester,
          'job_role'              => $users->job_role,
          'profile_photo_url'     => $users->profile_photo_url
      ];
      dd($assessment);
      return view('assessment/add', ['user' => $user, 'mode' => "add", 'questions' => $_question, 'assessment' => $assessment]);
    }

    public function store(Request $req, $userName, $userId) {
        $profiles = Profiles::find($userId);
        $validate = $req->validate([
            'nim' => ['required', 'string'],
            'class' => ['required', 'string']
        ]);

        if(Assessment::where('user_id', $userId)->first() == null){
            Assessment::create([
                'user_id' => $userId,
                'submit_id' => Auth::user()->id,
                'nim' => $req->nim,
                'class' => $req->class,
                'semester' => $profiles->semester,
                'q_integrity_value' => $req->q_integrity,
                'q_punctuality_value' => $req->q_punctuality,
                'q_expertise_value' => $req->q_expertise,
                'q_team_work_value' => $req->q_team_work,
                'q_communication_value' => $req->q_communication,
                'q_it_implementation_value' => $req->q_it_implementation,
                'q_self_development_value' => $req->q_self_development,
                'q_role_value' => $req->q_role,
                'q_business_fields_value' => $req->q_business_fields,
                'q_achievement_value' => $req->q_achievement,
                'q_insight_value' => $req->q_insight,
                'q_solution_to_problem_value' => $req->q_solution_to_problem,
                'q_target_value' => $req->q_target
            ]);
        }
        else {
            $assesment = Assessment::where('user_id', $userId)->first();
            $assesment->submit_id = Auth::user()->id;
            $assesment->nim = $req->nim;
            $assesment->class = $req->class;
            $assesment->semester = $profiles->semester;
            $assesment->q_integrity_value = $req->q_integrity;
            $assesment->q_punctuality_value = $req->q_punctuality;
            $assesment->q_expertise_value = $req->q_expertise;
            $assesment->q_team_work_value = $req->q_team_work;
            $assesment->q_communication_value = $req->q_communication;
            $assesment->q_it_implementation_value = $req->q_it_implementation;
            $assesment->q_self_development_value = $req->q_self_development;
            $assesment->q_role_value = $req->q_role;
            $assesment->q_business_fields_value = $req->q_business_fields;
            $assesment->q_achievement_value = $req->q_achievement;
            $assesment->q_insight_value = $req->q_insight;
            $assesment->q_solution_to_problem_value = $req->q_solution_to_problem;
            $assesment->q_target_value = $req->q_target;
            $assesment->save();
        }
        return redirect('/users/' .$userName. '/'. $userId. '/assessment');
    }
}

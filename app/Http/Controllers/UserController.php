<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Profiles;
use App\Models\Logbook;
use App\Models\Supervisors;
use App\Models\Attendence;
use App\Models\Jurusan;

class UserController extends Controller
{
  function randomColor()
  {
    $color = [
      '#1abc9c',
      '#2ecc71',
      '#3498db',
      '#34495e',
      '#16a085',
      '#27ae60',
      '#2980b9',
      '#8e44ad',
      '#2c3e50',
      '#f1c40f',
      '#e67e22',
      '#e74c3c',
      '#95a5a6',
      '#d35400',
      '#c0392b',
      '#7f8c8d'
    ];
    return $color[rand(0, count($color) -1 )];
  }

  function show($userName, $userId)
  {
    if(Auth::user()->email == 'leader@inti-grafika.xyz'){
      $getUserDataById = Profiles::select('user_id')->where('user_id', $userId)->where('supervisor_id', '!=', NULL)->count();
    }
    else{
      $getUserDataById = Profiles::select('user_id')->where('user_id', $userId)->where('supervisor_id', Auth::user()->id)->count();
    }
    if(Auth::user()->role == 0 || (Auth::user()->role == 2 && $getUserDataById > 0)){
      $user = User::find($userId);
      if($user == null){
        return abort(404);
      }
      $profile = Profiles::find($userId);
      $timelineData = Logbook::where('user_id', $userId)->get();
      $timelines = [];
      $attendenceData = Attendence::where('user_id', $userId)->get();

      $profileData = (object)[
        'id'                => $userId,
        'name'              => $user->name,
        'email'             => $user->email,
        'job_role'          => $user->job_role,
        'profile_photo_url' => $user->profile_photo_url,
        'birth_place'       => $profile != null ? $profile->birth_place : '-',
        'birth_date'        => $profile != null ? $profile->birth_date : '-',
        'telp_number'       => $profile != null ? $profile->telp_number : '-',
        'phone_number'      => $profile != null ? $profile->phone_number : '-',
        'whatsapp_number'   => $profile != null ? $profile->whatsapp_number : '-',
        'school_origin'     => $profile != null ? $profile->school_origin : '-',
        'major'             => $profile != null ? $profile->major : '-',
        'semester'          => $profile != null ? $profile->semester : '-',
        'address'           => $profile != null ? $profile->address : '-',
        'province'          => $profile != null ? $profile->province : '-',
        'region'            => $profile != null ? $profile->region : '-',
        'sub_district'      => $profile != null ? $profile->sub_district : '-',
        'postal_code'       => $profile != null ? $profile->postal_code : '-',
        'facebook_url'      => $profile != null ? $profile->facebook_url : '-',
        'twitter_url'       => $profile != null ? $profile->twitter_url : '-',
        'instagram_url'     => $profile != null ? $profile->instagram_url : '-',
        'youtube_url'       => $profile != null ? $profile->youtube_url : '-',
        'linkedin_url'      => $profile != null ? $profile->linkedin_url : '-',
        'website_url'       => $profile != null ? $profile->website_url : '-',
        'role'              => $user->role,
      ];

      foreach ($timelineData as $timeline) {
        array_push($timelines, (object)[
          'id'          => $timeline->id,
          'user_id'     => $timeline->user_id,
          'date'        => $timeline->date,
          'job_status'  => $timeline->job_status,
          'activity'    => $timeline->activity,
          'duration'    => $timeline->duration,
          'obstacles'   => $timeline->obstacles,
          'image_path' => $timeline->image_path,
          'created_at'  => $timeline->id,
          'updated_at'  => $timeline->id,
          'color'       => $this->randomColor()
        ]);
      }

      return view('profile/show', [
        'profile' => $profileData,
        'timelines' => $timelines,
        'attendenceData' => $attendenceData,
      ]);

    } else{
      return abort(404);
    }

  }

  // Register Page
  public function add()
  {
    $supervisors = Supervisors::all();
    // return view('admin/add_users', ['mode' => "add", 'supervisors' => $supervisors]);
    $jurusan = Jurusan::all();
    return view('admin/add_users', ['mode' => "add", 'supervisors' => $supervisors, 'jurusans' => $jurusan]);
  }

  // Edit Page
  public function edit($userId)
  {
    $user = User::find($userId);
    $supervisors = Supervisors::all();
    // dd($user->profile->supervisor_id);
    $jurusan = Jurusan::all();
    return view('admin/add_users', ['user' => $user, 'mode' => "edit", 'supervisors' => $supervisors, 'jurusans' => $jurusan]);
  }

  // Validator
  protected function validator(array $data, $op)
  {
    if($op == 1 && $data['password'] == null)
      return Validator::make($data, [
        'nama' => ['required', 'string'],
        // 'email' => ['required', 'email', 'unique:users'],
        'job_role' => ['required', 'string'],
        'supervisor' => ['required', 'integer'],
      ]);
    else
      return Validator::make($data, [
        'nama' => ['required', 'string'],
        // 'email' => ['required', 'email', 'unique:users'],
        'password' => ['required', 'string', 'min:6'],
        'job_role' => ['required', 'string'],
        'supervisor' => ['required', 'integer'],
      ]);
  }

  // Register
  public function register(Request $req){
    $this->validator($req->all(), 0)->validate();
    event(new Registered($user = $this->save($req->all(), 'store')));
    return redirect('/users/');
  }

  // Save Edit
  public function storeEdit(Request $req, $userId){
    $user = User::find($userId);
    if($req->password != null){
      $this->validator($req->all(), 0)->validate();
      $user->password = Hash::make($req->password);
    }
    else{
      $this->validator($req->all(), 1)->validate();
    }
    $user->name = $req->nama;
    $user->email = $req->email;
    $user->job_role = $req->job_role;

    $user->save();

    $profile = Profiles::find($userId);
    $supervisor = Supervisors::find($req->supervisor);

    if($profile == null){
      Profiles::create([
        'user_id' => $userId,
        'school_origin' => $supervisor->campus->name,
        'supervisor_id' => $supervisor->user_id,
      ]);
    }
    else{
      $profile->school_origin = $supervisor->campus->name;
      $profile->supervisor_id = $req->supervisor;
      $profile->save();
    }

    return redirect('/users/');
  }

  // Store Data
  protected function save(array $data, $op){
    if($op === "store"){
      User::create([
        'name' => $data['nama'],
        'email' => strtolower($data['email']),
        'password' => Hash::make($data['password']),
        'role' => '1',
        'job_role' => $data['job_role']
      ]);

      $userId = User::where('email', $data['email'])->first();
      $supervisor = Supervisors::find($data['supervisor']);
      Profiles::create([
        'user_id' => $userId->id,
        'school_origin' => $supervisor->campus->name,
        'supervisor_id' => $supervisor->user_id,
        'major' => $data['jurusan'],
      ]);
    }
  }

  // Change user status
  public function editstatus($userId, Request $req)
  {
    $status = "";
    $currentStatus = "";
    $users = User::find($userId);

    if($users != null && ($userId == $req->id)){
      if(
        $req->newstatus == "active" ||
        $req->newstatus == "nonactive" ||
        $req->newstatus == "finish"
      ){
        $users->status = $req->newstatus;

        $users->save();

        $status = "success";
        $currentStatus = $req->newstatus;
      }
    }
    else{
      $status = "sailed";
      $currentStatus = $users->status;
    }

    return response()->json(['status' => $status, 'currentStatus' => $currentStatus]);
  }

  // Delete User
  public function destroy($userId){
    try{
      Profiles::destroy($userId);
      Logbook::destroy($userId);
      Attendence::destroy($userId);
      User::destroy($userId);
    } catch(\Exception $ex){
      return response()->json(['success' => false, 'msg' => $ex->getMessage()]);
    }
    return response()->json(['success' => true]);
  }
}

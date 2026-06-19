<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendence;
use App\Models\User;
use App\Models\Campus;
use App\Models\Profiles;
use App\Models\Supervisors;
use App\Models\Logbook;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class SupervisorController extends Controller
{
  function getUsersIdList($supervisorId)
  {
    $data = Profiles::select('user_id')->where('supervisor_id', Auth::user()->id)->get(['id'])->toArray();

    return $data;
  }
  function getWorkingDays($startDate, $endDate)
  {
    // do strtotime calculations just once
    $startDate = (int)strtotime($startDate);
    $endDate = (int)strtotime($endDate);

    $leaveDay = [];

    while ($startDate <= $endDate) {
      if (date("w", $startDate) != 0) {
        array_push($leaveDay, date("Y-m-d", $startDate));
      }
      $startDate = ($startDate + 86400);
    }

    return $leaveDay;
  }

  function getAttendenceDashboardData($usersId)
  {
    $users = User::where('role', 1)->whereIn('id', $usersId)->get()->load(['attendence']);
    $activeDays = $this->getWorkingDays("2021-03-08", date("Y-m-d"));

    $totalAttends = 0;
    $totalLates = 0;
    $totalNotAttends = 0;

    $attends = 0;
    $lates = 0;
    $notAttends = 0;

    $data = [];

    foreach ($activeDays as $activeDay) {
      $attends = 0;
      $lates = 0;
      $notAttends = 0;
      foreach ($users as $user) {
        if ($user->attendence->count() > 0) {
          foreach ($user->attendence as $attend) {
            $attendDate = date("Y-m-d", strtotime($attend->created_at));
            if ($attendDate == $activeDay) {
              if ($attend->login_status == "Tepat Waktu") {
                $attends++;
              } elseif ($attend->login_status == "Terlambat") {
                $lates++;
              }
            }
          }
        }
      }

      $notAttends = $users->count() - ($attends + $lates);

      $totalAttends += $attends;
      $totalLates += $lates;
      $totalNotAttends += $notAttends;

      array_push($data, (object)[
        'date' => $activeDay,
        'data' => (object)[
          'attend'    => $attends,
          'late'      => $lates,
          'notAttend' => $notAttends
        ]
      ]);
    }

    return (object)[
      'data' => $data,
      'totalAttends' => $totalAttends,
      'totalLates' => $totalLates,
      'totalNotAttends' => $totalNotAttends
    ];
  }

  function getUserAttendToday($usersId)
  {
    $attendenceDatas = User::select(['name', 'profile_photo_path'])
      ->where('role', 1)
      ->whereIn('id', $usersId)
      ->addSelect([
        'status' => Attendence::select('login_status')
          ->whereDate('created_at', date('Y-m-d'))
          ->whereColumn('user_id', 'users.id')
      ])->get();

    return $attendenceDatas;
  }

  function index()
  {
    if(Auth::user()->email == "leader@inti-grafika.xyz"){
      $listUserId = array_values(Profiles::select('user_id')->where('supervisor_id', '!=', NULL)->get(['id'])->toArray());
      $userCount = count($listUserId);
      $logbookCount = Logbook::whereIn('id', $listUserId)->count();
    }
    else{
      $listUserId = array_values($this->getUsersIdList(Auth::user()->id));  
      $userCount = Profiles::select('user_id')->where('supervisor_id', Auth::user()->id)->count();
      $logbookCount = Logbook::whereIn('user_id', $listUserId)->count();
    }

    $jobRoleCount = User::select('job_role')->whereIn('id', array_values($listUserId))->distinct('job_role')->count();    

    $graphData = $this->getAttendenceDashboardData($listUserId);
    $attendenceNow = $this->getUserAttendToday($listUserId);

    return view('supervisor/dashboard', [
      'userCount'      => $userCount,
      'logbookCount'    => $logbookCount,
      'jobRoleCount'   => $jobRoleCount,
      'graphData'      => $graphData,
      'attendenceData' => $attendenceNow
    ]);
  }

  // User Area
  public function usersIndex()
  {
    if(Auth::user()->email == 'leader@inti-grafika.xyz'){
      $listUserId = array_values(Profiles::select('user_id')->where('supervisor_id', '!=', NULL)->get(['id'])->toArray());
    }
    else{
      $listUserId = array_values($this->getUsersIdList(Auth::user()->id));
    }

    $users = User::where('role', 1)->whereIn('id', $listUserId)->get();
    $userData = [];

    foreach ($users as $user) {
        $profile = Profiles::select('major', 'deleted_at')->where('user_id', $user->id)->get();
        $profileCheck = count($profile);

        array_push($userData, (object)[
            'id'            => $user->id,
            'name'          => $user->name,
            'major'         => $profileCheck > 0 ? $profile[0]->major : "-",
            'active_status' => $user->deleted_at == null ? "Active" : "Non-Active",
            'job_role'      => $user->job_role != null ? $user->job_role : "-"
        ]);
    }

    return view('supervisor/users', ['users' => $userData]);
  }

  function indexAttendence()
  {
    if(Auth::user()->email == 'leader@inti-grafika.xyz'){
      $listUserId = array_values(Profiles::select('user_id')->where('supervisor_id', '!=', NULL)->get(['id'])->toArray());
    }
    else{
      $listUserId = array_values($this->getUsersIdList(Auth::user()->id));
    }    

    $attendencesNow = Attendence::whereDate('created_at', date('Y-m-d'))->whereIn('user_id', $listUserId)->count();
    $users = User::where('role', 1)->whereIn('id', $listUserId)->get();
    $status = [0, 0, 0];
    $attendenceData = [];
    foreach ($users as $user) {
      $attendenceDataNow = Attendence::select('login_status', 'created_at')->where('user_id', $user->id)->whereDate('created_at', date('Y-m-d'))->get();
      $attendenceNow = $attendenceDataNow->count() > 0 ? $attendenceDataNow[0] : null;

      $profiles = Profiles::select('school_origin')->where('user_id', $user->id)->get();
      $school_origin = $profiles->count() > 0 ? $profiles[0] : null;

      $fullname = User::select('name')->where('id', $user->id)->get()[0];

      if ($attendenceNow != null && $attendenceNow->login_status == "Tepat Waktu") {
        $status[0]++;
      } else if ($attendenceNow != null && $attendenceNow->login_status == "Terlambat") {
        $status[1]++;
      } else {
        $status[2]++;
      }

      array_push($attendenceData, (object)[
          'id'              => $user->id,
          'name'               => ucfirst($fullname->name),
          'school_origin'      => $school_origin != null ? ucfirst($school_origin->school_origin) : '-',
          'login_status'       => $attendenceNow != null ? ucfirst($attendenceNow->login_status) : "Belum Hadir",
          'login_late_reason'  => $attendenceNow != null ? $attendenceNow->login_late_reason : "-",
          'logout_status'      => $attendenceNow != null ? ucfirst($attendenceNow->logout_status) : "Belum Hadir",
          'logout_late_reason' => $attendenceNow != null ? $attendenceNow->logout_late_reason : "-",
          'created_at'         => $attendenceNow != null ? $attendenceNow->created_at : "-",
          'updated_at'         => $attendenceNow != null ? $attendenceNow->updated_at : "-"
      ]);
    }
    if ($users->count() - $attendencesNow > $attendencesNow) {
      $status[2] = $users->count() - $attendencesNow;
    }

    return view('supervisor/attendence', ['attendencesNow' => $attendenceData, 'status' => $status]);
  }

  function add()
  {
    $campuss = Campus::all();
    return view('admin/add_supervisors', ['mode' => "add", 'campuss' => $campuss]);
  }

  public function edit($userId){
    $supervisor = Supervisors::find($userId);
    $campuss = Campus::all();
    return view('admin/add_supervisors', ['mode' => "edit", 'campuss' => $campuss, 'supervisor' => $supervisor]);
  }

  // Validator
  protected function validator(array $data, $op)
  {
    if($op == 1 && $data['password'] == null)
      return Validator::make($data, [
        'nama' => ['required', 'string'],
        'email' => ['required', 'email'],
        'job_role' => ['required', 'string'],
        "campus" => ['required'],
        "phone_number" => ['required'],
        "whatsapp_number" => ['required'],
      ]);
    else
      return Validator::make($data, [
        'nama' => ['required', 'string'],
        'email' => ['required', 'email'],
        'password' => ['required', 'string', 'min:6'],
        'job_role' => ['required', 'string'],
        "campus" => ['required'],
        "phone_number" => ['required'],
        "whatsapp_number" => ['required'],
      ]);
  }

  // Clean Unused chacater from phone number
  protected function cleanPhoneNum($num){
    $num = str_replace("-", "", $num);
    $num = str_replace("_", "", $num);
    $num = str_replace(" ", "", $num);
    return $num;
  }

  // Store
  public function store(Request $req){
    $this->validator($req->all(), 0)->validate();

    // Insert Data to User DB
    User::create([
      'name' => $req->nama,
      'email' => $req->email,
      'password' => Hash::make($req->password),
      'role' => '2',
      'job_role' => "Dosen Pembimbing",
      'status' => ''
    ]);

    // Get UserID
    $userID = User::where('email', $req->email)->first();
    // Insert Data to Supervisor DB
    Supervisors::create([
      'user_id' => $userID->id,
      'campus_id' => $req->campus,
      'position' => $req->job_role,
      'phone_number' => $this->cleanPhoneNum($req->phone_number),
      'whatsapp_number' => $this->cleanPhoneNum($req->whatsapp_number),
    ]);

    return redirect('/supervisors');
  }

  // Update
  public function update(Request $req, $userId){
    $user = User::find($userId);
    $supervisor = Supervisors::find($userId);
    if($req->password != null){
      $this->validator($req->all(), 0)->validate();
      $user->password = Hash::make($req->password);
    }
    else{
      $this->validator($req->all(), 1)->validate();
    }
    $user->name = $req->nama;
    $user->email = $req->email;

    $user->save();

    $supervisor->campus_id = $req->campus;
    $supervisor->position = $req->job_role;
    $supervisor->phone_number = $this->cleanPhoneNum($req->phone_number);
    $supervisor->whatsapp_number = $this->cleanPhoneNum($req->whatsapp_number);
    $supervisor->save();

    return redirect('/supervisors');
  }

  // Delete Supervisor and user
  public function destroy($userId){
    try{
      Supervisors::destroy($userId);
      User::destroy($userId);
      return response()->json(['success' => true]);
    }
    catch(\Exception $ex){
      return response()->json(['success' => false, 'msg' => $ex->getMessage()]);
    }
  }

  public function profile() {
    $supervisor = Supervisors::find(Auth::id());
    $name = $supervisor->user->name;
    return view('supervisor/profile', ['supervisor' => $supervisor, 'name' => $name]);
  }
}

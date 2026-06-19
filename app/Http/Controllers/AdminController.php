<?php

namespace App\Http\Controllers;

use App\Models\Attendence;
use App\Models\User;
use App\Models\Campus;
use App\Models\Profiles;
use App\Models\Supervisors;
use App\Models\Instruktur;
use App\Models\AttendencePermission;

class AdminController extends Controller
{
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

  function getAttendenceDashboardData()
  {
    $users = User::where('role', 1)->where('status', 'active')->get()->load(['attendence']);
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

  function getUserAttendToday()
  {
    $attendenceDatas = User::select(['name', 'profile_photo_path'])
      ->where('role', 1)
      ->where('status', "active")
      ->addSelect([
        'status' => Attendence::select('login_status')
          ->whereDate('created_at', date('Y-m-d'))
          ->whereColumn('user_id', 'users.id')
      ])->get();

    return $attendenceDatas;
  }

  function index()
  {
    $jobRoleCount = User::where('role', 1)->distinct('job_role')->count();
    $userActiveCount = User::where('role', 1)->where('status', "active")->count();
    $userFinishCount = User::where('role', 1)->where('status', "finish")->count();
    $campusCount = Campus::all()->count();
    $graphData = $this->getAttendenceDashboardData();
    $attendenceNow = $this->getUserAttendToday();

    return view('admin/dashboard', [
      'userActiveCount' => $userActiveCount,
      'userFinishCount' => $userFinishCount,
      'campusCount'     => $campusCount,
      'jobRoleCount'    => $jobRoleCount,
      'graphData'       => $graphData,
      'attendenceData'  => $attendenceNow
    ]);
  }

  // Supervisor Area
  function indexSupervisor()
  {
    $supervisors = Supervisors::where('position', '!=', '-')->get();
    return view('admin/supervisors', ['supervisors' => $supervisors]);
  }

  function indexInstruktur()
  {
    $instruktur = Instruktur::where('position', '!=', '-')->get();
    return view('admin/instruktur', ['instruktur' => $instruktur]);
  }

  function addSupervisor()
  {
    $campuss = Campus::all();
    return view('admin/add_supervisors', ['mode' => "add", 'campuss' => $campuss]);
  }

  // Campus Area
  function indexCampus()
  {
    $campuss = Campus::all();
    return view('admin/campus', ['allCampus' => $campuss]);
  }

  function add()
  {
    return view('admin/add_campus', ['mode' => "add"]);
  }

  // Attendence Area
  function indexAttendence()
  {
    $attendencesNow = Attendence::whereDate('created_at', date('Y-m-d'))->count();
    $users = User::where('role', 1)->where('status', 'active')->get();
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
          'id'                 => $user->id,
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

    return view('admin/attendence', ['attendencesNow' => $attendenceData, 'status' => $status]);
  }

  function indexAttendencePermission()
  {
    $attendencePermissions = AttendencePermission::join('users',  'attendence_permissions.user_id', '=', 'users.id')
    ->select(
      'attendence_permissions.id',
      'user_id',
      'users.name',
      'start_date',
      'finish_date',
      'reason',
      'attendence_permissions.status',
      'attendence_permissions.approved_user_id',
      'attendence_permissions.created_at',
      'attendence_permissions.updated_at'
      )
    ->get();

    $attendencePermissionsCount = (object)[
      'agree' => AttendencePermission::where('status', '=', 'Disetujui')->count(),
      'pending' => AttendencePermission::where('status', '=', 'Pending')->count(),
      'disagree' => AttendencePermission::where('status', '=', 'Tidak disetujui')->count()
    ];

    $data = (object)[
      'attendencePermissions' => $attendencePermissions,
      'count' => $attendencePermissionsCount
    ];

    // dd($data->attendencePermissions);

    return view('admin.attendence_permission', compact('data'));
  }

  // User Active Area
  public function indexUser()
  {
    $users = User::where('role', 1)
    ->where('status', "active")
    ->get();
    $userData = [];
    // dd($users);
    foreach ($users as $user) {
        $profile = Profiles::select('school_origin', 'deleted_at')->where('user_id', $user->id)->get();
        $profileCheck = count($profile);

        array_push($userData, (object)[
            'id'            => $user->id,
            'name'          => $user->name,
            'school_origin' => $profileCheck > 0 ? $profile[0]->school_origin : "-",
            'active_status' => $user->status,
            'job_role'      => $user->job_role != null ? $user->job_role : "-"
        ]);
    }

    return view('admin/users', ['users' => $userData]);
  }

  //User Selesai Area
  public function indexUserSelesai()
  {
    $users = User::where('role', 1)
    ->where('status', "finish")
    ->get();
    $userData = [];
    // dd($users);
    foreach ($users as $user) {
        $profile = Profiles::select('school_origin', 'deleted_at')->where('user_id', $user->id)->get();
        $profileCheck = count($profile);

        array_push($userData, (object)[
            'id'            => $user->id,
            'name'          => $user->name,
            'school_origin' => $profileCheck > 0 ? $profile[0]->school_origin : "-",
            'active_status' => $user->status,
            'job_role'      => $user->job_role != null ? $user->job_role : "-"
        ]);
    }

    return view('admin/userselesai', ['users' => $userData]);
  }

  // Assessment Area
  function indexAssessment()
  {
      // code...
  }
}

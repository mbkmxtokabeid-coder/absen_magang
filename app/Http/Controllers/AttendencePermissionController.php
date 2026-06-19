<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AttendenceController;
use App\Models\Attendence;
use App\Models\AttendencePermission;
use App\Models\User;
use App\Models\Profiles;

class AttendencePermissionController extends Controller
{
    function index()
    {
      $user_id = Auth::user()->id;
      $attendenceToday = new AttendenceController;
      $attendenceData = $attendenceToday->getAttendenceDataToday($user_id);

      $attendencePermissions = AttendencePermission::join('users',  'attendence_permissions.user_id', '=', 'users.id')
      ->where('user_id', $user_id)
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
        'agree' => AttendencePermission::where('status', '=', 'Disetujui')->where('user_id', $user_id)->count(),
        'pending' => AttendencePermission::where('status', '=', 'Pending')->where('user_id', $user_id)->count(),
        'disagree' => AttendencePermission::where('status', '=', 'Tidak disetujui')->where('user_id', $user_id)->count()
      ];

      $data = (object)[
        'attendencePermissions' => $attendencePermissions,
        'count' => $attendencePermissionsCount
      ];

      return view('attendence_permission.index',
      [
        'data'                => $data,
        'attendenceTodayData' => $attendenceData
      ]
      );
    }
    function add()
    {
      $user_id = Auth::user()->id;
      $attendenceToday = new AttendenceController;
      $attendenceData = $attendenceToday->getAttendenceDataToday($user_id);

      return view('attendence_permission.add', ['attendenceTodayData' => $attendenceData]);
    }
}

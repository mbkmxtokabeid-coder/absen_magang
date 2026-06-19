<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Attendence;
use App\Models\User;
use App\Models\Profiles;

class AttendenceController extends Controller
{
  function getaddress($lat, $lng)
  {
    $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' . trim($lat) . ',' . trim($lng) . '&sensor=false';
    $json = @file_get_contents($url);
    $data = json_decode($json);
    $status = $data->status;
    if ($status == "OK") {
      return $data->results[0]->formatted_address;
    } else {
      return false;
    }
  }
  function getApi()
  {
    // dd($this->getaddress("3.5913728000000003", "98.6710016"));
  }

  function timeConfig()
  {
    return [
      'workTimeStart' => "08:00:00",
      'lateWorkTimeStart' => "09:00:00",
      'workTimeFinish' => "16:55:00",
      'lateWorkTimeFinish' => "17:30:00",
      'lateEndWorkTimeFinish' => "21:00:00"
    ];
  }

  function getAttendenceStatus($dateNow, $attendLoginStatus = 0)
  {

    // Configurasi work time
    $workTimeConfiguration = $this->timeConfig();
    $workTimeStart = $workTimeConfiguration['workTimeStart'];
    $lateWorkTimeStart = $workTimeConfiguration['lateWorkTimeStart'];
    $workTimeFinish = $workTimeConfiguration['workTimeFinish'];
    $lateWorkTimeFinish = $workTimeConfiguration['lateWorkTimeFinish'];
    $lateEndWorkTimeFinish = $workTimeConfiguration['lateEndWorkTimeFinish'];

    // Initialization for status
    $status = "";
    $type   = "";

    if (
      ((int)strtotime($dateNow) >= (int)strtotime($workTimeStart)) &&
      ((int)strtotime($dateNow) <= (int)strtotime($lateWorkTimeStart))
    ) {
      if ($attendLoginStatus == 1) {
        $status = "Masuk";
      } else {
        $status = "Tepat Waktu";
      }
      $type   = "Masuk";
    } else if (
      ((int)strtotime($dateNow) > (int)strtotime($lateWorkTimeStart)) &&
      ((int)strtotime($dateNow) <= (int)strtotime($workTimeFinish))
    ) {
      if ($attendLoginStatus == 1) {
        $status = "Masuk";
      } else {
        $status = "Terlambat";
      }
      $type   = "Masuk";
    } else {
      if ($attendLoginStatus == 1) {
        if (
          ((int)strtotime($dateNow) > (int)strtotime($workTimeFinish)) &&
          ((int)strtotime($dateNow) <= (int)strtotime($lateWorkTimeFinish))
        ) {
          $status = "Tepat Waktu";
          $type   = "Keluar";
        } elseif (
          ((int)strtotime($dateNow) > (int)strtotime($lateWorkTimeFinish)) &&
          ((int)strtotime($dateNow) <= (int)strtotime($lateEndWorkTimeFinish))
        ) {
          $status = "Terlambat";
          $type   = "Keluar";
        } else {
          $status = "Tidak Hadir";
          $type   = "Keluar";
        }
      } else {
        $status = "Tidak Hadir";
        $type   = "Masuk";
      }
    }
    return ['status' => $status, 'type' => $type, 'datetime' => $dateNow];
  }
  function showNotif($dateNow, $attendLoginStatus = 0, $attendLogoutStatus = 0)
  {
    $workTimeConfiguration = $this->timeConfig();
    $notif = false;
    if (
      ((int)strtotime($dateNow) >= (int)strtotime($workTimeConfiguration['workTimeStart'])) &&
      ((int)strtotime($dateNow) <= (int)strtotime($workTimeConfiguration['workTimeFinish']))
    ) {
      if ($attendLoginStatus == 0 && $attendLogoutStatus == 0) {
        $notif = ['display' => false, 'text' => "Masuk"];
      } else if ($attendLoginStatus == 1 && $attendLogoutStatus == 0) {
        $notif = ['display' => true, 'text' => "Masuk"];
      }
    } else if (
      ((int)strtotime($dateNow) > (int)strtotime($workTimeConfiguration['workTimeFinish'])) &&
      ((int)strtotime($dateNow) <= (int)strtotime($workTimeConfiguration['lateEndWorkTimeFinish']))
    ) {
      if ($attendLoginStatus == 0 && $attendLogoutStatus == 0) {
        $notif = ['display' => true, 'text' => "Telat"];
      } else if ($attendLoginStatus == 1 && $attendLogoutStatus == 0) {
        $notif = ['display' => false, 'text' => "Keluar"];
      } else if ($attendLoginStatus == 1 && $attendLogoutStatus == 1) {
        $notif = ['display' => true, 'text' => "Keluar"];
      }
    }

    return $notif;
  }
  public static function getAttendenceToday()
  {
    $user_id = Auth::user()->id;
    $dataToday = DB::table('attendences')->where('user_id', $user_id)->whereDate('created_at', date("Y-m-d"))->count();

    $status = "";
    $message = "";

    if ($dataToday != 0) {
      $status = "success";
      $message = "Anda Sudah melakukan absensi!";
    } else {
      $status = "danger";
      $message = "Anda belum melakukan absensi!";
    }
    return (object)(['login_status' => $status, 'message' => $message]);
  }

  function getProfileFillStatus()
  {
    $user_id = Auth::user()->id;
    $user_image = Auth::user()->profile_photo_path != null ? true : false;
    $profilesData = Profiles::find($user_id);
    // dd($user_image);
    $profileStatus = false;
    if ($profilesData != null && $user_image) {
      $profileStatus = true;
    }

    return $profileStatus;
  }

  function getAttendenceDataToday($user_id)
  {
    $dateNow = date('Y-m-d H:i:s');

    $attendenceUserToday = Attendence::where('user_id', $user_id)->whereDate('created_at', date("Y-m-d"))->first();

    $attendLoginStatus = isset($attendenceUserToday) ? 1 : 0;
    $attendLogoutStatus = isset($attendenceUserToday) ? ($attendenceUserToday->created_at != $attendenceUserToday->updated_at ? 1 : 0) : 0;
    $attendenceLateType = $this->getAttendenceStatus($dateNow, $attendLoginStatus);
    $showNotif = $this->showNotif($dateNow, $attendLoginStatus, $attendLogoutStatus);
    $dataToday = $this->getAttendenceToday();

    return (object)[
      'attendenceStatus'    => $dataToday->login_status,
      'attendenceMessage'   => $dataToday->message,
      'attendenceType'      => $attendenceLateType['type'],
      'attendenceLateType'  => $attendenceLateType['status'],
      'notif'               => $showNotif,
      'profileStatus'       => $this->getProfileFillStatus()
    ];
  }

  function index()
  {
    $user_id = Auth::user()->id;
    $dataToday = $this->getAttendenceToday();
    $latestData = DB::table('attendences')->where('user_id', $user_id)->get();
    $dateNow = date('Y-m-d H:i:s');

    $attendenceUserToday = Attendence::where('user_id', $user_id)->whereDate('created_at', date("Y-m-d"))->first();
    $attendLoginStatus = isset($attendenceUserToday) ? 1 : 0;
    $attendLogoutStatus = isset($attendenceUserToday) ? ($attendenceUserToday->created_at != $attendenceUserToday->updated_at ? 1 : 0) : 0;
    $attendenceLateType = $this->getAttendenceStatus($dateNow, $attendLoginStatus);

    $showNotif = $this->showNotif($dateNow, $attendLoginStatus, $attendLogoutStatus);
    // dd($dataToday);
    return view(
      'user_attendence',
      [
        'attendenceStatus'  => $dataToday->login_status,
        'attendenceMessage' => $dataToday->message,
        'attendenceData'    => $latestData,
        'attendenceType'    => $attendenceLateType['type'],
        'attendenceLateType' => $attendenceLateType['status'],
        'notif'             => $showNotif,
        'profileStatus'     => $this->getProfileFillStatus()
      ]
    );
  }

  function supervisorIndex()
  {
    $user_id = Auth::user()->id;
    $dataToday = $this->getAttendenceToday();
    $latestData = DB::table('attendences')->where('user_id', $user_id)->get();

    // dd($dataToday);

    return view(
      'user_attendence',
      [
        'attendenceStatus'  => $dataToday->status,
        'attendenceMessage' => $dataToday->message,
        'attendenceData'    => $latestData,
        'profileStatus'     => $this->getProfileFillStatus()
      ]
    );
  }

  function store(Request $request)
  {
    if ($this->getProfileFillStatus() == true) {
      $user_id = Auth::user()->id;
      $attendenceUserToday = Attendence::where('user_id', $user_id)->whereDate('created_at', date("Y-m-d"))->first();
      $attendLoginStatus = isset($attendenceUserToday) ? 1 : 0;
      $latestDataToday = DB::table('attendences')->where('user_id', $user_id)->whereDate('created_at', date("Y-m-d"))->count();
      $dateNow = date('Y-m-d H:i:s');
      $result = $this->getAttendenceStatus($dateNow, $attendLoginStatus);
      // dd($user_id);
      // dd(Attendence::where('user_id', $user_id)->whereDate('created_at', date("Y-m-d"))->first());
      // dd($attendenceUserToday->created_at == $attendenceUserToday->updated_at);
      if ($latestDataToday == 0) {
        // dd("Create");
        Attendence::create([
          'user_id'            => $user_id,
          'login_status'       => $result['status'],
          'logout_status'      => '-',
          'login_late_reason'  => $result['status'] == "Terlambat" ? str_replace(array( '\'', '"', '<', '>' ), '', $request->input('late_reason')) : '-',
          'logout_late_reason' => '-',
        ]);
      } elseif ($latestDataToday == 1 && $attendenceUserToday->created_at == $attendenceUserToday->updated_at) {
        // dd("Update");
        Attendence::where('user_id', $user_id)
          ->whereDate('created_at', date("Y-m-d"))
          ->first()
          ->update([
            'logout_status' => $result['status'],
            'logout_late_reason' => $result['status'] == "Terlambat" ? $request->input('late_reason') : '-'
          ]);
      }

      return redirect('/attendence')->with('status', 'Anda sudah melakukan absensi!');
    } else {
      $this->index();
    }
  }
}

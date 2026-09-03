<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Logbook;
use Carbon\Carbon;
use App\Http\Controllers\AttendenceController;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class LogbookController extends Controller
{
  function index()
  {
    $attendenceData = AttendenceController::getAttendenceToday();
    $logbooks = Logbook::where('user_id', Auth::id())->get();
    
    $months = [
      'januari' => '01', 'februari' => '02', 'maret' => '03', 'april' => '04',
      'mei' => '05', 'juni' => '06', 'juli' => '07', 'agustus' => '08',
      'september' => '09', 'oktober' => '10', 'november' => '11', 'desember' => '12'
    ];

    foreach ($logbooks as $logbook) {
      if (empty($logbook->date) || strtotime($logbook->date) <= 0 || date('Y', strtotime($logbook->date)) <= 1975) {
        if (preg_match('/(\d{1,2})\s+([a-zA-Z]+)\s+(\d{4})/', strip_tags($logbook->activity), $matches)) {
          $day = str_pad($matches[1], 2, '0', STR_PAD_LEFT);
          $monthStr = strtolower($matches[2]);
          $year = $matches[3];
          if (isset($months[$monthStr])) {
            $logbook->date = "$year-{$months[$monthStr]}-$day";
            try {
              $logbook->save();
            } catch (\Exception $e) {}
          }
        }
      }
    }

    $logbooks = Logbook::where('user_id', Auth::id())->orderBy('date', 'asc')->get();
    return view('logbook/index', ['attendenceStatus' => $attendenceData->login_status, 'attendenceMessage' => $attendenceData->message, 'logbooks' => $logbooks]);
  }
  function add()
  {
    return view('logbook/add');
  }

  function edit(Request $req)
  {
    $logbook = Logbook::find($req->id);
    if (Auth::id() === $logbook->user_id) {
      $logbook->duration = explode(' ', $logbook->duration);
      return view('logbook/add', ['logData' => $logbook]);
    } else
      return redirect('/logbook');
  }

  function store(Request $req)
  {
    // dd($req);
    $this->validasi($req);
    $date = !empty($req->actual_date) ? date('Y-m-d', strtotime(str_replace('-', '/', $req->actual_date))) : Carbon::now()->addHours(7);
    // $date = date('Y-m-d', strtotime(str_replace('-', '/','now')));
    try {
      // Upload images and create multipath
      $images = '';
      if ($req->TotalImages > 0) {
        for ($x = 0; $x < $req->TotalImages; $x++) {
          if($x > 0){
            $images .= ';';
          }
          if ($req->hasFile('images' . $x)) {
            $file = $req->file('images' . $x);
            $name = uniqid() . $file->getClientOriginalName();
            $path = $file->storeAs('logbook/' . Auth::id() . '/' . $date, $name, 'public');
            $images .= $path;
          }
        }
      } else {
        $images = '-';
      }

      // Store Data
      Logbook::create([
        'user_id' => Auth::id(),
        'date' => $date,
        'job_status' => $req->job_status,
        'activity' => $req->activity,
        'duration' => $req->duration,
        'obstacles' => $req->obstacles,
        'image_path' => $images,
      ]);

      return response()->json(['success' => true]);
    } catch (\Exception $ex) {
      return response()->json(['success' => false, 'msg' => $ex->getMessage()]);
    }
  }

  function update(Request $req)
  {
    $this->validasi($req);

    try {
       $logbook = Logbook::find($req->id);
      $date = !empty($req->actual_date) ? date('Y-m-d', strtotime(str_replace('-', '/', $req->actual_date))) : $logbook->date;
      if ($req->TotalImages > 0) {
        $images = '';
        // Remove old image data, if available
        if ($logbook->image_path != '-') {
          $dir = storage_path() . '/app/public/logbook/'. Auth::id() . '/' . $logbook->date;
          $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
          $files = new RecursiveIteratorIterator(
            $it,
            RecursiveIteratorIterator::CHILD_FIRST
          );
          foreach ($files as $file) {
            if ($file->isDir()) {
              rmdir($file->getRealPath());
            } else {
              unlink($file->getRealPath());
            }
          }
          rmdir($dir);
        }
        for ($x = 0; $x < $req->TotalImages; $x++) {
          if($x > 0){
            $images .= ';';
          }
          if ($req->hasFile('images' . $x)) {
            $file = $req->file('images' . $x);
            $name = $file->getClientOriginalName();
            $path = $file->storeAs('logbook/' . Auth::id() . '/' . $date, $name, 'public');
            $images .= $path;
          }
        }
        $logbook->image_path = $images;
      }
       $logbook->date = $date;
      $logbook->job_status = $req->job_status;
      $logbook->activity = $req->activity;
      $logbook->duration = $req->duration;
      $logbook->obstacles = $req->obstacles;
      $logbook->save();

      return response()->json(['success' => true]);
    } catch (\Exception $ex) {
      return response()->json(['success' => false, 'msg' => $ex->getMessage()]);
    }
  }

  private function validasi(Request $req)
  {
    $req->validate([
      // 'actual_date' => ['required'],
      'job_status' => ['required', 'string'],
      'activity' => ['required', 'string'],
      'duration' => ['required', 'string'],
      'obstacles' => ['required', 'string'],
      'images.*' => 'mimes:jpg,png,jpeg,gif,svg'
    ]);
  }
}

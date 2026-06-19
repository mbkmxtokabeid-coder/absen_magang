<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\AttendenceController;
use App\Http\Controllers\UserController;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Jobdesk;
use App\Models\User;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class JobdeskController extends Controller
{
    public function index()
    {
        $attendenceData = AttendenceController::getAttendenceToday();
        $jobdesk = Jobdesk::where('user_id', Auth::id())->get();
        return view('jobdesk/index', ['attendenceStatus' => $attendenceData->login_status, 'attendenceMessage' => $attendenceData->message, 'jobdesks' => $jobdesk]);
    }

    function indexAdmin($userId)
    {
        $user = User::find($userId);        
        $jobdesk = Jobdesk::where('user_id', $userId)->get();
        return view('jobdesk/indexAdmin', ['jobdesks' => $jobdesk, 'users' => $user]);
    }

    public function add($userId)
    {
        $user = User::find($userId);
        $jobdesk = Jobdesk::where('user_id', $user)->get();
        return view('jobdesk/add', ['jobdesks' => $jobdesk]);
    }

    public function edit(Request $req)
    {
        $jobdesk = Jobdesk::find($req->id);
        if($req->id === $jobdesk->user_id){
            $jobdesk->durasi = explode(' ', $jobdesk->durasi);
            return view('jobdesk/add', ['jobData' => $jobdesk]);
        } else 
            return redirect('/user');
    }
    public function delete(Request $req){
        $user = User::find($req->user_id);
        try{
            DB::delete('DELETE FROM `jobdesk` WHERE `jobdesk`.`id` = ?', [$req->id]);
        } catch(\Exception $ex){
            return response()->json(['success' => false, 'msg' => $ex->getMessage()]);
        }
        // return response()->json(['success' => true]);
        return redirect('/users');
    }
    public function update(Request $req)
    {
        $this->validasi($req);
        try {
            $date = date('Y-m-d', strtotime(str_replace('-', '/', $req->actual_date)));
            $jobdesk = Jobdesk::find($req->id);

            $jobdesk->date = $date;
            $jobdesk->job_status = $req->job_status;
            $jobdesk->activity = $req->activity;
            $jobdesk->duration = $req->duration;
            $jobdesk->obstacles = $req->obstacles;
            $jobdesk->save();
          
            return response()->json(['success' => true]);
        } catch (\Exception $ex) {
          return response()->json(['success' => false, 'msg' => $ex->getMessage()]);
        }
    }

    public function store(Request $req)
    {

        $this->validasi($req);
        $date = date('Y-m-d', strtotime(str_replace('-', '/', $req->actual_date)));
        
        try{
            // Store Data
            Jobdesk::create([
                'user_id' => $req->userIdUnique,
                'date' => $date,
                'job_activity' => $req->job_activity,
                'durasi' => $req->durasi,
                'pekerjaan_dari' => $req->pekerjaan_dari
            ]);
        return response()->json(['success' => true]);
        } catch (\Exception $ex) {
        return response()->json(['success' => false, 'msg' => $ex->getMessage()]);
        }
    }

    public function validasi(Request $req)
    {
        $req->validate([
            'actual_date' => 'required',
            'job_activity' => 'required',
            'from' => ['required', 'string'],
            'activity_time' => 'required',
            'durasi' => 'required'
          ]);
    }
}
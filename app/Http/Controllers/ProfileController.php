<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\Profiles;
use App\Models\User;
use App\Models\Logbook;
use App\Models\Attendence;
use App\Models\Jurusan;
use Illuminate\Support\Facades\Artisan;

class ProfileController extends Controller
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

  public function index()
  {
    $profile = Profiles::find(Auth::id());
    $timelineData = Logbook::where('user_id', Auth::id())->get();
    $attendenceData = Attendence::where('user_id', Auth::id())->get();
    $timelines = [];

    $user = User::find(Auth::id());
    $profileData = (object)[
      'id'                => $user->id,
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
    
    return view('profile/show', ['profile' => $profileData, 'timelines' => $timelines, 'attendenceData' => $attendenceData]);
  }

//   public function setting()
//   {
//     $profile = Profiles::where('user_id', Auth::id())->first();
//     $campuss = Campus::all();
//     return view('profile/setting', ['profile' => $profile, 'mode' => (($profile == null) ? 0 : 1), 'campuss' => $campuss] );
//   }
  public function setting()
  {
    $profile = Profiles::where('user_id', Auth::id())->first();
    $campuss = Campus::all();
    $jurusan = Jurusan::all();
    return view('profile/setting', ['profile' => $profile, 'mode' => (($profile == null) ? 0 : 1), 'campuss' => $campuss, 'jurusans' => $jurusan]);
  }


public function store(Request $req)
{
    $validated = $req->validate([
        'name' => ['string'],
        'birth_place' => ['required', 'string'],
        'birth_date' => ['required', 'date'], // Pastikan Laravel memvalidasi sebagai tanggal
        'school_origin' => ['required'],
        'semester' => ['integer'],
        'address' => ['required', 'string'],
        'province' => ['required', 'string'],
        'region' => ['required', 'string'],
        'sub_district' => ['required', 'string'],
        'postal' => ['required', 'string', 'min:5', 'max:5'],
    ]);

    // Perbaikan: Pastikan tanggal dikonversi dengan benar
    try {
        $birth_date = Carbon::parse($req->birth_date)->format('Y-m-d');
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'msg' => 'Format tanggal tidak valid.']);
    }

    // Set Data yang Akan Disimpan
    $dataProfile = [
        'birth_place' => $req->birth_place,
        'birth_date' => $birth_date,
        'telp_number' => str_replace("_", "", $req->telp_num),
        'phone_number' => str_replace("_", "", $req->phone_num),
        'whatsapp_number' => str_replace("_", "", $req->wa_num),
        'major' => $req->major,
        'semester' => $req->semester,
        'address' => $req->address,
        'province' => $req->province,
        'region' => $req->region,
        'sub_district' => $req->sub_district,
        'postal_code' => $req->postal,
        'facebook_url' => $req->fb,
        'twitter_url' => $req->tw,
        'instagram_url' => $req->ig,
        'youtube_url' => $req->yt,
        'linkedin_url' => $req->in,
        'website_url' => $req->web
    ];

    $dataUsers = [
        'name' => $req->name,
        'email' => $req->email
    ];

    // Tambahkan User ID jika belum ada di database
    if (Profiles::where('user_id', Auth::id())->first() == null) {
        $dataProfile['user_id'] = Auth::id();
    }

    // Simpan ke Database
    try {
        Profiles::updateOrCreate(['user_id' => Auth::id()], $dataProfile);
        User::updateOrCreate(['id' => Auth::id()], $dataUsers);
    } catch (\Exception $ex) {
        return response()->json(['success' => false, 'msg' => $ex->getMessage()]);
    }

    return response()->json(['success' => true]);
}

  public function update(Request $req){

    $validated = $req->validate([
      'name' => ['string'],
      'birth_place' => ['required', 'string'],
      'birth_date' => ['required'],
      'semester' => ['integer'],
      'address' => ['required', 'string'],
      'province' => ['required', 'string'],
      'region' => ['required', 'string'],
      'sub_district' => ['required', 'string'],
      'postal' => ['required', 'string', 'min:5', 'max:5'],
    ]);

    // Convert Birth Date from Date Picker Format to SQL Date Format
    try {
        $birth_date = Carbon::parse($req->birth_date)->format('Y-m-d');
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'msg' => 'Format tanggal tidak valid.']);
    }

    // Update data
    try{
      $profile = Profiles::find(Auth::id());
      $user = User::find(Auth::id());
      $user->name = $req->name;
      $user->email = $req->email;
      $profile->birth_place = $req->birth_place;
      $profile->birth_date = $birth_date;
      $profile->telp_number = $req->telp_num;
      $profile->phone_number = $req->phone_num;
      $profile->whatsapp_number = $req->wa_num;
      $profile->major = $req->major;
      $profile->semester = $req->semester;
      $profile->address = $req->address;
      $profile->province = $req->province;
      $profile->region = $req->region;
      $profile->sub_district = $req->sub_district;
      $profile->postal_code = $req->postal;
      $profile->facebook_url = $req->fb;
      $profile->twitter_url = $req->tw;
      $profile->instagram_url = $req->ig;
      $profile->youtube_url = $req->yt;
      $profile->linkedin_url = $req->in;
      $profile->website_url = $req->web;
      $profile->save();
      $user->save();
    }
    catch(\Exception $ex){
      return response()->json(['success' => false, 'msg' => $ex->getMessage()]);
    }
    return response()->json(['success' => true]);
  }

  // Change Password (User)
  public function changePass(Request $req){
    $user = User::find(Auth::id());
    if(Hash::check($req->oldPass, $user->password)){
      try{
        $user->password = Hash::make($req->newPass);
        $user->save();
      }
      catch(\Exception $ex){
        return response()->json(['success' => false, 'msg' => $ex->getMessage()]);
      }
      return response()->json(['success' => true]);
    }
    else{
      return response()->json(['success' => false, 'msg' => 'Password Lama anda tidak cocok.']);
    }
  }

  // Upload Profile Picture
  public function upload(Request $req){
    $user = User::find(Auth::id());
    $req->validate([
      'propic' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);
    if($req->file('propic')) {
      $extension = substr($req->file('propic')->getClientOriginalName(), -4, 4);
      $imgName = Auth::id() . $extension;
      if($user->profile_photo_path != null){
        unlink(storage_path() . '/app/public/' . $user->profile_photo_path);
      }
      $path = $req->file('propic')->storeAs('profile-photos', $imgName, 'public');

      $user->profile_photo_path = $path;
      $user->save();

      Artisan::call('cache:clear');

      return response()->json(['success' => true]);
    }
    else{
      return response()->json(['success' => false, 'msg' => 'Update Foto Profil Gagal']);
    }
  }

  public function logPhotoes(Request $req){
    // dd($req->id);
    $imgUrl = explode(";", Logbook::find($req->id)->image_path);
    $resHTML = "";
    $first = 1;
    foreach ($imgUrl as $img){
      if($first){
        $resHTML .= '<div class="carousel-item active">';
        $first = 0;
      }
      else{
        $resHTML .= '<div class="carousel-item">';
      }
      $resHTML .= '<img class="d-block w-100" src="/storage/'. $img .'">';
      $resHTML .= '</div>';
    }
    return response()->json(['success' => true, 'response' => $resHTML]);
  }
}

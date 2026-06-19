<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Instruktur;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class InstrukturController extends Controller
{
    function add()
  {
    return view('admin/add_instruktur', ['mode' => "add"]);
  }

  public function edit($userId){
    $instruktur = Instruktur::find($userId);
    return view('admin/add_instruktur', ['mode' => "edit", 'instruktur' => $instruktur]);
  }

  // Validator
  protected function validator(array $data, $op)
  {
    if($op == 1 && $data['password'] == null)
      return Validator::make($data, [
        'nama' => ['required', 'string'],
        'email' => ['required', 'email'],
        'job_role' => ['required', 'string'],
        "phone_number" => ['required'],
        "whatsapp_number" => ['required'],
      ]);
    else
      return Validator::make($data, [
        'nama' => ['required', 'string'],
        'email' => ['required', 'email'],
        'password' => ['required', 'string', 'min:6'],
        'job_role' => ['required', 'string'],
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
      'role' => '0',
      'job_role' => "Instruktur / Mentor",
      'status' => '',
    ]);

    // Get UserID
    $userID = User::where('email', $req->email)->first();
    // Insert Data to Instruktur DB
    Instruktur::create([
      'user_id' => $userID->id,
      'position' => $req->job_role,
      'phone_number' => $this->cleanPhoneNum($req->phone_number),
      'whatsapp_number' => $this->cleanPhoneNum($req->whatsapp_number)
    ]);
    return redirect('/instruktur');
  }

  // Update
  public function update(Request $req, $userId){
    $user = User::find($userId);
    $instruktur = Instruktur::find($userId);
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

    $instruktur->position = $req->job_role;
    $instruktur->phone_number = $this->cleanPhoneNum($req->phone_number);
    $instruktur->whatsapp_number = $this->cleanPhoneNum($req->whatsapp_number);
    $instruktur->save();

    return redirect('/instruktur');
  }

  // Delete Instruktur and user
  public function destroy($userId){
    try{
      Instruktur::destroy($userId);
      User::destroy($userId);
      return response()->json(['success' => true]);
    }
    catch(\Exception $ex){
      return response()->json(['success' => false, 'msg' => $ex->getMessage()]);
    }
  }

  public function profile() {
    $instruktur = Instruktur::find(Auth::id());
    $name = $instruktur->user->name;
    return view('Instruktur/profile', ['instruktur' => $instruktur, 'name' => $name]);
  }
}

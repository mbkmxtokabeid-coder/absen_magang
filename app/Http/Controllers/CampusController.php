<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campus;

class CampusController extends Controller
{
  function add()
  {
    return view('admin/add_campus', ['mode' => "add"]);
  }

  public function store(Request $req) {
    $req->validate([
      'nama' => ['required', 'string'],
      'email' => ['required', 'email'],
      'telp_number' => ['required'],
      'address' => ['required']
    ]);

    Campus::create([
      'name' => $req->nama,
      'email' => $req->email,
      'telp' => $req->telp_number,
      'address' => $req->address
    ]);
    return redirect('/campus');
  }

  public function edit($id){
    $campus = Campus::find($id);
    return view('admin/add_campus', ['mode' => 'edit', 'campus'=> $campus]);
  }

  public function update(Request $req, $id){
    $req->validate([
      'nama' => ['required', 'string'],
      'email' => ['required', 'email'],
      'telp_number' => ['required'],
      'address' => ['required']
    ]);

    $campus = Campus::find($id);
    $campus->name = $req->nama;
    $campus->email = $req->email;
    $campus->telp = $req->telp_number;
    $campus->address = $req->address;
    $campus->save();

    return redirect('/campus');
  }

  public function destroy($id){
    Campus::destroy($id);
    return response()->json(['success' => 'sukses']);
  }
}

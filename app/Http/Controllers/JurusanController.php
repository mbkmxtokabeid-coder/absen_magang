<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class JurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jurusan = Jurusan::all();
        $jurusans = [];
        foreach ($jurusan as $jur) {
            $jur->encryptedId = str_replace('/', '412if1n', Crypt::encryptString($jur->jurusanId));
        }
        return view('admin.jurusan', ['mode' => 'add', 'jurusans' => $jurusan]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.add_jurusan', ['mode' => 'add']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'namaJurusan' => 'required|string|max:255',
        ]);

        $tglNow = Carbon::now()->toDateTimeString();
        $mdlJurusan = new Jurusan;

        $mdlJurusan->jurusanNama = $request->input('namaJurusan');
        $mdlJurusan->created_at = $tglNow;
        $mdlJurusan->save();
        return redirect(route('admin.jurusan'))->with('success', 'Jurusan Berhasil Ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $encId = $request->input('id');
        $id = Crypt::decryptString(str_replace('412if1n', '/', $encId));

        $mdlJurusan = new Jurusan;
        $getData = $mdlJurusan::find($id);
        // dd($getData);
        return view('admin.edit_jurusan', ['jurusan' => $getData, 'encId' => $encId]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $decrId = Crypt::decryptString($id);
        $jurusan = Jurusan::where('jurusanId', $decrId)->update([
            'jurusanNama' => $request->input('namaJurusan'),
            'updated_at' => Carbon::now()
        ]);
        if ($jurusan != 1) {
            return redirect()->route('admin.jurusan')->with('error', 'Jurusan Gagal Diupdate');
        } else {
            return redirect()->route('admin.jurusan')->with('success', 'Jurusan Berhasil Diupdate');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $decrId = Crypt::decryptString($id);
        $jurusan = Jurusan::find($decrId);
        if (!$jurusan) {
            return redirect()->back()->withErrors(['Jurusan tidak ditemukan']);
        }
        $namaJur = $jurusan->jurusanNama;
        $jurusan->delete();
        return redirect()->route('admin.jurusan')->with('success', 'Jurusan ' . $namaJur . ' Berhasil Dihapus');
    }
}

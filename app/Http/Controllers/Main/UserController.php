<?php

namespace App\Http\Controllers\Main;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {

        $data['title'] = "User";
        $user = User::with('jabatan')->get();
        $data['result'] = $user->sortDesc();
        return view("main.user.index", $data);
    }
    public function tambah()
    {

        $data['jabatan'] = Jabatan::all();
        $data['title'] = "Tambah User";
        return view("main.user.tambah", $data);
    }
    public function simpan(Request $request)
    {
        $objek = User::create([
            'username' => $request->username,
            'user_jab_id' => $request->user_jab_id,
            'email' => $request->email,
            'name' => $request->name,
            'password' => bcrypt($request->password),
        ]);
        return redirect('main/user')->with('success', 'Data berhasil disimpan!');
    }
    public function edit($id)
    {
        $data['title'] = "Edit User";
        $data['result'] = User::findOrFail($id);
        return view("main.user.edit", $data);
    }
    public function aksi_ubah(Request $request, $id)
    {
        $post = User::find($id);
        $post->name = $request->name;
        $post->username = $request->username;
        $post->email = $request->email;
        $post->password = bcrypt($request->password);
        $post->save();

        return redirect('main/user')->with('success', 'Data berhasil diubah!');
    }
    public function hapus($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return back()->with('success', 'Data sudah di Hapus!');
    }
    public function lihat($id)
    {
        $data['title'] = "Lihat User";
        $data['result'] = User::findOrFail($id);
        return view("main.user.lihat", $data);
    }
}

<?php

namespace App\Http\Controllers\Main;

use App\Models\Dokumen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DokumenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] = "Dokumen";
        $data['result'] =  Dokumen::where('user_id', Auth::id())->with('user')->orderBy('id', 'DESC')->get();
        return view("main.dokumen.index", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['title'] = "Create Dokumen";
        return view("main.dokumen.create", $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'user_id' => 'required',
                'algoritme' => 'required',
                'file' => 'required',
            ],
            [
                'user_id.required' => 'user_id Kosong !',
                'algoritme.required' => 'algoritme Kosong !',
                'file.required' => 'file Kosong !',
            ],
        );
        Dokumen::create([
            'user_id' => $request->user_id,
            'algoritme' => $request->algoritme,
            'file' => $request->file('file')->store('file', 'public'),
        ]);
        return redirect('main/dokumen')->with('success', 'Data berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['title'] = "Edit Dokumen";
        $data['result'] = Dokumen::findOrFail($id);
        return view("main.dokumen.edit", $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Dokumen::find($id);
        $post->algoritme =  $request->algoritme;
        $post->file =  $request->file('file')->store('file', 'public');
        $post->save();

        return redirect('main/dokumen')->with('success', 'Data berhasil diubah!');
        // return 'ok';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dokumen = Dokumen::findOrFail($id);
        $dokumen->delete();
        return back()->with('success', 'Data sudah di Hapus!');
    }
}
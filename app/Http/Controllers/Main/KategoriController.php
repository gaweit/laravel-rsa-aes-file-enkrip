<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] = "Kategori";
        $data['result'] =  Kategori::orderBy('kategori_id', 'DESC')->get();
        return view("main.kategori.index", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['title'] = "Create Kategori";
        return view("main.kategori.create", $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validasi = $this->validate(
            $request,
            [
                'nama' => 'required',
                'slug' => 'required'
            ],
            [
                'nama.required' => 'Nama Kosong !',
                'slug.required' => 'Nama Kosong !'
            ],
        );
        $objek = Kategori::create([
            'nama' => $request->nama,
            'slug' => $request->slug,
        ]);
        return redirect('main/kategori')->with('success', 'Data berhasil disimpan!');
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
        $data['title'] = "Edit Kategori";
        $data['result'] = Kategori::findOrFail($id);
        return view("main.kategori.edit", $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Kategori::find($id);
        $post->nama = $request->nama;
        // $post->slug = $request->slug;
        $post->save();

        return redirect('main/kategori')->with('success', 'Data berhasil diubah!');
        // return 'ok';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();
        return back()->with('success', 'Data sudah di Hapus!');
    }
}
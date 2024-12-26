<?php

namespace App\Http\Controllers\Main;

use App\Models\Dokumen;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\CryptoHelper;
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
                'algoritme' => 'required',
                'file' => 'required|file',
            ],
            [
                'algoritme.required' => 'Algoritme harus dipilih!',
                'file.required' => 'File harus diunggah!',
            ]
        );

        // Generate kunci AES
        $aesKey = Str::random(16); // Panjang 32 karakter untuk kunci AES

        // Baca file yang diunggah
        $fileContent = file_get_contents($request->file('file')->getPathname());

        // Enkripsi file dengan AES
        $encryptedFile = CryptoHelper::encryptFileAES($fileContent, $aesKey);

        // Simpan file terenkripsi
        $encryptedFilePath = $request->file('file')->store('file/encrypted', 'public');
        file_put_contents(storage_path("app/public/$encryptedFilePath"), $encryptedFile);

        // RSA Kunci Publik (Ganti dengan kunci Anda)
        $publicKey = file_get_contents(storage_path('keys/public.pem')); // Path ke kunci publik

        // Enkripsi kunci AES menggunakan RSA
        // $encryptedAESKey = CryptoHelper::encryptAESKeyRSA($aesKey, $publicKey);
        $encryptedAESKey = base64_encode(CryptoHelper::encryptAESKeyRSA($aesKey, $publicKey));


        // Simpan data ke database
        Dokumen::create([
            'user_id' => Auth::id(),
            'algoritme' => $request->algoritme,
            'file' => $encryptedFilePath,
        ]);
        return redirect('main/dokumen')->with('success', 'Data berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     */

    public function decrypt($id)
    {
        $dokumen = Dokumen::findOrFail($id);

        // RSA Kunci Privat (Ganti dengan kunci Anda)
        $privateKey = file_get_contents(storage_path('keys/private.pem'));

        // Ambil kunci AES terenkripsi dari database (misalnya di kolom encrypted_key)
        $encryptedAESKey = $dokumen->encrypted_key; // Pastikan kolom ini ada di database

        // Dekripsi kunci AES menggunakan RSA
        $aesKey = CryptoHelper::decryptAESKeyRSA($encryptedAESKey, $privateKey);

        // Dekripsi file dengan AES
        $encryptedFileContent = file_get_contents(storage_path("app/public/{$dokumen->file}"));
        $decryptedFile = CryptoHelper::decryptFileAES($encryptedFileContent, $aesKey);

        // Mengatur nama file hasil dekripsi
        $filename = 'decrypted_' . basename($dokumen->file);

        // Mengirimkan file untuk diunduh
        return response($decryptedFile)
            ->header('Content-Type', 'application/octet-stream')
            ->header('Content-Disposition', "attachment; filename=\"{$filename}\"");
    }


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
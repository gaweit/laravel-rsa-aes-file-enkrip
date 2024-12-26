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

        $aesKey = random_bytes(16); // Panjang 16 byte untuk kunci AES
        $fileContent = file_get_contents($request->file('file')->getPathname());
        $encryptedFile = CryptoHelper::encryptFileAES($fileContent, $aesKey);

        $encryptedFilePath = $request->file('file')->store('file/encrypted', 'public');
        file_put_contents(storage_path("app/public/$encryptedFilePath"), $encryptedFile);

        $publicKey = file_get_contents(storage_path('keys/public.pem'));
        $encryptedAESKey = base64_encode(CryptoHelper::encryptAESKeyRSA($aesKey, $publicKey));

        Dokumen::create([
            'user_id' => Auth::id(),
            'algoritme' => $request->algoritme,
            'file' => $encryptedFilePath,
            'encrypted_key' => $encryptedAESKey, // Simpan kunci AES terenkripsi
        ]);

        return redirect('main/dokumen')->with('success', 'Data berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     */

    public function decrypt($id)
    {
        $dokumen = Dokumen::findOrFail($id);
        $privateKey = file_get_contents(storage_path('keys/private.pem'));
        $encryptedAESKey = base64_decode($dokumen->encrypted_key);

        $aesKey = CryptoHelper::decryptAESKeyRSA($encryptedAESKey, $privateKey);
        $encryptedFileContent = file_get_contents(storage_path("app/public/{$dokumen->file}"));
        $decryptedFile = CryptoHelper::decryptFileAES($encryptedFileContent, $aesKey);

        $filename = 'decrypted_' . basename($dokumen->file);

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
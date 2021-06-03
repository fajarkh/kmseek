<?php

namespace App\Http\Controllers;

use App\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class HistoryController extends Controller
{
    //menampilkan semua history
    public function index()
    {
        $history = History::all();

        return response()->json([
            'success' => true,
            'message' => 'List Semua History',
            'data'    => $history
        ], 200);
    }

    //menampilkan history berdasarkan id
    public function historyById($id)
    {
        $history = History::find($id);

        if ($history) {
            return response()->json([
                'success'   => true,
                'message'   => 'Detail History!',
                'data'      => $history
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'History Tidak Ditemukan!',
            ], 404);
        }
    }

    //insert history
    public function insert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul_history'   => 'required',
            'konten' => 'required',
            'gambar' => 'required|mimes:png,jpg|max:2048'
        ]);

        //validasi insert history
        if ($validator->fails()) {
            return  response()->json(['error' => $validator->errors()], 401);
        } else {
            //dd($request->all());
            if ($gambar = $request->file('gambar')) {
                $path = $gambar->store('public/files');
                $name = $gambar->getClientOriginalName();
                //dd($name);

                $history = History::create([
                    'judul_history'     => $request->input('judul_history'),
                    'konten'   => $request->input('konten'),
                    'id_kategori'   => $request->input('id_kategori'),
                    'gambar_name'   => $name,
                    'gambar_path'   => $path,
                ]);
            }

            //menampilkan json status insert
            if ($history) {
                return response()->json([
                    'success' => true,
                    'message' => 'History Berhasil Disimpan!',
                    'data' => $history
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'History Gagal Disimpan!',
                ], 400);
            }
        }
    }

    //update history
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'judul_history'   => 'required',
            'konten' => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Semua Kolom Wajib Diisi!',
                'data'   => $validator->errors()
            ], 401);
        } else {

            $history = History::whereId($id)->update([
                'judul_history'     => $request->input('judul_history'),
                'konten'   => $request->input('konten'),
                'id_kategori'   => $request->input('id_kategori'),
                'gambar'   => $request->input('gambar'),
            ]);

            if ($history) {
                return response()->json([
                    'success' => true,
                    'message' => 'History Berhasil Diupdate!',
                    'data' => $history
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'History Gagal Diupdate!',
                ], 400);
            }
        }
    }

    public function delete($id)
    {
        $history = History::whereId($id)->first();
        $history->delete();

        if ($history) {
            return response()->json([
                'success' => true,
                'message' => 'History Berhasil Dihapus!',
            ], 200);
        }
    }

    public function upload($directory, $file, $oldfilename = null)
    {
        try {
            $extension = $file->getClientOriginalExtension();
            $oriName = str_replace('.', '_', str_replace(' ', '', $file->getClientOriginalName()));
            $filename = $oriName . '_' . md5(time()) . '_' . rand(000, 999) . '.' . $extension;
            Storage::putFileAs('public/' . $directory, $file, $filename);
            if (!empty($oldfilename)) {
                Storage::delete('public/' . $directory . '/' . $oldfilename);
            }
        } catch (\Exception $e) {
            Session::flash("flash_notification", [
                "level" => "danger",
                "message" => "Gagal menyimpan " . $oriName
            ]);
        }
        return $filename;
    }
}

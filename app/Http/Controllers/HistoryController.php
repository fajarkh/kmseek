<?php

namespace App\Http\Controllers;

use App\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        ]);
        //validasi insert history
        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Semua Kolom Wajib Diisi!',
                'data'   => $validator->errors()
            ], 401);
        } else {

            $history = History::create([
                'judul_history'     => $request->input('judul_history'),
                'konten'   => $request->input('konten'),
                'id_kategori'   => $request->input('id_kategori'),
                'gambar_path'   => $request->input('gambar_path'),
            ]);
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
                'gambar_path'   => $request->input('gambar_path'),
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
}

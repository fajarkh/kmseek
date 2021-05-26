<?php

namespace App\Http\Controllers;

use App\Budaya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BudayaController extends Controller
{
    //menampilkan semua history
    public function index()
    {
        $history = Budaya::all();

        return response()->json([
            'success' => true,
            'message' => 'List Semua Budaya',
            'data'    => $history
        ], 200);
    }

    //menampilkan history berdasarkan id
    public function historyById($id)
    {
        $history = Budaya::find($id);

        if ($history) {
            return response()->json([
                'success'   => true,
                'message'   => 'Detail Budaya!',
                'data'      => $history
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Budaya Tidak Ditemukan!',
            ], 404);
        }
    }

    //insert history
    public function insert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'macam_budaya'   => 'required',
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

            $history = Budaya::create([
                'user_id'     => $request->input('user_id'),
                'judul_history'     => $request->input('macam_budaya'),
            ]);
            //menampilkan json status insert
            if ($history) {
                return response()->json([
                    'success' => true,
                    'message' => 'Budaya Berhasil Disimpan!',
                    'data' => $history
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Budaya Gagal Disimpan!',
                ], 400);
            }
        }
    }

    //update history
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'macam_budaya'   => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Semua Kolom Wajib Diisi!',
                'data'   => $validator->errors()
            ], 401);
        } else {

            $history = Budaya::whereId($id)->update([
                'macam_budaya'     => $request->input('macam_budaya'),
                'id_user'   => $request->input('id_user')
            ]);

            if ($history) {
                return response()->json([
                    'success' => true,
                    'message' => 'Budaya Berhasil Diupdate!',
                    'data' => $history
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Budaya Gagal Diupdate!',
                ], 400);
            }
        }
    }

    public function delete($id)
    {
        $history = Budaya::whereId($id)->first();
        $history->delete();

        if ($history) {
            return response()->json([
                'success' => true,
                'message' => 'Budaya Berhasil Dihapus!',
            ], 200);
        }
    }
}

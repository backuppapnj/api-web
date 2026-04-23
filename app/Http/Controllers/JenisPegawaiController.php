<?php

namespace App\Http\Controllers;

use App\Models\JenisPegawai;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class JenisPegawaiController extends Controller
{
    /**
     * Ambil semua jenis pegawai, urut berdasarkan urutan ASC (PUBLIC)
     */
    public function index(): JsonResponse
    {
        $data = JenisPegawai::orderBy('urutan', 'asc')
            ->orderBy('nama', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $data,
            'total'   => $data->count(),
        ]);
    }

    /**
     * Ambil satu jenis pegawai (PUBLIC)
     */
    public function show(int $id): JsonResponse
    {
        if ($id <= 0) {
            return response()->json(['success' => false, 'message' => 'ID tidak valid'], 400);
        }

        $item = JenisPegawai::find($id);
        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json(['success' => true, 'data' => $item]);
    }

    /**
     * Simpan jenis pegawai baru (PROTECTED)
     */
    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'nama'   => 'required|string|max:100',
            'urutan' => 'nullable|integer|min:0',
        ]);

        $nama = trim(strip_tags($request->nama));

        if (JenisPegawai::where('nama', $nama)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Jenis pegawai dengan nama tersebut sudah ada',
            ], 422);
        }

        $item = JenisPegawai::create([
            'nama'   => $nama,
            'urutan' => $request->input('urutan', 0),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Jenis pegawai berhasil disimpan',
            'data'    => $item,
        ], 201);
    }

    /**
     * Perbarui jenis pegawai (PROTECTED)
     */
    public function update(Request $request, int $id): JsonResponse
    {
        if ($id <= 0) {
            return response()->json(['success' => false, 'message' => 'ID tidak valid'], 400);
        }

        $item = JenisPegawai::find($id);
        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        $this->validate($request, [
            'nama'   => 'sometimes|required|string|max:100',
            'urutan' => 'nullable|integer|min:0',
        ]);

        if ($request->has('nama')) {
            $nama = trim(strip_tags($request->nama));
            if (JenisPegawai::where('nama', $nama)->where('id', '!=', $id)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jenis pegawai dengan nama tersebut sudah ada',
                ], 422);
            }
            $item->nama = $nama;
        }

        if ($request->has('urutan')) {
            $item->urutan = (int) $request->urutan;
        }

        $item->save();

        return response()->json([
            'success' => true,
            'message' => 'Jenis pegawai berhasil diperbarui',
            'data'    => $item,
        ]);
    }

    /**
     * Hapus jenis pegawai (PROTECTED)
     * Hanya bisa dihapus jika tidak ada pegawai yang menggunakannya.
     */
    public function destroy(int $id): JsonResponse
    {
        if ($id <= 0) {
            return response()->json(['success' => false, 'message' => 'ID tidak valid'], 400);
        }

        $item = JenisPegawai::find($id);
        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        if ($item->uraianTugas()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Jenis pegawai tidak dapat dihapus karena masih digunakan oleh ' . $item->uraianTugas()->count() . ' pegawai',
            ], 422);
        }

        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Jenis pegawai berhasil dihapus',
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\KelompokJabatan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class KelompokJabatanController extends Controller
{
    /**
     * Ambil semua kelompok jabatan, urut berdasarkan urutan ASC (PUBLIC)
     */
    public function index(): JsonResponse
    {
        $data = KelompokJabatan::orderBy('urutan', 'asc')
            ->orderBy('nama_kelompok', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data,
            'total' => $data->count(),
        ]);
    }

    /**
     * Ambil satu kelompok jabatan (PUBLIC)
     */
    public function show(int $id): JsonResponse
    {
        if ($id <= 0) {
            return response()->json(['success' => false, 'message' => 'ID tidak valid'], 400);
        }

        $item = KelompokJabatan::find($id);
        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json(['success' => true, 'data' => $item]);
    }

    /**
     * Simpan kelompok jabatan baru (PROTECTED)
     */
    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'nama_kelompok' => 'required|string|max:100',
            'urutan'        => 'nullable|integer|min:0',
        ]);

        $namaKelompok = trim(strip_tags($request->nama_kelompok));

        // Cek duplikat
        if (KelompokJabatan::where('nama_kelompok', $namaKelompok)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Kelompok jabatan dengan nama tersebut sudah ada',
            ], 422);
        }

        $item = KelompokJabatan::create([
            'nama_kelompok' => $namaKelompok,
            'urutan'        => $request->input('urutan', 0),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kelompok jabatan berhasil disimpan',
            'data'    => $item,
        ], 201);
    }

    /**
     * Perbarui kelompok jabatan (PROTECTED)
     */
    public function update(Request $request, int $id): JsonResponse
    {
        if ($id <= 0) {
            return response()->json(['success' => false, 'message' => 'ID tidak valid'], 400);
        }

        $item = KelompokJabatan::find($id);
        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        $this->validate($request, [
            'nama_kelompok' => 'sometimes|required|string|max:100',
            'urutan'        => 'nullable|integer|min:0',
        ]);

        if ($request->has('nama_kelompok')) {
            $namaKelompok = trim(strip_tags($request->nama_kelompok));
            // Cek duplikat kecuali record ini sendiri
            if (KelompokJabatan::where('nama_kelompok', $namaKelompok)->where('id', '!=', $id)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kelompok jabatan dengan nama tersebut sudah ada',
                ], 422);
            }
            $item->nama_kelompok = $namaKelompok;
        }

        if ($request->has('urutan')) {
            $item->urutan = (int) $request->urutan;
        }

        $item->save();

        return response()->json([
            'success' => true,
            'message' => 'Kelompok jabatan berhasil diperbarui',
            'data'    => $item,
        ]);
    }

    /**
     * Hapus kelompok jabatan (PROTECTED)
     * Tidak bisa dihapus jika masih ada pegawai di kelompok ini
     */
    public function destroy(int $id): JsonResponse
    {
        if ($id <= 0) {
            return response()->json(['success' => false, 'message' => 'ID tidak valid'], 400);
        }

        $item = KelompokJabatan::find($id);
        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        // Cek apakah masih ada uraian tugas di kelompok ini
        if ($item->uraianTugas()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Kelompok jabatan tidak dapat dihapus karena masih memiliki data pegawai',
            ], 422);
        }

        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kelompok jabatan berhasil dihapus',
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Panggilan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PanggilanController extends Controller
{
    /**
     * Ambil semua data panggilan
     */
    public function index(Request $request): JsonResponse
    {
        $query = Panggilan::query();

        // Filter berdasarkan tahun jika ada
        if ($request->has('tahun')) {
            $query->where('tahun_perkara', $request->tahun);
        }

        // Sorting
        $query->orderBy('created_at', 'desc');

        $data = $query->get();

        return response()->json([
            'success' => true,
            'data' => $data,
            'total' => $data->count()
        ]);
    }

    /**
     * Ambil data berdasarkan tahun
     */
    public function byYear(int $tahun): JsonResponse
    {
        $data = Panggilan::where('tahun_perkara', $tahun)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data,
            'total' => $data->count()
        ]);
    }

    /**
     * Ambil detail satu data
     */
    public function show(int $id): JsonResponse
    {
        $panggilan = Panggilan::find($id);

        if (!$panggilan) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $panggilan
        ]);
    }

    /**
     * Simpan data baru
     */
    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'tahun_perkara' => 'required|integer|min:2000|max:2100',
            'nomor_perkara' => 'required|string|max:50',
            'nama_dipanggil' => 'required|string|max:255',
        ]);

        $panggilan = Panggilan::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan',
            'data' => $panggilan
        ], 201);
    }

    /**
     * Update data
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $panggilan = Panggilan::find($id);

        if (!$panggilan) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $panggilan->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diupdate',
            'data' => $panggilan
        ]);
    }

    /**
     * Hapus data
     */
    public function destroy(int $id): JsonResponse
    {
        $panggilan = Panggilan::find($id);

        if (!$panggilan) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $panggilan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}

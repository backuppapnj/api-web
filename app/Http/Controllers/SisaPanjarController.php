<?php

namespace App\Http\Controllers;

use App\Models\SisaPanjar;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SisaPanjarController extends Controller
{
    private array $allowedFields = [
        'tahun',
        'bulan',
        'nomor_perkara',
        'nama_penggugat_pemohon',
        'jumlah_sisa_panjar',
        'status',
        'tanggal_setor_kas_negara',
    ];

    public function index(Request $request): JsonResponse
    {
        $query = SisaPanjar::query();

        if ($request->has('tahun')) {
            $tahun = filter_var($request->tahun, FILTER_VALIDATE_INT);
            if ($tahun && $tahun >= 2000 && $tahun <= 2100) {
                $query->where('tahun', $tahun);
            }
        }

        if ($request->has('status')) {
            $status = $request->status;
            if (in_array($status, ['belum_diambil', 'disetor_kas_negara'])) {
                $query->where('status', $status);
            }
        }

        if ($request->has('bulan')) {
            $bulan = filter_var($request->bulan, FILTER_VALIDATE_INT);
            if ($bulan && $bulan >= 1 && $bulan <= 12) {
                $query->where('bulan', $bulan);
            }
        }

        $limit = min((int) $request->get('limit', 10), 100);

        $data = $query->orderBy('created_at', 'desc')
            ->paginate($limit);

        return response()->json([
            'success' => true,
            'data' => $data->items(),
            'current_page' => $data->currentPage(),
            'last_page' => $data->lastPage(),
            'per_page' => $data->perPage(),
            'total' => $data->total(),
        ]);
    }

    public function byYear(int $tahun): JsonResponse
    {
        if ($tahun < 2000 || $tahun > 2100) {
            return response()->json([
                'success' => false,
                'message' => 'Tahun tidak valid'
            ], 400);
        }

        $data = SisaPanjar::where('tahun', $tahun)
            ->orderBy('bulan', 'asc')
            ->orderBy('created_at', 'desc')
            ->limit(500)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data,
            'total' => $data->count()
        ]);
    }

    public function show(int $id): JsonResponse
    {
        if ($id <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'ID tidak valid'
            ], 400);
        }

        $sisaPanjar = SisaPanjar::find($id);

        if (!$sisaPanjar) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $sisaPanjar
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'tahun' => 'required|integer|min:2000|max:2100',
            'bulan' => 'required|integer|min:1|max:12',
            'nomor_perkara' => 'required|string|max:100|regex:/^[0-9\/\.a-zA-Z\s\-]+$/',
            'nama_penggugat_pemohon' => 'required|string|max:255',
            'jumlah_sisa_panjar' => 'required|numeric|min:0',
            'status' => 'required|in:belum_diambil,disetor_kas_negara',
            'tanggal_setor_kas_negara' => 'nullable|date',
        ]);

        $data = $request->only($this->allowedFields);
        $data = $this->sanitizeInput($data, ['nomor_perkara']);

        $sisaPanjar = SisaPanjar::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Data sisa panjar berhasil disimpan',
            'data' => $sisaPanjar
        ], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        if ($id <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'ID tidak valid'
            ], 400);
        }

        $sisaPanjar = SisaPanjar::find($id);

        if (!$sisaPanjar) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $this->validate($request, [
            'tahun' => 'sometimes|integer|min:2000|max:2100',
            'bulan' => 'sometimes|integer|min:1|max:12',
            'nomor_perkara' => 'sometimes|string|max:100|regex:/^[0-9\/\.a-zA-Z\s\-]+$/',
            'nama_penggugat_pemohon' => 'sometimes|string|max:255',
            'jumlah_sisa_panjar' => 'sometimes|numeric|min:0',
            'status' => 'sometimes|in:belum_diambil,disetor_kas_negara',
            'tanggal_setor_kas_negara' => 'nullable|date',
        ]);

        $data = $request->only($this->allowedFields);
        $data = $this->sanitizeInput($data, ['nomor_perkara']);

        $sisaPanjar->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Data sisa panjar berhasil diupdate',
            'data' => $sisaPanjar->fresh()
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        if ($id <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'ID tidak valid'
            ], 400);
        }

        $sisaPanjar = SisaPanjar::find($id);

        if (!$sisaPanjar) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $sisaPanjar->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data sisa panjar berhasil dihapus'
        ]);
    }
}

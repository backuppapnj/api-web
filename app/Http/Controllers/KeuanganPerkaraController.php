<?php

namespace App\Http\Controllers;

use App\Models\KeuanganPerkara;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class KeuanganPerkaraController extends Controller
{
    private array $allowedFields = [
        'tahun', 'bulan', 'saldo_awal', 'penerimaan', 'pengeluaran', 'url_detail',
    ];

    public function index(Request $request): JsonResponse
    {
        $query = KeuanganPerkara::query();

        if ($request->has('tahun')) {
            $tahun = filter_var($request->tahun, FILTER_VALIDATE_INT);
            if ($tahun && $tahun >= 2000 && $tahun <= 2100) {
                $query->where('tahun', $tahun);
            }
        }

        $data = $query->orderBy('tahun', 'desc')->orderBy('bulan', 'asc')->get();

        return response()->json([
            'success' => true,
            'data'    => $data,
            'total'   => $data->count(),
        ]);
    }

    public function byYear(int $tahun): JsonResponse
    {
        if ($tahun < 2000 || $tahun > 2100) {
            return response()->json(['success' => false, 'message' => 'Tahun tidak valid'], 400);
        }

        $data = KeuanganPerkara::where('tahun', $tahun)
            ->orderBy('bulan', 'asc')
            ->get();

        return response()->json(['success' => true, 'data' => $data, 'total' => $data->count()]);
    }

    public function show(int $id): JsonResponse
    {
        $item = KeuanganPerkara::find($id);
        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }
        return response()->json(['success' => true, 'data' => $item]);
    }

    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'tahun'       => 'required|integer|min:2000|max:2100',
            'bulan'       => 'required|integer|min:1|max:12',
            'saldo_awal'  => 'nullable|integer|min:0',
            'penerimaan'  => 'nullable|integer|min:0',
            'pengeluaran' => 'nullable|integer|min:0',
            'url_detail'  => 'nullable|string|max:1000',
        ]);

        $exists = KeuanganPerkara::where('tahun', $request->tahun)
            ->where('bulan', $request->bulan)->first();
        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Data untuk tahun dan bulan tersebut sudah ada.',
            ], 422);
        }

        $item = KeuanganPerkara::create($request->only($this->allowedFields));
        return response()->json(['success' => true, 'message' => 'Data berhasil disimpan', 'data' => $item], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $item = KeuanganPerkara::find($id);
        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        $this->validate($request, [
            'saldo_awal'  => 'nullable|integer|min:0',
            'penerimaan'  => 'nullable|integer|min:0',
            'pengeluaran' => 'nullable|integer|min:0',
            'url_detail'  => 'nullable|string|max:1000',
        ]);

        $item->update($request->only($this->allowedFields));
        return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui', 'data' => $item->fresh()]);
    }

    public function destroy(int $id): JsonResponse
    {
        $item = KeuanganPerkara::find($id);
        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }
        $item->delete();
        return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\LaporanPengaduan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LaporanPengaduanController extends Controller
{
    private array $allowedFields = [
        'tahun', 'materi_pengaduan',
        'jan', 'feb', 'mar', 'apr', 'mei', 'jun',
        'jul', 'agu', 'sep', 'okt', 'nop', 'des',
        'laporan_proses', 'sisa',
    ];

    private function bulanFields(): array
    {
        return ['jan','feb','mar','apr','mei','jun','jul','agu','sep','okt','nop','des','laporan_proses','sisa'];
    }

    private function toInt(?string $val): ?int
    {
        if ($val === null || $val === '') return null;
        $v = (int) trim($val);
        return $v === 0 ? 0 : $v;
    }

    public function index(Request $request): JsonResponse
    {
        $query = LaporanPengaduan::query();

        if ($request->has('tahun')) {
            $tahun = filter_var($request->tahun, FILTER_VALIDATE_INT);
            if ($tahun && $tahun >= 2000 && $tahun <= 2100) {
                $query->where('tahun', $tahun);
            }
        }

        $data = $query->orderBy('tahun', 'desc')
            ->orderByRaw("FIELD(materi_pengaduan, '" . implode("','", LaporanPengaduan::MATERI_PENGADUAN) . "')")
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data,
            'total' => $data->count(),
        ]);
    }

    public function byYear(int $tahun): JsonResponse
    {
        if ($tahun < 2000 || $tahun > 2100) {
            return response()->json(['success' => false, 'message' => 'Tahun tidak valid'], 400);
        }

        $data = LaporanPengaduan::where('tahun', $tahun)
            ->orderByRaw("FIELD(materi_pengaduan, '" . implode("','", LaporanPengaduan::MATERI_PENGADUAN) . "')")
            ->get();

        return response()->json(['success' => true, 'data' => $data, 'total' => $data->count()]);
    }

    public function show(int $id): JsonResponse
    {
        $item = LaporanPengaduan::find($id);
        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }
        return response()->json(['success' => true, 'data' => $item]);
    }

    public function store(Request $request): JsonResponse
    {
        $rules = [
            'tahun' => 'required|integer|min:2000|max:2100',
            'materi_pengaduan' => 'required|string',
        ];
        foreach ($this->bulanFields() as $field) {
            $rules[$field] = 'nullable|integer|min:0';
        }

        $this->validate($request, $rules);

        if (!in_array($request->materi_pengaduan, LaporanPengaduan::MATERI_PENGADUAN)) {
            return response()->json([
                'success' => false,
                'message' => 'Materi pengaduan tidak valid.'
            ], 422);
        }

        $exists = LaporanPengaduan::where('tahun', $request->tahun)
            ->where('materi_pengaduan', $request->materi_pengaduan)->first();
        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Data untuk tahun dan materi tersebut sudah ada.',
            ], 422);
        }

        $data = $this->sanitizeInput($request->only($this->allowedFields));

        $item = LaporanPengaduan::create($data);
        return response()->json(['success' => true, 'message' => 'Data berhasil disimpan', 'data' => $item], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $item = LaporanPengaduan::find($id);
        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        $rules = [];
        foreach ($this->bulanFields() as $field) {
            $rules[$field] = 'nullable|integer|min:0';
        }
        $this->validate($request, $rules);

        $data = $this->sanitizeInput($request->only($this->allowedFields));

        $item->update($data);
        return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui', 'data' => $item->fresh()]);
    }

    public function destroy(int $id): JsonResponse
    {
        $item = LaporanPengaduan::find($id);
        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }
        $item->delete();
        return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
    }
}

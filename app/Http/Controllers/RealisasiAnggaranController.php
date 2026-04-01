<?php

namespace App\Http\Controllers;

use App\Models\RealisasiAnggaran;
use App\Models\PaguAnggaran;
use Illuminate\Http\Request;

class RealisasiAnggaranController extends Controller
{
    public function index(Request $request)
    {
        // JOIN dengan pagu_anggaran agar pagu selalu mengambil nilai terbaru dari master
        $query = RealisasiAnggaran::select(
            'realisasi_anggaran.*',
            'pagu_anggaran.jumlah_pagu as master_pagu'
        )->leftJoin('pagu_anggaran', function ($join) {
            $join->on('realisasi_anggaran.dipa', '=', 'pagu_anggaran.dipa')
                 ->on('realisasi_anggaran.kategori', '=', 'pagu_anggaran.kategori')
                 ->on('realisasi_anggaran.tahun', '=', 'pagu_anggaran.tahun');
        });

        if ($request->has('tahun')) $query->where('realisasi_anggaran.tahun', $request->input('tahun'));
        if ($request->has('bulan')) $query->where('realisasi_anggaran.bulan', $request->input('bulan'));
        if ($request->has('dipa')) $query->where('realisasi_anggaran.dipa', $request->input('dipa'));

        if ($request->has('q')) {
            $search = $request->input('q');
            $query->where('realisasi_anggaran.kategori', 'like', "%{$search}%");
        }

        $query->orderBy('realisasi_anggaran.tahun', 'desc')
              ->orderBy('realisasi_anggaran.dipa', 'asc')
              ->orderBy('realisasi_anggaran.bulan', 'asc')
              ->orderBy('realisasi_anggaran.kategori', 'asc');

        $perPage = $request->input('per_page', 15);
        $paginated = $query->paginate($perPage);

        // Override pagu, sisa, dan persentase dengan nilai terbaru dari master pagu
        foreach ($paginated as $item) {
            $this->applyMasterPagu($item);
        }

        return response()->json([
            'success' => true,
            'data' => $paginated->items(),
            'total' => $paginated->total(),
            'current_page' => $paginated->currentPage(),
            'last_page' => $paginated->lastPage(),
            'per_page' => $paginated->perPage(),
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'dipa' => 'required',
            'kategori' => 'required',
            'bulan' => 'nullable|integer|min:0|max:12',
            'realisasi' => 'required|numeric',
            'tahun' => 'required|integer',
            'file_dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('file_dokumen')) {
            $link = $this->uploadFile($request->file('file_dokumen'), $request, 'anggaran');
            if ($link) $data['link_dokumen'] = $link;
        }

        $paguConfig = PaguAnggaran::where('dipa', $data['dipa'])
                                  ->where('kategori', $data['kategori'])
                                  ->where('tahun', $data['tahun'])
                                  ->first();
        
        $paguValue = $paguConfig ? $paguConfig->jumlah_pagu : 0;
        $data['pagu'] = $paguValue;
        $data['sisa'] = $paguValue - $data['realisasi'];
        $data['persentase'] = $paguValue > 0 ? ($data['realisasi'] / $paguValue) * 100 : 0;

        $anggaran = RealisasiAnggaran::create($data);
        return response()->json(['success' => true, 'data' => $anggaran], 201);
    }

    public function update(Request $request, $id)
    {
        $anggaran = RealisasiAnggaran::find($id);
        if (!$anggaran) return response()->json(['success' => false, 'message' => 'Data not found'], 404);

        $this->validate($request, [
            'dipa' => 'required',
            'kategori' => 'required',
            'bulan' => 'nullable|integer|min:0|max:12',
            'realisasi' => 'required|numeric',
            'tahun' => 'required|integer',
            'file_dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $data = $request->all();

        if ($request->hasFile('file_dokumen')) {
            $link = $this->uploadFile($request->file('file_dokumen'), $request, 'anggaran');
            if ($link) $data['link_dokumen'] = $link;
        }
        
        $paguConfig = PaguAnggaran::where('dipa', $data['dipa'])
                                  ->where('kategori', $data['kategori'])
                                  ->where('tahun', $data['tahun'])
                                  ->first();
        
        $paguValue = $paguConfig ? $paguConfig->jumlah_pagu : 0;
        $data['pagu'] = $paguValue;
        $data['sisa'] = $paguValue - $data['realisasi'];
        $data['persentase'] = $paguValue > 0 ? ($data['realisasi'] / $paguValue) * 100 : 0;

        $anggaran->update($data);
        return response()->json(['success' => true, 'data' => $anggaran]);
    }

    public function show($id) {
        $anggaran = RealisasiAnggaran::find($id);
        if (!$anggaran) return response()->json(['success' => false, 'data' => null], 404);

        // Ambil pagu terbaru dari master dan hitung ulang
        $this->applyMasterPagu($anggaran);

        return response()->json(['success' => true, 'data' => $anggaran]);
    }

    public function destroy($id) {
        RealisasiAnggaran::destroy($id);
        return response()->json(['success' => true]);
    }

    // uploadFile() diwarisi dari base Controller

    /**
     * Override nilai pagu, sisa, dan persentase dengan data terbaru dari master pagu_anggaran.
     * Fallback ke nilai pagu yang tersimpan jika master tidak ditemukan.
     */
    private function applyMasterPagu(RealisasiAnggaran $item): void
    {
        $paguValue = $item->master_pagu ?? $item->pagu;

        $item->setAttribute('pagu', $paguValue);
        $item->setAttribute('sisa', $paguValue - $item->realisasi);
        $item->setAttribute('persentase', $paguValue > 0
            ? ($item->realisasi / $paguValue) * 100
            : 0);
    }
}

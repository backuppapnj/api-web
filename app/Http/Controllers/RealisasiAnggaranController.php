<?php

namespace App\Http\Controllers;

use App\Models\RealisasiAnggaran;
use App\Models\PaguAnggaran;
use Illuminate\Http\Request;

class RealisasiAnggaranController extends Controller
{
    public function index(Request $request)
    {
        $query = RealisasiAnggaran::query();

        if ($request->has('tahun')) $query->where('tahun', $request->input('tahun'));
        if ($request->has('bulan')) $query->where('bulan', $request->input('bulan'));
        if ($request->has('dipa')) $query->where('dipa', $request->input('dipa'));
        
        if ($request->has('q')) {
            $search = $request->input('q');
            $query->where('kategori', 'like', "%{$search}%");
        }

        $query->orderBy('tahun', 'desc')->orderBy('dipa', 'asc')->orderBy('bulan', 'asc')->orderBy('kategori', 'asc');

        // Gunakan pagination (default 15 data per halaman)
        $perPage = $request->input('per_page', 15);
        $paginated = $query->paginate($perPage);

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
            'keterangan' => 'nullable',
            'link_dokumen' => 'nullable',
        ]);

        $data = $request->all();
        
        $paguConfig = PaguAnggaran::where('dipa', $data['dipa'])
                                  ->where('kategori', $data['kategori'])
                                  ->where('tahun', $data['tahun'])
                                  ->first();
        
        $paguValue = $paguConfig ? $paguConfig->jumlah_pagu : 0;
        
        $data['pagu'] = $paguValue;
        $data['sisa'] = $paguValue - $data['realisasi'];
        $data['persentase'] = $paguValue > 0 ? ($data['realisasi'] / $paguValue) * 100 : 0;

        $anggaran = RealisasiAnggaran::create($data);

        return response()->json([
            'success' => true,
            'data' => $anggaran
        ], 201);
    }

    public function show($id)
    {
        $anggaran = RealisasiAnggaran::find($id);
        if (!$anggaran) return response()->json(['success' => false, 'message' => 'Data not found'], 404);
        return response()->json(['success' => true, 'data' => $anggaran]);
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
            'keterangan' => 'nullable',
            'link_dokumen' => 'nullable',
        ]);

        $data = $request->all();
        
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

    public function destroy($id)
    {
        $anggaran = RealisasiAnggaran::find($id);
        if (!$anggaran) return response()->json(['success' => false, 'message' => 'Data not found'], 404);
        $anggaran->delete();
        return response()->json(['success' => true, 'message' => 'Deleted successfully']);
    }
}
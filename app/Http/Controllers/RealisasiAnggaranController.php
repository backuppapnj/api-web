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
            'file_dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('file_dokumen')) {
            $link = $this->uploadFile($request->file('file_dokumen'), $request);
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
            $link = $this->uploadFile($request->file('file_dokumen'), $request);
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
        return response()->json(['success' => !!$anggaran, 'data' => $anggaran]);
    }

    public function destroy($id) {
        RealisasiAnggaran::destroy($id);
        return response()->json(['success' => true]);
    }

    private function uploadFile($file, Request $request)
    {
        try {
            if (class_exists('\App\Services\GoogleDriveService')) {
                $driveService = new \App\Services\GoogleDriveService();
                return $driveService->upload($file);
            }
        } catch (\Throwable $e) { }

        $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', $file->getClientOriginalName());
        $destinationPath = app()->basePath('public/uploads/anggaran');
        if (!file_exists($destinationPath)) mkdir($destinationPath, 0755, true);
        $file->move($destinationPath, $filename);
        return $request->root() . '/uploads/anggaran/' . $filename;
    }
}

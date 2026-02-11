<?php

namespace App\Http\Controllers;

use App\Models\LhkpnReport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LhkpnController extends Controller
{
    public function index(Request $request)
    {
        $query = LhkpnReport::query();

        if ($request->has('tahun')) $query->where('tahun', $request->input('tahun'));
        if ($request->has('jenis')) $query->where('jenis_laporan', $request->input('jenis'));

        if ($request->has('q')) {
            $search = $request->input('q');
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        // Urutan berdasarkan struktur organisasi (Perma 7 Tahun 2015)
        $query->orderBy('tahun', 'desc')
            ->orderByRaw("CASE 
                WHEN jabatan LIKE '%Ketua%' AND jabatan NOT LIKE '%Wakil%' THEN 1
                WHEN jabatan LIKE '%Wakil Ketua%' THEN 2
                WHEN jabatan LIKE '%Hakim%' THEN 3
                WHEN jabatan LIKE '%Panitera%' AND jabatan NOT LIKE '%Muda%' AND jabatan NOT LIKE '%Pengganti%' THEN 4
                WHEN jabatan LIKE '%Sekretaris%' THEN 5
                WHEN jabatan LIKE '%Panitera Muda%' THEN 6
                WHEN jabatan LIKE '%Kepala Subbagian%' OR jabatan LIKE '%Kasubbag%' THEN 7
                WHEN jabatan LIKE '%Panitera Pengganti%' THEN 8
                WHEN jabatan LIKE '%Juru Sita%' THEN 9
                ELSE 10 
            END ASC")
            ->orderBy('nama', 'asc');

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
            'nip' => 'required',
            'nama' => 'required',
            'jabatan' => 'required',
            'tahun' => 'required|integer',
            'jenis_laporan' => 'required|in:LHKPN,SPT Tahunan',
            'tanggal_lapor' => 'nullable|date',
            'file_tanda_terima' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'file_pengumuman' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'file_spt' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'file_dokumen_pendukung' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        $dataInput = $request->all();

        // Handle File Uploads
        $fileFields = [
            'file_tanda_terima' => 'link_tanda_terima',
            'file_pengumuman' => 'link_pengumuman',
            'file_spt' => 'link_spt',
            'file_dokumen_pendukung' => 'link_dokumen_pendukung'
        ];

        foreach ($fileFields as $fileField => $linkField) {
            if ($request->hasFile($fileField)) {
                $link = $this->uploadFile($request->file($fileField), $request, 'lhkpn');
                if ($link) $dataInput[$linkField] = $link;
            }
        }

        $report = LhkpnReport::create($dataInput);

        return response()->json(['success' => true, 'data' => $report], 201);
    }

    public function show($id)
    {
        $report = LhkpnReport::find($id);
        if (!$report) return response()->json(['success' => false, 'message' => 'Data not found'], 404);
        return response()->json(['success' => true, 'data' => $report]);
    }

    public function update(Request $request, $id)
    {
        $report = LhkpnReport::find($id);
        if (!$report) return response()->json(['success' => false, 'message' => 'Data not found'], 404);

        $this->validate($request, [
            'nip' => 'required',
            'nama' => 'required',
            'jabatan' => 'required',
            'tahun' => 'required|integer',
            'jenis_laporan' => 'required|in:LHKPN,SPT Tahunan',
            'tanggal_lapor' => 'nullable|date',
            'file_tanda_terima' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'file_pengumuman' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'file_spt' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'file_dokumen_pendukung' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        $dataInput = $request->all();

        $fileFields = [
            'file_tanda_terima' => 'link_tanda_terima',
            'file_pengumuman' => 'link_pengumuman',
            'file_spt' => 'link_spt',
            'file_dokumen_pendukung' => 'link_dokumen_pendukung'
        ];

        foreach ($fileFields as $fileField => $linkField) {
            if ($request->hasFile($fileField)) {
                $link = $this->uploadFile($request->file($fileField), $request, 'lhkpn');
                if ($link) $dataInput[$linkField] = $link;
            }
        }

        $report->update($dataInput);

        return response()->json(['success' => true, 'data' => $report]);
    }

    public function destroy($id)
    {
        $report = LhkpnReport::find($id);
        if (!$report) return response()->json(['success' => false, 'message' => 'Data not found'], 404);
        $report->delete();
        return response()->json(['success' => true, 'message' => 'Deleted successfully']);
    }

    private function uploadFile($file, Request $request, $folder = 'lhkpn')
    {
        try {
            if (class_exists('\App\Services\GoogleDriveService')) {
                $driveService = new \App\Services\GoogleDriveService();
                return $driveService->upload($file);
            }
        } catch (\Throwable $e) { }

        try {
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', $file->getClientOriginalName());
            $destinationPath = app()->basePath('public/uploads/' . $folder);
            if (!file_exists($destinationPath)) mkdir($destinationPath, 0755, true);
            $file->move($destinationPath, $filename);
            return $request->root() . '/uploads/' . $folder . '/' . $filename;
        } catch (\Throwable $e) {
            return null;
        }
    }
}
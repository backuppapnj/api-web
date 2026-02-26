<?php

namespace App\Http\Controllers;

use App\Models\AsetBmn;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AsetBmnController extends Controller
{
    /**
     * Jenis laporan yang valid
     */
    const JENIS_LAPORAN = [
        'Laporan Posisi BMN Di Neraca - Semester I',
        'Laporan Posisi BMN Di Neraca - Semester II',
        'Laporan Posisi BMN Di Neraca - Tahunan',
        'Laporan Barang Kuasa Pengguna - Persediaan - Semester I',
        'Laporan Barang Kuasa Pengguna - Persediaan - Semester II',
        'Laporan Kondisi Barang - Tahunan',
    ];

    private array $allowedFields = [
        'tahun',
        'jenis_laporan',
        'link_dokumen',
    ];

    /**
     * Ambil semua data aset BMN (PUBLIC - Read Only)
     */
    public function index(Request $request): JsonResponse
    {
        $query = AsetBmn::query();

        if ($request->has('tahun')) {
            $tahun = filter_var($request->tahun, FILTER_VALIDATE_INT);
            if ($tahun && $tahun >= 2000 && $tahun <= 2100) {
                $query->where('tahun', $tahun);
            }
        }

        $data = $query->orderBy('tahun', 'desc')
            ->orderByRaw("FIELD(jenis_laporan, '" . implode("','", self::JENIS_LAPORAN) . "')")
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data,
            'total' => $data->count(),
        ]);
    }

    /**
     * Ambil satu data aset BMN
     */
    public function show($id): JsonResponse
    {
        $item = AsetBmn::find($id);
        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }
        return response()->json(['success' => true, 'data' => $item]);
    }

    /**
     * Simpan data aset BMN baru (PROTECTED)
     */
    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'tahun'        => 'required|integer|min:2000|max:2100',
            'jenis_laporan' => 'required|string',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
        ]);

        if (!in_array($request->jenis_laporan, self::JENIS_LAPORAN)) {
            return response()->json(['success' => false, 'message' => 'Jenis laporan tidak valid'], 422);
        }

        // Cek duplikat
        $exists = AsetBmn::where('tahun', $request->tahun)
            ->where('jenis_laporan', $request->jenis_laporan)
            ->first();
        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Data untuk tahun dan jenis laporan tersebut sudah ada',
            ], 422);
        }

        $data = $request->only($this->allowedFields);

        // Handle file upload
        if ($request->hasFile('file_dokumen')) {
            $link = $this->uploadFile($request->file('file_dokumen'), $request, 'aset-bmn');
            if ($link) $data['link_dokumen'] = $link;
        }

        $item = AsetBmn::create($data);

        return response()->json(['success' => true, 'data' => $item], 201);
    }

    /**
     * Perbarui data aset BMN (PROTECTED)
     */
    public function update(Request $request, $id): JsonResponse
    {
        $item = AsetBmn::find($id);
        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        $this->validate($request, [
            'tahun'        => 'required|integer|min:2000|max:2100',
            'jenis_laporan' => 'required|string',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
        ]);

        if (!in_array($request->jenis_laporan, self::JENIS_LAPORAN)) {
            return response()->json(['success' => false, 'message' => 'Jenis laporan tidak valid'], 422);
        }

        // Cek duplikat (kecuali record ini sendiri)
        $exists = AsetBmn::where('tahun', $request->tahun)
            ->where('jenis_laporan', $request->jenis_laporan)
            ->where('id', '!=', $id)
            ->first();
        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Data untuk tahun dan jenis laporan tersebut sudah ada',
            ], 422);
        }

        $data = $request->only($this->allowedFields);

        // Handle file upload
        if ($request->hasFile('file_dokumen')) {
            $link = $this->uploadFile($request->file('file_dokumen'), $request, 'aset-bmn');
            if ($link) $data['link_dokumen'] = $link;
        }

        $item->update($data);

        return response()->json(['success' => true, 'data' => $item]);
    }

    /**
     * Hapus data aset BMN (PROTECTED)
     */
    public function destroy($id): JsonResponse
    {
        $item = AsetBmn::find($id);
        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }
        $item->delete();
        return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
    }

    /**
     * Upload file ke Google Drive atau lokal
     */
    private function uploadFile($file, Request $request, $folder = 'aset-bmn')
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

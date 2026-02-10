<?php

namespace App\Http\Controllers;

use App\Models\LhkpnReport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LhkpnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = LhkpnReport::query();

        if ($request->has('tahun')) {
            $query->where('tahun', $request->input('tahun'));
        }

        if ($request->has('jenis')) {
            $query->where('jenis_laporan', $request->input('jenis'));
        }

        if ($request->has('q')) {
            $search = $request->input('q');
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        // Default sorting
        $query->orderBy('tahun', 'desc')->orderBy('nama', 'asc');

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nip' => 'required',
            'nama' => 'required',
            'jabatan' => 'required',
            'tahun' => 'required|integer',
            'jenis_laporan' => 'required|in:LHKPN,SPT Tahunan',
            'tanggal_lapor' => 'nullable|date',
            'link_tanda_terima' => 'nullable',
            'link_dokumen_pendukung' => 'nullable',
            'file_tanda_terima' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'file_dokumen_pendukung' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        $dataInput = $request->all();

        // Handle File Upload - Tanda Terima
        if ($request->hasFile('file_tanda_terima')) {
            $link = $this->uploadFile($request->file('file_tanda_terima'), $request, 'lhkpn');
            if ($link) {
                $dataInput['link_tanda_terima'] = $link;
            }
        }

        // Handle File Upload - Dokumen Pendukung
        if ($request->hasFile('file_dokumen_pendukung')) {
            $link = $this->uploadFile($request->file('file_dokumen_pendukung'), $request, 'lhkpn');
            if ($link) {
                $dataInput['link_dokumen_pendukung'] = $link;
            }
        }

        $report = LhkpnReport::create($dataInput);

        return response()->json([
            'success' => true,
            'data' => $report
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $report = LhkpnReport::find($id);

        if (!$report) {
            return response()->json(['success' => false, 'message' => 'Data not found'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $report
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $report = LhkpnReport::find($id);

        if (!$report) {
            return response()->json(['success' => false, 'message' => 'Data not found'], 404);
        }

        $this->validate($request, [
            'nip' => 'required',
            'nama' => 'required',
            'jabatan' => 'required',
            'tahun' => 'required|integer',
            'jenis_laporan' => 'required|in:LHKPN,SPT Tahunan',
            'tanggal_lapor' => 'nullable|date',
            'link_tanda_terima' => 'nullable',
            'link_dokumen_pendukung' => 'nullable',
            'file_tanda_terima' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'file_dokumen_pendukung' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        $dataInput = $request->all();

        // Handle File Upload - Tanda Terima
        if ($request->hasFile('file_tanda_terima')) {
            $link = $this->uploadFile($request->file('file_tanda_terima'), $request, 'lhkpn');
            if ($link) {
                $dataInput['link_tanda_terima'] = $link;
            }
        }

        // Handle File Upload - Dokumen Pendukung
        if ($request->hasFile('file_dokumen_pendukung')) {
            $link = $this->uploadFile($request->file('file_dokumen_pendukung'), $request, 'lhkpn');
            if ($link) {
                $dataInput['link_dokumen_pendukung'] = $link;
            }
        }

        $report->update($dataInput);

        return response()->json([
            'success' => true,
            'data' => $report
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $report = LhkpnReport::find($id);

        if (!$report) {
            return response()->json(['success' => false, 'message' => 'Data not found'], 404);
        }

        $report->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully'
        ]);
    }

    /**
     * Upload file to Google Drive or Local Storage as fallback
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $folder
     * @return string|null
     */
    private function uploadFile($file, Request $request, $folder = 'lhkpn')
    {
        try {
            // Try Google Drive first
            if (class_exists('\App\Services\GoogleDriveService')) {
                $driveService = new \App\Services\GoogleDriveService();
                $link = $driveService->upload($file);
                
                \Illuminate\Support\Facades\Log::info('LHKPN file uploaded to Google Drive', [
                    'link' => $link
                ]);
                
                return $link;
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Google Drive upload failed for LHKPN, using local storage', [
                'error' => $e->getMessage()
            ]);
        }

        // Fallback to local storage
        try {
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', $file->getClientOriginalName());
            $destinationPath = app()->basePath('public/uploads/' . $folder);

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $filename);

            $baseUrl = $request->root();
            return $baseUrl . '/uploads/' . $folder . '/' . $filename;
        } catch (\Throwable $localEx) {
            \Illuminate\Support\Facades\Log::error('Local storage upload failed for LHKPN', [
                'error' => $localEx->getMessage()
            ]);
            return null;
        }
    }
}

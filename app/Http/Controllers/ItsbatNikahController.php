<?php

namespace App\Http\Controllers;

use App\Models\ItsbatNikah;
use Illuminate\Http\Request;

class ItsbatNikahController extends Controller
{
    public function index(Request $request)
    {
        $query = ItsbatNikah::query();

        // Filter by Year
        if ($request->has('tahun')) {
            $query->where('tahun_perkara', $request->input('tahun'));
        }

        // Search by Keyword (Numero Perkara or Names)
        if ($request->has('q')) {
            $keyword = $request->input('q');
            $query->where(function ($q) use ($keyword) {
                $q->where('nomor_perkara', 'like', "%{$keyword}%")
                    ->orWhere('pemohon_1', 'like', "%{$keyword}%")
                    ->orWhere('pemohon_2', 'like', "%{$keyword}%");
            });
        }

        // Default Sort: Latest Sidang Date desc
        $query->orderBy('tanggal_sidang', 'desc');

        $perPage = $request->input('limit', 10);
        $data = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $data->items(),
            'current_page' => $data->currentPage(),
            'last_page' => $data->lastPage(),
            'per_page' => $data->perPage(),
            'total' => $data->total(),
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nomor_perkara' => 'required|unique:itsbat_nikah,nomor_perkara',
            'pemohon_1' => 'required',
            'tanggal_sidang' => 'required|date',
            'tahun_perkara' => 'required|integer',
            'file_upload' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120' // Max 5MB
        ]);

        $dataInput = $request->all();

        // Convert empty strings to null
        array_walk_recursive($dataInput, function (&$value) {
            if (is_string($value) && trim($value) === '') {
                $value = null;
            }
        });

        // Handle File Upload
        if ($request->hasFile('file_upload')) {
            try {
                if (!class_exists('\App\Services\GoogleDriveService')) {
                    throw new \Exception('Class GoogleDriveService not found');
                }

                $driveService = new \App\Services\GoogleDriveService();
                $link = $driveService->upload($request->file('file_upload'));
                $dataInput['link_detail'] = $link;

                \Illuminate\Support\Facades\Log::info('File berhasil diupload ke Google Drive', [
                    'nomor_perkara' => $request->nomor_perkara,
                    'link' => $link
                ]);
            } catch (\Throwable $e) {
                // FALLBACK: Simpan ke Local Storage
                \Illuminate\Support\Facades\Log::error('Google Drive gagal. Menggunakan penyimpanan lokal.', [
                    'nomor_perkara' => $request->nomor_perkara,
                    'error' => $e->getMessage()
                ]);

                try {
                    $file = $request->file('file_upload');
                    $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', $file->getClientOriginalName());
                    $destinationPath = app()->basePath('public/uploads/itsbat');

                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }

                    $file->move($destinationPath, $filename);

                    $baseUrl = $request->root();
                    $link = $baseUrl . '/uploads/itsbat/' . $filename;

                    $dataInput['link_detail'] = $link;
                } catch (\Throwable $localEx) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Gagal upload file (Drive & Local): ' . $e->getMessage()
                    ], 500);
                }
            }
        }

        $data = ItsbatNikah::create($dataInput);

        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'Data Itsbat Nikah berhasil ditambahkan'
        ], 201);
    }

    public function show($id)
    {
        $data = ItsbatNikah::find($id);

        if (!$data) {
            return response()->json(['success' => false, 'message' => 'Data not found'], 404);
        }

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function update(Request $request, $id)
    {
        $data = ItsbatNikah::find($id);

        if (!$data) {
            return response()->json(['success' => false, 'message' => 'Data not found'], 404);
        }

        $this->validate($request, [
            'nomor_perkara' => 'required|unique:itsbat_nikah,nomor_perkara,' . $id,
            'pemohon_1' => 'required',
            'tanggal_sidang' => 'required|date',
            'file_upload' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120'
        ]);

        $dataInput = $request->all();

        // Convert empty strings to null
        array_walk_recursive($dataInput, function (&$value) {
            if (is_string($value) && trim($value) === '') {
                $value = null;
            }
        });

        // Handle File Upload
        if ($request->hasFile('file_upload')) {
            try {
                if (!class_exists('\App\Services\GoogleDriveService')) {
                    throw new \Exception('Class GoogleDriveService not found');
                }

                $driveService = new \App\Services\GoogleDriveService();
                $link = $driveService->upload($request->file('file_upload'));
                $dataInput['link_detail'] = $link;

                \Illuminate\Support\Facades\Log::info('File baru berhasil diupload ke Google Drive (Update)', [
                    'id' => $id,
                    'nomor_perkara' => $request->nomor_perkara,
                    'link' => $link
                ]);
            } catch (\Throwable $e) {
                // FALLBACK: Simpan ke Local Storage
                \Illuminate\Support\Facades\Log::error('Google Drive gagal. Menggunakan penyimpanan lokal.', [
                    'nomor_perkara' => $request->nomor_perkara,
                    'error' => $e->getMessage()
                ]);

                try {
                    $file = $request->file('file_upload');
                    $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', $file->getClientOriginalName());
                    $destinationPath = app()->basePath('public/uploads/itsbat');

                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }

                    $file->move($destinationPath, $filename);

                    $baseUrl = $request->root();
                    $link = $baseUrl . '/uploads/itsbat/' . $filename;

                    $dataInput['link_detail'] = $link;
                } catch (\Throwable $localEx) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Gagal upload file (Drive & Local): ' . $e->getMessage()
                    ], 500);
                }
            }
        }

        $data->update($dataInput);

        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'Data Itsbat Nikah berhasil diupdate'
        ]);
    }

    public function destroy($id)
    {
        $data = ItsbatNikah::find($id);

        if (!$data) {
            return response()->json(['success' => false, 'message' => 'Data not found'], 404);
        }

        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Itsbat Nikah berhasil dihapus'
        ]);
    }
}

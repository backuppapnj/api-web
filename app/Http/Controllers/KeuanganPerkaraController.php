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
            'file_upload' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        $exists = KeuanganPerkara::where('tahun', $request->tahun)
            ->where('bulan', $request->bulan)->first();
        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Data untuk tahun dan bulan tersebut sudah ada.',
            ], 422);
        }

        $data = $request->only($this->allowedFields);

        if ($request->hasFile('file_upload')) {
            try {
                if (!class_exists('\App\Services\GoogleDriveService')) {
                    throw new \Exception('Class GoogleDriveService not found');
                }
                $driveService = new \App\Services\GoogleDriveService();
                $data['url_detail'] = $driveService->upload($request->file('file_upload'));

                \Illuminate\Support\Facades\Log::info('Keuangan perkara: file diupload ke Google Drive', [
                    'tahun' => $request->tahun, 'bulan' => $request->bulan,
                ]);
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error('Google Drive gagal. Menggunakan penyimpanan lokal.', [
                    'error' => $e->getMessage(),
                ]);
                try {
                    $file = $request->file('file_upload');
                    $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', $file->getClientOriginalName());
                    $destinationPath = app()->basePath('public/uploads/keuangan-perkara');
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }
                    $file->move($destinationPath, $filename);
                    $data['url_detail'] = $request->root() . '/uploads/keuangan-perkara/' . $filename;
                } catch (\Throwable $localEx) {
                    return response()->json(['success' => false, 'message' => 'Gagal upload file: ' . $e->getMessage()], 500);
                }
            }
        }

        try {
            $item = KeuanganPerkara::create($data);
            return response()->json(['success' => true, 'message' => 'Data berhasil disimpan', 'data' => $item], 201);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gagal menyimpan data keuangan perkara', [
                'error' => $e->getMessage(),
                'data' => $data
            ]);
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan data: ' . $e->getMessage()], 500);
        }
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
            'file_upload' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        $data = $request->only($this->allowedFields);

        if ($request->hasFile('file_upload')) {
            try {
                if (!class_exists('\App\Services\GoogleDriveService')) {
                    throw new \Exception('Class GoogleDriveService not found');
                }
                $driveService = new \App\Services\GoogleDriveService();
                $data['url_detail'] = $driveService->upload($request->file('file_upload'));

                \Illuminate\Support\Facades\Log::info('Keuangan perkara: file diupload ke Google Drive (update)', [
                    'id' => $id,
                ]);
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error('Google Drive gagal. Menggunakan penyimpanan lokal.', [
                    'error' => $e->getMessage(),
                ]);
                try {
                    $file = $request->file('file_upload');
                    $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', $file->getClientOriginalName());
                    $destinationPath = app()->basePath('public/uploads/keuangan-perkara');
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }
                    $file->move($destinationPath, $filename);
                    $data['url_detail'] = $request->root() . '/uploads/keuangan-perkara/' . $filename;
                } catch (\Throwable $localEx) {
                    return response()->json(['success' => false, 'message' => 'Gagal upload file: ' . $e->getMessage()], 500);
                }
            }
        }

        try {
            $item->update($data);
            return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui', 'data' => $item->fresh()]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gagal update data keuangan perkara', [
                'error' => $e->getMessage(),
                'id' => $id,
                'data' => $data
            ]);
            return response()->json(['success' => false, 'message' => 'Gagal update data: ' . $e->getMessage()], 500);
        }
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

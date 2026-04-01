<?php

namespace App\Http\Controllers;

use App\Models\LraReport;
use App\Services\GoogleDriveService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LraReportController extends Controller
{
    private array $allowedFields = [
        'tahun',
        'jenis_dipa',
        'triwulan',
        'judul',
    ];

    public function index(Request $request): JsonResponse
    {
        $query = LraReport::query();

        if ($request->has('tahun')) {
            $tahun = filter_var($request->input('tahun'), FILTER_VALIDATE_INT);
            if ($tahun !== false && $tahun >= 2000 && $tahun <= 2100) {
                $query->where('tahun', $tahun);
            }
        }

        if ($request->has('jenis_dipa')) {
            $jenisDipa = trim(strip_tags((string) $request->input('jenis_dipa')));
            if (in_array($jenisDipa, ['DIPA 01', 'DIPA 04'], true)) {
                $query->where('jenis_dipa', $jenisDipa);
            }
        }

        $perPage = (int) $request->input('limit', $request->input('per_page', 10));
        $perPage = max(1, min($perPage, 100));

        $result = $query
            ->orderBy('tahun', 'desc')
            ->orderBy('jenis_dipa', 'asc')
            ->orderBy('triwulan', 'asc')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $result->items(),
            'total' => $result->total(),
            'current_page' => $result->currentPage(),
            'last_page' => $result->lastPage(),
            'per_page' => $result->perPage(),
        ]);
    }

    public function show(int $id): JsonResponse
    {
        if ($id <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'ID tidak valid',
            ], 400);
        }

        $data = LraReport::find($id);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data LRA tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'tahun' => 'required|integer|min:2000|max:2100',
            'jenis_dipa' => 'required|in:DIPA 01,DIPA 04',
            'triwulan' => 'required|integer|min:1|max:4',
            'judul' => 'required|string|max:255',
            'file_upload' => 'required|file|mimes:pdf|max:10240',
            'cover_upload' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $data = $request->only($this->allowedFields);
        $data['judul'] = trim(strip_tags((string) ($data['judul'] ?? '')));
        $data['jenis_dipa'] = trim(strip_tags((string) ($data['jenis_dipa'] ?? '')));

        try {
            $data['file_url'] = $this->uploadToGoogleDrive($request->file('file_upload'), $request, 'uploads/lra');

            if ($request->hasFile('cover_upload')) {
                $data['cover_url'] = $this->uploadToGoogleDrive($request->file('cover_upload'), $request, 'uploads/lra/covers');
            }

            $created = LraReport::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Data LRA berhasil ditambahkan',
                'data' => $created,
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data LRA: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        if ($id <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'ID tidak valid',
            ], 400);
        }

        $report = LraReport::find($id);
        if (!$report) {
            return response()->json([
                'success' => false,
                'message' => 'Data LRA tidak ditemukan',
            ], 404);
        }

        $this->validate($request, [
            'tahun' => 'required|integer|min:2000|max:2100',
            'jenis_dipa' => 'required|in:DIPA 01,DIPA 04',
            'triwulan' => 'required|integer|min:1|max:4',
            'judul' => 'required|string|max:255',
            'file_upload' => 'nullable|file|mimes:pdf|max:10240',
            'cover_upload' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $data = $request->only($this->allowedFields);
        $data['judul'] = trim(strip_tags((string) ($data['judul'] ?? '')));
        $data['jenis_dipa'] = trim(strip_tags((string) ($data['jenis_dipa'] ?? '')));

        try {
            if ($request->hasFile('file_upload')) {
                $data['file_url'] = $this->uploadToGoogleDrive($request->file('file_upload'), $request, 'uploads/lra');
            }

            if ($request->hasFile('cover_upload')) {
                $data['cover_url'] = $this->uploadToGoogleDrive($request->file('cover_upload'), $request, 'uploads/lra/covers');
            }

            $report->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Data LRA berhasil diperbarui',
                'data' => $report->fresh(),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui data LRA: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        if ($id <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'ID tidak valid',
            ], 400);
        }

        $report = LraReport::find($id);
        if (!$report) {
            return response()->json([
                'success' => false,
                'message' => 'Data LRA tidak ditemukan',
            ], 404);
        }

        $report->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data LRA berhasil dihapus',
        ]);
    }

    private function uploadToGoogleDrive($file, Request $request, string $localFolder): string
    {
        try {
            $driveService = new GoogleDriveService();
            $url = $driveService->upload($file);

            Log::info('Upload file LRA ke Google Drive berhasil', [
                'original_name' => $file->getClientOriginalName(),
                'url' => $url,
            ]);

            return $url;
        } catch (\Throwable $e) {
            Log::error('Upload ke Google Drive gagal, fallback ke penyimpanan lokal', [
                'original_name' => $file->getClientOriginalName(),
                'error' => $e->getMessage(),
            ]);

            try {
                $extension = $file->getClientOriginalExtension();
                $filename = bin2hex(random_bytes(16)) . '.' . $extension;
                $destinationPath = app()->basePath('public/' . $localFolder);

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $file->move($destinationPath, $filename);

                return $request->root() . '/' . $localFolder . '/' . $filename;
            } catch (\Throwable $localException) {
                throw new \RuntimeException('Gagal upload file ke Google Drive dan penyimpanan lokal: ' . $localException->getMessage());
            }
        }
    }
}

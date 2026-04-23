<?php

namespace App\Http\Controllers;

use App\Models\SkInovasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SkInovasiController extends Controller
{
    public function index(Request $request)
    {
        $query = SkInovasi::query();

        if ($request->has('tahun')) {
            $query->byTahun($request->tahun);
        }

        if ($request->has('active')) {
            $query->active();
        }

        $skInovasi = $query->latestYear()->get();

        return response()->json([
            'success' => true,
            'data' => $skInovasi,
        ]);
    }

    public function show($id)
    {
        $skInovasi = SkInovasi::find($id);

        if (!$skInovasi) {
            return response()->json([
                'success' => false,
                'message' => 'SK Inovasi tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $skInovasi,
        ]);
    }

    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'tahun' => 'required|integer|min:2000|max:2100',
            'nomor_sk' => 'required|string|max:255',
            'tentang' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'file_url' => 'nullable|url',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        $data = [
            'tahun' => $validated['tahun'],
            'nomor_sk' => $validated['nomor_sk'],
            'tentang' => $validated['tentang'],
            'is_active' => $request->has('is_active') ? $validated['is_active'] : true,
        ];

        // Handle file upload (Google Drive primary, local fallback)
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $uploadResult = $this->handleFileUpload($request, $file);
            if ($uploadResult['success']) {
                $data['file_url'] = $uploadResult['url'];
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $uploadResult['message']
                ], 500);
            }
        } elseif (!empty($validated['file_url'])) {
            $data['file_url'] = $validated['file_url'];
        }

        $skInovasi = SkInovasi::create($data);

        return response()->json([
            'success' => true,
            'message' => 'SK Inovasi berhasil ditambahkan',
            'data' => $skInovasi,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $skInovasi = SkInovasi::find($id);

        if (!$skInovasi) {
            return response()->json([
                'success' => false,
                'message' => 'SK Inovasi tidak ditemukan',
            ], 404);
        }

        $validator = validator($request->all(), [
            'tahun' => 'sometimes|integer|min:2000|max:2100',
            'nomor_sk' => 'sometimes|string|max:255',
            'tentang' => 'sometimes|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'file_url' => 'nullable|url',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        $data = [];

        if (isset($validated['tahun'])) $data['tahun'] = $validated['tahun'];
        if (isset($validated['nomor_sk'])) $data['nomor_sk'] = $validated['nomor_sk'];
        if (isset($validated['tentang'])) $data['tentang'] = $validated['tentang'];
        if (isset($validated['is_active'])) $data['is_active'] = $validated['is_active'];

        // Handle file upload (Google Drive primary, local fallback)
        if ($request->hasFile('file')) {
            // Delete old local file if exists
            $this->deleteLocalFile($skInovasi->file_url);

            $file = $request->file('file');
            $uploadResult = $this->handleFileUpload($request, $file);
            if ($uploadResult['success']) {
                $data['file_url'] = $uploadResult['url'];
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $uploadResult['message']
                ], 500);
            }
        } elseif (isset($validated['file_url'])) {
            $data['file_url'] = $validated['file_url'];
        }

        $skInovasi->update($data);

        return response()->json([
            'success' => true,
            'message' => 'SK Inovasi berhasil diupdate',
            'data' => $skInovasi,
        ]);
    }

    public function destroy($id)
    {
        $skInovasi = SkInovasi::find($id);

        if (!$skInovasi) {
            return response()->json([
                'success' => false,
                'message' => 'SK Inovasi tidak ditemukan',
            ], 404);
        }

        // Delete local file if exists
        $this->deleteLocalFile($skInovasi->file_url);

        $skInovasi->delete();

        return response()->json([
            'success' => true,
            'message' => 'SK Inovasi berhasil dihapus',
        ]);
    }

    /**
     * Handle file upload: Google Drive primary, local storage fallback
     */
    private function handleFileUpload(Request $request, $file): array
    {
        // Try Google Drive first
        try {
            if (!class_exists('\App\Services\GoogleDriveService')) {
                throw new \Exception('Class GoogleDriveService not found');
            }

            $driveService = new \App\Services\GoogleDriveService();
            $link = $driveService->upload($file);

            Log::info('File SK Inovasi berhasil diupload ke Google Drive', [
                'link' => $link
            ]);

            return ['success' => true, 'url' => $link];
        } catch (\Throwable $e) {
            Log::error('Google Drive gagal. Menggunakan penyimpanan lokal.', [
                'error' => $e->getMessage()
            ]);

            // Fallback: local storage
            try {
                $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', $file->getClientOriginalName());
                $destinationPath = app()->basePath('public/uploads/sk-inovasi');

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $file->move($destinationPath, $filename);

                $baseUrl = $request->root();
                $link = $baseUrl . '/uploads/sk-inovasi/' . $filename;

                Log::info('File SK Inovasi disimpan di lokal (Fallback)', ['link' => $link]);

                return ['success' => true, 'url' => $link];
            } catch (\Throwable $localEx) {
                Log::error('Gagal simpan lokal', ['error' => $localEx->getMessage()]);
                return [
                    'success' => false,
                    'message' => 'Gagal upload file (Drive & Local): ' . $localEx->getMessage()
                ];
            }
        }
    }

    /**
     * Delete local file if URL is local
     */
    private function deleteLocalFile(?string $fileUrl): void
    {
        if (empty($fileUrl)) {
            return;
        }

        $baseUrl = request()->root();
        if (str_starts_with($fileUrl, $baseUrl . '/uploads/')) {
            $relativePath = str_replace($baseUrl . '/', '', $fileUrl);
            $fullPath = app()->basePath('public/' . $relativePath);
            if (file_exists($fullPath)) {
                @unlink($fullPath);
                Log::info('File lokal dihapus', ['path' => $fullPath]);
            }
        }
    }
}

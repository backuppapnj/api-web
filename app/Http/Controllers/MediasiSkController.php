<?php

namespace App\Http\Controllers;

use App\Models\MediasiSk;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MediasiSkController extends Controller
{
    private array $allowedFields = [
        'tahun',
        'link_sk_hakim',
        'link_sk_non_hakim',
    ];

    /**
     * Ambil semua data SK Mediasi (PUBLIC)
     */
    public function index(): JsonResponse
    {
        $data = MediasiSk::orderBy('tahun', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    /**
     * Ambil satu data SK Mediasi
     */
    public function show(int $id): JsonResponse
    {
        $item = MediasiSk::find($id);
        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $item
        ]);
    }

    /**
     * Simpan data SK Mediasi (PROTECTED)
     */
    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'tahun'             => 'required|integer|unique:mediasi_sk,tahun',
            'link_sk_hakim'     => 'nullable|string',
            'link_sk_non_hakim' => 'nullable|string',
            'file_sk_hakim'     => 'nullable|file|mimes:pdf|max:20480',
            'file_sk_non_hakim' => 'nullable|file|mimes:pdf|max:20480',
        ]);

        $data = $this->sanitizeInput($request->only($this->allowedFields));

        // Handle file uploads
        if ($request->hasFile('file_sk_hakim')) {
            $link = $this->uploadFile($request->file('file_sk_hakim'), $request, 'mediasi');
            if ($link) $data['link_sk_hakim'] = $link;
        }

        if ($request->hasFile('file_sk_non_hakim')) {
            $link = $this->uploadFile($request->file('file_sk_non_hakim'), $request, 'mediasi');
            if ($link) $data['link_sk_non_hakim'] = $link;
        }

        $item = MediasiSk::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Data SK berhasil disimpan',
            'data' => $item
        ], 201);
    }

    /**
     * Update data SK Mediasi (PROTECTED)
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $item = MediasiSk::find($id);
        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $this->validate($request, [
            'tahun'             => 'sometimes|required|integer|unique:mediasi_sk,tahun,' . $id,
            'link_sk_hakim'     => 'nullable|string',
            'link_sk_non_hakim' => 'nullable|string',
            'file_sk_hakim'     => 'nullable|file|mimes:pdf|max:20480',
            'file_sk_non_hakim' => 'nullable|file|mimes:pdf|max:20480',
        ]);

        $data = $this->sanitizeInput($request->only($this->allowedFields));

        if ($request->hasFile('file_sk_hakim')) {
            $link = $this->uploadFile($request->file('file_sk_hakim'), $request, 'mediasi');
            if ($link) $data['link_sk_hakim'] = $link;
        }

        if ($request->hasFile('file_sk_non_hakim')) {
            $link = $this->uploadFile($request->file('file_sk_non_hakim'), $request, 'mediasi');
            if ($link) $data['link_sk_non_hakim'] = $link;
        }

        $item->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Data SK berhasil diperbarui',
            'data' => $item->fresh()
        ]);
    }

    /**
     * Hapus data SK Mediasi (PROTECTED)
     */
    public function destroy(int $id): JsonResponse
    {
        $item = MediasiSk::find($id);
        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data SK berhasil dihapus'
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\MediatorBanner;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MediatorBannerController extends Controller
{
    private array $allowedFields = [
        'judul',
        'image_url',
        'type',
    ];

    /**
     * Ambil semua banner mediator (PUBLIC)
     */
    public function index(): JsonResponse
    {
        $data = MediatorBanner::orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    /**
     * Ambil satu data banner
     */
    public function show(int $id): JsonResponse
    {
        $item = MediatorBanner::find($id);
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
     * Simpan banner baru (PROTECTED)
     */
    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'judul'     => 'required|string|max:100',
            'image_url' => 'nullable|string',
            'type'      => 'required|in:hakim,non-hakim',
            'image_file' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
        ]);

        $data = $this->sanitizeInput($request->only($this->allowedFields));

        if ($request->hasFile('image_file')) {
            $link = $this->uploadFile($request->file('image_file'), $request, 'mediator');
            if ($link) $data['image_url'] = $link;
        }

        $item = MediatorBanner::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Banner berhasil disimpan',
            'data' => $item
        ], 201);
    }

    /**
     * Update banner (PROTECTED)
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $item = MediatorBanner::find($id);
        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $this->validate($request, [
            'judul'     => 'sometimes|required|string|max:100',
            'image_url' => 'nullable|string',
            'type'      => 'sometimes|required|in:hakim,non-hakim',
            'image_file' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
        ]);

        $data = $this->sanitizeInput($request->only($this->allowedFields));

        if ($request->hasFile('image_file')) {
            $link = $this->uploadFile($request->file('image_file'), $request, 'mediator');
            if ($link) $data['image_url'] = $link;
        }

        $item->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Banner berhasil diperbarui',
            'data' => $item->fresh()
        ]);
    }

    /**
     * Hapus banner (PROTECTED)
     */
    public function destroy(int $id): JsonResponse
    {
        $item = MediatorBanner::find($id);
        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Banner berhasil dihapus'
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Inovasi;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class InovasiController extends Controller
{
    private array $allowedFields = [
        'nama_inovasi',
        'deskripsi',
        'kategori',
        'link_dokumen',
        'urutan',
    ];

    /**
     * Ambil semua data Inovasi (PUBLIC - Read Only)
     */
    public function index(Request $request): JsonResponse
    {
        $query = Inovasi::query();

        // Filter by kategori
        if ($request->has('kategori')) {
            $kategori = trim(strip_tags($request->kategori));
            if ($kategori !== '') {
                $query->where('kategori', $kategori);
            }
        }

        // Order by urutan ASC, nama_inovasi ASC
        $data = $query->orderBy('urutan', 'asc')
            ->orderBy('nama_inovasi', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data,
            'total' => $data->count(),
        ]);
    }

    /**
     * Ambil satu data Inovasi
     */
    public function show(int $id): JsonResponse
    {
        if ($id <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'ID tidak valid'
            ], 400);
        }

        $item = Inovasi::find($id);
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
     * Simpan data Inovasi baru (PROTECTED)
     */
    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'nama_inovasi'  => 'required|string|max:255',
            'deskripsi'     => 'required|string',
            'kategori'      => 'required|string|max:100',
            'link_dokumen'  => 'nullable|string|max:500',
            'urutan'        => 'nullable|integer|min:0',
            'file_dokumen'  => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:20480',
        ]);

        // Cek duplikat (nama_inovasi + kategori)
        $exists = Inovasi::where('nama_inovasi', $request->nama_inovasi)
            ->where('kategori', $request->kategori)
            ->first();
        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Data dengan nama inovasi dan kategori tersebut sudah ada',
            ], 422);
        }

        $data = $this->sanitizeInput($request->only($this->allowedFields), ['deskripsi']);

        // Handle file upload
        if ($request->hasFile('file_dokumen')) {
            $link = $this->uploadFile($request->file('file_dokumen'), $request, 'inovasi');
            if ($link) $data['link_dokumen'] = $link;
        }

        $item = Inovasi::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan',
            'data' => $item
        ], 201);
    }

    /**
     * Perbarui data Inovasi (PROTECTED)
     */
    public function update(Request $request, int $id): JsonResponse
    {
        if ($id <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'ID tidak valid'
            ], 400);
        }

        $item = Inovasi::find($id);
        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $this->validate($request, [
            'nama_inovasi'  => 'sometimes|required|string|max:255',
            'deskripsi'     => 'sometimes|required|string',
            'kategori'      => 'sometimes|required|string|max:100',
            'link_dokumen'  => 'nullable|string|max:500',
            'urutan'        => 'nullable|integer|min:0',
            'file_dokumen'  => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:20480',
        ]);

        // Cek duplikat (kecuali record ini sendiri)
        if ($request->has('nama_inovasi') || $request->has('kategori')) {
            $namaInovasi = $request->nama_inovasi ?? $item->nama_inovasi;
            $kategori = $request->kategori ?? $item->kategori;
            $exists = Inovasi::where('nama_inovasi', $namaInovasi)
                ->where('kategori', $kategori)
                ->where('id', '!=', $id)
                ->first();
            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data dengan nama inovasi dan kategori tersebut sudah ada',
                ], 422);
            }
        }

        $data = $this->sanitizeInput($request->only($this->allowedFields), ['deskripsi']);

        // Handle file upload
        if ($request->hasFile('file_dokumen')) {
            $link = $this->uploadFile($request->file('file_dokumen'), $request, 'inovasi');
            if ($link) $data['link_dokumen'] = $link;
        }

        $item->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diperbarui',
            'data' => $item->fresh()
        ]);
    }

    /**
     * Hapus data Inovasi (PROTECTED)
     */
    public function destroy(int $id): JsonResponse
    {
        if ($id <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'ID tidak valid'
            ], 400);
        }

        $item = Inovasi::find($id);
        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}

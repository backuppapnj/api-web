<?php

namespace App\Http\Controllers;

use App\Models\SkInovasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $validated = $request->validate([
            'tahun' => 'required|integer|min:2000|max:2100',
            'nomor_sk' => 'required|string|max:255',
            'tentang' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'file_url' => 'nullable|url',
            'is_active' => 'boolean',
        ]);

        $data = [
            'tahun' => $validated['tahun'],
            'nomor_sk' => $validated['nomor_sk'],
            'tentang' => $validated['tentang'],
            'is_active' => $request->has('is_active') ? $validated['is_active'] : true,
        ];

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('sk-inovasi', $fileName, 'public');
            $data['file_path'] = $filePath;
            $data['file_url'] = Storage::url($filePath);
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

        $validated = $request->validate([
            'tahun' => 'sometimes|integer|min:2000|max:2100',
            'nomor_sk' => 'sometimes|string|max:255',
            'tentang' => 'sometimes|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'file_url' => 'nullable|url',
            'is_active' => 'boolean',
        ]);

        $data = [];

        if (isset($validated['tahun'])) $data['tahun'] = $validated['tahun'];
        if (isset($validated['nomor_sk'])) $data['nomor_sk'] = $validated['nomor_sk'];
        if (isset($validated['tentang'])) $data['tentang'] = $validated['tentang'];
        if (isset($validated['is_active'])) $data['is_active'] = $validated['is_active'];

        // Handle file upload
        if ($request->hasFile('file')) {
            // Delete old file
            if ($skInovasi->file_path) {
                Storage::disk('public')->delete($skInovasi->file_path);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('sk-inovasi', $fileName, 'public');
            $data['file_path'] = $filePath;
            $data['file_url'] = Storage::url($filePath);
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

        // Delete file if exists
        if ($skInovasi->file_path) {
            Storage::disk('public')->delete($skInovasi->file_path);
        }

        $skInovasi->delete();

        return response()->json([
            'success' => true,
            'message' => 'SK Inovasi berhasil dihapus',
        ]);
    }
}

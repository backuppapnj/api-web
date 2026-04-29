<?php

namespace App\Http\Controllers;

use App\Models\SkRadiusBiaya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SkRadiusBiayaController extends Controller
{
    public function index(Request $request)
    {
        $query = SkRadiusBiaya::query();

        if ($request->has('tahun')) {
            $query->byTahun($request->tahun);
        }

        if ($request->has('active')) {
            $query->active();
        }

        $data = $query->latestYear()->get();

        // Parse metadata_json for each record
        $data->transform(function ($item) {
            if ($item->metadata_json && is_string($item->metadata_json)) {
                $decoded = json_decode($item->metadata_json, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $item->metadata = $decoded;
                }
            }
            return $item;
        });

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function show($id)
    {
        $item = SkRadiusBiaya::find($id);

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'SK Radius Biaya tidak ditemukan',
            ], 404);
        }

        // Parse metadata_json
        if ($item->metadata_json && is_string($item->metadata_json)) {
            $decoded = json_decode($item->metadata_json, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $item->metadata = $decoded;
            }
        }

        return response()->json([
            'success' => true,
            'data' => $item,
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
            'metadata_json' => 'nullable|string',
        ]);

        $data = [
            'tahun' => $validated['tahun'],
            'nomor_sk' => $validated['nomor_sk'],
            'tentang' => $validated['tentang'],
            'is_active' => $request->has('is_active') ? (bool) $validated['is_active'] : true,
        ];

        // Handle metadata_json
        if (!empty($validated['metadata_json'])) {
            $data['metadata_json'] = $validated['metadata_json'];
        }

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('sk-radius-biaya', $fileName, 'public');
            $data['file_path'] = $filePath;
            $data['file_url'] = Storage::url($filePath);
        } elseif (!empty($validated['file_url'])) {
            $data['file_url'] = $validated['file_url'];
        }

        $item = SkRadiusBiaya::create($data);

        return response()->json([
            'success' => true,
            'message' => 'SK Radius Biaya berhasil ditambahkan',
            'data' => $item,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $item = SkRadiusBiaya::find($id);

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'SK Radius Biaya tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'tahun' => 'sometimes|integer|min:2000|max:2100',
            'nomor_sk' => 'sometimes|string|max:255',
            'tentang' => 'sometimes|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'file_url' => 'nullable|url',
            'is_active' => 'boolean',
            'metadata_json' => 'nullable|string',
        ]);

        $data = [];

        if (isset($validated['tahun'])) $data['tahun'] = $validated['tahun'];
        if (isset($validated['nomor_sk'])) $data['nomor_sk'] = $validated['nomor_sk'];
        if (isset($validated['tentang'])) $data['tentang'] = $validated['tentang'];
        if (isset($validated['is_active'])) $data['is_active'] = (bool) $validated['is_active'];
        if (isset($validated['metadata_json'])) $data['metadata_json'] = $validated['metadata_json'];

        // Handle file upload
        if ($request->hasFile('file')) {
            // Delete old file
            if ($item->file_path) {
                Storage::disk('public')->delete($item->file_path);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('sk-radius-biaya', $fileName, 'public');
            $data['file_path'] = $filePath;
            $data['file_url'] = Storage::url($filePath);
        } elseif (isset($validated['file_url'])) {
            $data['file_url'] = $validated['file_url'];
        }

        $item->update($data);

        return response()->json([
            'success' => true,
            'message' => 'SK Radius Biaya berhasil diupdate',
            'data' => $item,
        ]);
    }

    public function destroy($id)
    {
        $item = SkRadiusBiaya::find($id);

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'SK Radius Biaya tidak ditemukan',
            ], 404);
        }

        // Delete file if exists
        if ($item->file_path) {
            Storage::disk('public')->delete($item->file_path);
        }

        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'SK Radius Biaya berhasil dihapus',
        ]);
    }
}

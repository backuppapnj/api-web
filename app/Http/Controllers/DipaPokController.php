<?php

namespace App\Http\Controllers;

use App\Models\DipaPok;
use Illuminate\Http\Request;

class DipaPokController extends Controller
{
    public function index(Request $request)
    {
        $query = DipaPok::query();
        
        if ($request->has('tahun')) {
            $query->where('thn_dipa', $request->input('tahun'));
        }

        if ($request->has('q')) {
            $search = $request->input('q');
            $query->where(function($q) use ($search) {
                $q->where('jns_dipa', 'like', "%{$search}%")
                  ->orWhere('revisi_dipa', 'like', "%{$search}%");
            });
        }

        $query->orderBy('thn_dipa', 'desc')->orderBy('kode_dipa', 'desc');

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

    public function store(Request $request)
    {
        $this->validate($request, [
            'thn_dipa' => 'required|integer',
            'revisi_dipa' => 'required|string|max:50',
            'jns_dipa' => 'required|string|max:100',
            'tgl_dipa' => 'required|date',
            'alokasi_dipa' => 'required|numeric',
            'file_doc_dipa' => 'nullable|file|mimes:pdf|max:10240',
            'file_doc_pok' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $data = $request->only([
            'thn_dipa',
            'revisi_dipa',
            'jns_dipa',
            'tgl_dipa',
            'alokasi_dipa',
            'doc_dipa',
            'doc_pok'
        ]);

        // Upload file DIPA
        if ($request->hasFile('file_doc_dipa')) {
            $link = $this->uploadFile($request->file('file_doc_dipa'), $request, 'dipa');
            if ($link) {
                $data['doc_dipa'] = $link;
            }
        }

        // Upload file POK
        if ($request->hasFile('file_doc_pok')) {
            $link = $this->uploadFile($request->file('file_doc_pok'), $request, 'pok');
            if ($link) {
                $data['doc_pok'] = $link;
            }
        }

        $dipaPok = DipaPok::create($data);

        return response()->json([
            'success' => true,
            'data' => $dipaPok,
            'message' => 'Data DIPA/POK berhasil ditambahkan'
        ], 201);
    }

    public function show($id)
    {
        $dipaPok = DipaPok::find($id);

        if (!$dipaPok) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $dipaPok
        ]);
    }

    public function update(Request $request, $id)
    {
        $dipaPok = DipaPok::find($id);

        if (!$dipaPok) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $this->validate($request, [
            'thn_dipa' => 'required|integer',
            'revisi_dipa' => 'required|string|max:50',
            'jns_dipa' => 'required|string|max:100',
            'tgl_dipa' => 'required|date',
            'alokasi_dipa' => 'required|numeric',
            'file_doc_dipa' => 'nullable|file|mimes:pdf|max:10240',
            'file_doc_pok' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $data = $request->only([
            'thn_dipa',
            'revisi_dipa',
            'jns_dipa',
            'tgl_dipa',
            'alokasi_dipa',
            'doc_dipa',
            'doc_pok'
        ]);

        // Upload file DIPA baru jika ada
        if ($request->hasFile('file_doc_dipa')) {
            $link = $this->uploadFile($request->file('file_doc_dipa'), $request, 'dipa');
            if ($link) {
                $data['doc_dipa'] = $link;
            }
        }

        // Upload file POK baru jika ada
        if ($request->hasFile('file_doc_pok')) {
            $link = $this->uploadFile($request->file('file_doc_pok'), $request, 'pok');
            if ($link) {
                $data['doc_pok'] = $link;
            }
        }

        $dipaPok->update($data);

        return response()->json([
            'success' => true,
            'data' => $dipaPok,
            'message' => 'Data DIPA/POK berhasil diperbarui'
        ]);
    }

    public function destroy($id)
    {
        $dipaPok = DipaPok::find($id);

        if (!$dipaPok) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $dipaPok->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data DIPA/POK berhasil dihapus'
        ]);
    }

    private function uploadFile($file, Request $request, $type = 'dipa')
    {
        try {
            // Coba upload ke Google Drive jika service tersedia
            if (class_exists('\App\Services\GoogleDriveService')) {
                $driveService = new \App\Services\GoogleDriveService();
                return $driveService->upload($file);
            }
        } catch (\Throwable $e) {
            // Fallback ke local storage
        }

        // Upload ke local storage
        $filename = time() . '_' . $type . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', $file->getClientOriginalName());
        $destinationPath = app()->basePath('public/uploads/dipapok');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $file->move($destinationPath, $filename);

        return $request->root() . '/uploads/dipapok/' . $filename;
    }
}

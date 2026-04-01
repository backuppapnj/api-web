<?php

namespace App\Http\Controllers;

use App\Models\Mou;
use Illuminate\Http\Request;

class MouController extends Controller
{
    public function index(Request $request)
    {
        $query = Mou::query();

        if ($request->has('tahun')) {
            $query->where('tahun', $request->input('tahun'));
        }

        $query->orderBy('tanggal', 'desc');

        $perPage = $request->input('per_page', 15);
        $paginated = $query->paginate($perPage);

        // Hitung status secara dinamis
        $today = now()->startOfDay();
        foreach ($paginated as $item) {
            $this->applyStatus($item, $today);
        }

        return response()->json([
            'success' => true,
            'data' => $paginated->items(),
            'total' => $paginated->total(),
            'current_page' => $paginated->currentPage(),
            'last_page' => $paginated->lastPage(),
            'per_page' => $paginated->perPage(),
        ]);
    }

    public function show($id)
    {
        $mou = Mou::find($id);
        if (!$mou) {
            return response()->json(['success' => false, 'message' => 'Data not found'], 404);
        }

        $this->applyStatus($mou, now()->startOfDay());

        return response()->json(['success' => true, 'data' => $mou]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'tanggal' => 'required|date',
            'instansi' => 'required|max:255',
            'tentang' => 'required',
            'tanggal_berakhir' => 'nullable|date|after_or_equal:tanggal',
            'file_dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $data = $this->sanitizeInput($request->except('file_dokumen'));

        // Upload file jika ada
        if ($request->hasFile('file_dokumen')) {
            $link = $this->uploadFile($request->file('file_dokumen'), $request, 'mou');
            if ($link) $data['link_dokumen'] = $link;
        }

        // Ekstrak tahun dari tanggal
        $data['tahun'] = date('Y', strtotime($data['tanggal']));

        $mou = Mou::create($data);
        return response()->json(['success' => true, 'data' => $mou], 201);
    }

    public function update(Request $request, $id)
    {
        $mou = Mou::find($id);
        if (!$mou) {
            return response()->json(['success' => false, 'message' => 'Data not found'], 404);
        }

        $this->validate($request, [
            'tanggal' => 'required|date',
            'instansi' => 'required|max:255',
            'tentang' => 'required',
            'tanggal_berakhir' => 'nullable|date|after_or_equal:tanggal',
            'file_dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $data = $this->sanitizeInput($request->except('file_dokumen'));

        // Upload file baru jika ada
        if ($request->hasFile('file_dokumen')) {
            $link = $this->uploadFile($request->file('file_dokumen'), $request, 'mou');
            if ($link) $data['link_dokumen'] = $link;
        }

        // Ekstrak tahun dari tanggal
        $data['tahun'] = date('Y', strtotime($data['tanggal']));

        $mou->update($data);
        return response()->json(['success' => true, 'data' => $mou]);
    }

    public function destroy($id)
    {
        Mou::destroy($id);
        return response()->json(['success' => true]);
    }

    /**
     * Hitung status aktif/kadaluarsa dan sisa hari secara dinamis.
     */
    private function applyStatus(Mou $item, $today): void
    {
        if (!$item->tanggal_berakhir) {
            $item->setAttribute('status', 'tidak_diketahui');
            $item->setAttribute('sisa_hari', null);
            return;
        }

        $berakhir = $item->tanggal_berakhir->startOfDay();

        if ($berakhir->lt($today)) {
            $item->setAttribute('status', 'kadaluarsa');
            $item->setAttribute('sisa_hari', null);
        } else {
            $item->setAttribute('status', 'aktif');
            $item->setAttribute('sisa_hari', $today->diffInDays($berakhir));
        }
    }
}

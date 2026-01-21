<?php

namespace App\Http\Controllers;

use App\Models\ItsbatNikah;
use Illuminate\Http\Request;

class ItsbatNikahController extends Controller
{
    public function index(Request $request)
    {
        $query = ItsbatNikah::query();

        // Filter by Year
        if ($request->has('tahun')) {
            $query->where('tahun_perkara', $request->input('tahun'));
        }

        // Search by Keyword (Numero Perkara or Names)
        if ($request->has('q')) {
            $keyword = $request->input('q');
            $query->where(function ($q) use ($keyword) {
                $q->where('nomor_perkara', 'like', "%{$keyword}%")
                    ->orWhere('pemohon_1', 'like', "%{$keyword}%")
                    ->orWhere('pemohon_2', 'like', "%{$keyword}%");
            });
        }

        // Default Sort: Latest Sidang Date desc
        $query->orderBy('tanggal_sidang', 'desc');

        return response()->json([
            'success' => true,
            'data' => $query->get()
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nomor_perkara' => 'required|unique:itsbat_nikah,nomor_perkara',
            'pemohon_1' => 'required',
            'tanggal_sidang' => 'required|date',
            'tahun_perkara' => 'required|integer',
        ]);

        $data = ItsbatNikah::create($request->all());

        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'Data Itsbat Nikah berhasil ditambahkan'
        ], 201);
    }

    public function show($id)
    {
        $data = ItsbatNikah::find($id);

        if (!$data) {
            return response()->json(['success' => false, 'message' => 'Data not found'], 404);
        }

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function update(Request $request, $id)
    {
        $data = ItsbatNikah::find($id);

        if (!$data) {
            return response()->json(['success' => false, 'message' => 'Data not found'], 404);
        }

        $this->validate($request, [
            'nomor_perkara' => 'required|unique:itsbat_nikah,nomor_perkara,' . $id,
            'pemohon_1' => 'required',
            'tanggal_sidang' => 'required|date',
        ]);

        $data->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'Data Itsbat Nikah berhasil diupdate'
        ]);
    }

    public function destroy($id)
    {
        $data = ItsbatNikah::find($id);

        if (!$data) {
            return response()->json(['success' => false, 'message' => 'Data not found'], 404);
        }

        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Itsbat Nikah berhasil dihapus'
        ]);
    }
}

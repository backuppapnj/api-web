<?php

namespace App\Http\Controllers;

use App\Models\PaguAnggaran;
use Illuminate\Http\Request;

class PaguAnggaranController extends Controller
{
    public function index(Request $request)
    {
        $query = PaguAnggaran::query();
        if ($request->has('tahun')) $query->where('tahun', $request->input('tahun'));
        if ($request->has('dipa')) $query->where('dipa', $request->input('dipa'));
        
        return response()->json(['success' => true, 'data' => $query->get()]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'dipa' => 'required',
            'kategori' => 'required',
            'jumlah_pagu' => 'required|numeric',
            'tahun' => 'required|integer',
        ]);

        $pagu = PaguAnggaran::updateOrCreate(
            ['dipa' => $request->dipa, 'kategori' => $request->kategori, 'tahun' => $request->tahun],
            ['jumlah_pagu' => $request->jumlah_pagu]
        );

        return response()->json(['success' => true, 'data' => $pagu]);
    }

    public function destroy($id)
    {
        PaguAnggaran::destroy($id);
        return response()->json(['success' => true, 'message' => 'Deleted']);
    }
}

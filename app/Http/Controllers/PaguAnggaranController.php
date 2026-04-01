<?php

namespace App\Http\Controllers;

use App\Models\PaguAnggaran;
use App\Models\RealisasiAnggaran;
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
            'jumlah_pagu' => 'required|numeric|min:0|max:999999999999.99',
            'tahun' => 'required|integer',
        ]);

        $pagu = PaguAnggaran::updateOrCreate(
            ['dipa' => $request->dipa, 'kategori' => $request->kategori, 'tahun' => $request->tahun],
            ['jumlah_pagu' => $request->jumlah_pagu]
        );

        // Update related realisasi data with new pagu value
        $this->updateRelatedRealisasi($request->dipa, $request->kategori, $request->tahun, $request->jumlah_pagu);

        return response()->json(['success' => true, 'data' => $pagu]);
    }

    /**
     * Update related realisasi data when pagu is updated
     */
    private function updateRelatedRealisasi($dipa, $kategori, $tahun, $newPaguValue)
    {
        // Find all realisasi data with matching dipa, kategori, tahun
        $relatedRealisasi = RealisasiAnggaran::where('dipa', $dipa)
                                            ->where('kategori', $kategori)
                                            ->where('tahun', $tahun)
                                            ->get();

        foreach ($relatedRealisasi as $realisasi) {
            $realisasi->pagu = $newPaguValue;
            $realisasi->sisa = $newPaguValue - $realisasi->realisasi;
            $realisasi->persentase = $newPaguValue > 0 ? ($realisasi->realisasi / $newPaguValue) * 100 : 0;
            $realisasi->save();
        }
    }

    public function destroy($id)
    {
        PaguAnggaran::destroy($id);
        return response()->json(['success' => true, 'message' => 'Deleted']);
    }
}

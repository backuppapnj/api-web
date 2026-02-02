<?php

namespace App\Http\Controllers;

use App\Models\LhkpnReport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LhkpnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = LhkpnReport::query();

        if ($request->has('tahun')) {
            $query->where('tahun', $request->input('tahun'));
        }

        if ($request->has('jenis')) {
            $query->where('jenis_laporan', $request->input('jenis'));
        }

        if ($request->has('q')) {
            $search = $request->input('q');
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        // Default sorting
        $query->orderBy('tahun', 'desc')->orderBy('nama', 'asc');

        return response()->json([
            'success' => true,
            'data' => $query->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nip' => 'required',
            'nama' => 'required',
            'jabatan' => 'required',
            'tahun' => 'required|integer',
            'jenis_laporan' => 'required|in:LHKPN,SPT Tahunan',
            'tanggal_lapor' => 'nullable|date',
            'link_tanda_terima' => 'nullable|url',
            'link_dokumen_pendukung' => 'nullable|url',
        ]);

        $report = LhkpnReport::create($request->all());

        return response()->json([
            'success' => true,
            'data' => $report
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $report = LhkpnReport::find($id);

        if (!$report) {
            return response()->json(['success' => false, 'message' => 'Data not found'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $report
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $report = LhkpnReport::find($id);

        if (!$report) {
            return response()->json(['success' => false, 'message' => 'Data not found'], 404);
        }

        $this->validate($request, [
            'nip' => 'required',
            'nama' => 'required',
            'jabatan' => 'required',
            'tahun' => 'required|integer',
            'jenis_laporan' => 'required|in:LHKPN,SPT Tahunan',
            'tanggal_lapor' => 'nullable|date',
            'link_tanda_terima' => 'nullable|url',
            'link_dokumen_pendukung' => 'nullable|url',
        ]);

        $report->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $report
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $report = LhkpnReport::find($id);

        if (!$report) {
            return response()->json(['success' => false, 'message' => 'Data not found'], 404);
        }

        $report->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully'
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\AgendaPimpinan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AgendaPimpinanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = AgendaPimpinan::query();

        // Filter by Month (01-12)
        if ($request->has('bulan')) {
            $query->whereMonth('tanggal_agenda', $request->bulan);
        }

        // Filter by Year (e.g., 2025)
        if ($request->has('tahun')) {
            $query->whereYear('tanggal_agenda', $request->tahun);
        }

        // Limit results if requested (e.g. for module/sidebar)
        if ($request->has('limit')) {
            $query->limit((int) $request->limit);
        }

        // Default sort: Latest date first
        $data = $query->orderBy('tanggal_agenda', 'desc')->get();

        return response()->json([
            'status' => 'success',
            'data' => $data
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
        $validator = Validator::make($request->all(), [
            'tanggal_agenda' => 'required|date',
            'isi_agenda' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $agenda = AgendaPimpinan::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Agenda berhasil ditambahkan',
            'data' => $agenda
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
        $agenda = AgendaPimpinan::find($id);

        if (!$agenda) {
            return response()->json(['status' => 'error', 'message' => 'Data not found'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $agenda]);
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
        $agenda = AgendaPimpinan::find($id);

        if (!$agenda) {
            return response()->json(['status' => 'error', 'message' => 'Data not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'tanggal_agenda' => 'sometimes|required|date',
            'isi_agenda' => 'sometimes|required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $agenda->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Agenda berhasil diperbarui',
            'data' => $agenda
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
        $agenda = AgendaPimpinan::find($id);

        if (!$agenda) {
            return response()->json(['status' => 'error', 'message' => 'Data not found'], 404);
        }

        $agenda->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Agenda berhasil dihapus'
        ]);
    }
}

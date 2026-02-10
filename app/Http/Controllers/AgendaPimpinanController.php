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

        // Default sort: Latest date first
        $query->orderBy('tanggal_agenda', 'desc');

        // Check if pagination is requested (default yes for admin)
        $perPage = $request->input('per_page', 10);
        $paginated = $query->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $paginated->items(),
            'total' => $paginated->total(),
            'current_page' => $paginated->currentPage(),
            'last_page' => $paginated->lastPage(),
            'per_page' => $paginated->perPage(),
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

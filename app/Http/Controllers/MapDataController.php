<?php

namespace App\Http\Controllers;

use App\Models\Marker;
use App\Models\Polygon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MapDataController extends Controller
{
    // Menampilkan halaman interactive
    public function index()
    {
        return view('interactive');
    }

    // Mendapatkan semua marker dari database
    public function getMarkers()
    {
        $markers = Marker::all();
        return response()->json($markers);
    }

    // Mendapatkan semua polygon dari database
    public function getPolygons()
    {
        return response()->json(Polygon::all());
    }

    // Menyimpan marker baru
    public function storeMarker(Request $request)
    {
        Log::info($request->all()); // Debug input
        $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        try {
            $marker = Marker::create($request->all());
            return response()->json(['message' => 'Marker berhasil ditambahkan!', 'data' => $marker], 201);
        } catch (\Exception $e) {
            Log::error('Error creating marker:', ['message' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Menyimpan polygon baru
    public function storePolygon(Request $request)
    {
        Log::info('Data diterima untuk polygon:', ['data' => $request->all()]);

        $request->validate([
            'coordinates' => 'required|json',
        ]);

        $coordinates = json_decode($request->coordinates, true);

        if (!is_array($coordinates)) {
            return response()->json(['error' => 'Format koordinat tidak valid'], 400);
        }

        try {
            $polygon = Polygon::create([
                'coordinates' => json_encode($coordinates),
            ]);
            return response()->json(['message' => 'Polygon berhasil ditambahkan!', 'data' => $polygon], 201);
        } catch (\Exception $e) {
            Log::error('Error creating polygon:', ['message' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



    // Menghapus marker berdasarkan ID
    public function deleteMarker($id)
    {
        $marker = Marker::find($id);
        if (!$marker) {
            return response()->json(['error' => 'Marker tidak ditemukan'], 404);
        }

        try {
            $marker->delete();
            return response()->json(['message' => 'Marker berhasil dihapus!'], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting marker:', ['id' => $id, 'message' => $e->getMessage()]);
            return response()->json(['error' => 'Terjadi kesalahan saat menghapus marker'], 500);
        }
    }



    // Menghapus polygon berdasarkan ID
    public function deletePolygon($id)
    {
        $polygon = Polygon::find($id);
        if (!$polygon) {
            return response()->json(['error' => 'Polygon tidak ditemukan'], 404);
        }

        try {
            $polygon->delete();
            return response()->json(['message' => 'Polygon berhasil dihapus!'], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting polygon:', ['id' => $id, 'message' => $e->getMessage()]);
            return response()->json(['error' => 'Terjadi kesalahan saat menghapus polygon'], 500);
        }
    }


    // Mendapatkan data marker berdasarkan ID
    public function viewMarker($id)
    {
        $marker = Marker::findOrFail($id);
        return response()->json($marker);
    }

    // Mendapatkan data polygon berdasarkan ID
    public function viewPolygon($id)
    {
        $polygon = Polygon::findOrFail($id);
        return response()->json($polygon);
    }

    // Menampilkan view 
    public function jarak()
    {
        return view('crud_view_maps');
    }
}

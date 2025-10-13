<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Career;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    // Ambil semua career beserta kategorinya
    public function index()
    {
        $careers = Career::with('category')->get();

        return response()->json([
            'success' => true,
            'data' => $careers
        ]);
    }

    // Ambil career berdasarkan id
    public function show($id)
    {
        $career = Career::with('category')->find($id);

        if (!$career) {
            return response()->json(['success' => false, 'message' => 'Career tidak ditemukan'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $career
        ]);
    }

    // Buat career baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:category_career,id',
        ]);

        $career = Career::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Career berhasil dibuat',
            'data' => $career
        ]);
    }

    // Update career
    public function update(Request $request, $id)
    {
        $career = Career::find($id);

        if (!$career) {
            return response()->json(['success' => false, 'message' => 'Career tidak ditemukan'], 404);
        }

        $career->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Career berhasil diupdate',
            'data' => $career
        ]);
    }

    // Hapus career
    public function destroy($id)
    {
        $career = Career::find($id);

        if (!$career) {
            return response()->json(['success' => false, 'message' => 'Career tidak ditemukan'], 404);
        }

        $career->delete();

        return response()->json([
            'success' => true,
            'message' => 'Career berhasil dihapus'
        ]);
    }
}
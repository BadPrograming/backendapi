<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CategoryCareer;
use Illuminate\Http\Request;

class CategoryCareerController extends Controller
{
    public function index()
    {
        $categories = CategoryCareer::with('career')->get();

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    public function show($id)
    {
        $category = CategoryCareer::with('career')->find($id);

        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Kategori karir tidak ditemukan'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $category
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category = CategoryCareer::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Kategori karir berhasil dibuat',
            'data' => $category
        ]);
    }

    public function update(Request $request, $id)
    {
        $category = CategoryCareer::find($id);

        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Kategori karir tidak ditemukan'], 404);
        }

        $category->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Kategori karir berhasil diupdate',
            'data' => $category
        ]);
    }

    public function destroy($id)
    {
        $category = CategoryCareer::find($id);

        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Kategori karir tidak ditemukan'], 404);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kategori karir berhasil dihapus'
        ]);
    }
}
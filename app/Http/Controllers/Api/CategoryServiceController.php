<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CategoryService;
use Illuminate\Http\Request;

class CategoryServiceController extends Controller
{
    // Ambil semua kategori beserta Servicenya
    public function index()
    {
        $categories = CategoryService::with('service')->get();

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    // Ambil kategori berdasarkan id beserta layanannya
    public function show($id)
    {
        $category = CategoryService::with('service')->find($id);

        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Kategori tidak ditemukan'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $category
        ]);
    }

    // Buat kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category = CategoryService::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil dibuat',
            'data' => $category
        ]);
    }

    // Update kategori
    public function update(Request $request, $id)
    {
        $category = CategoryService::find($id);

        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Kategori tidak ditemukan'], 404);
        }

        $category->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil diupdate',
            'data' => $category
        ]);
    }

    // Hapus kategori
    public function destroy($id)
    {
        $category = CategoryService::find($id);

        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Kategori tidak ditemukan'], 404);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil dihapus'
        ]);
    }
}
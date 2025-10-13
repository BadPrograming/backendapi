<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    // Ambil semua halaman
    public function index()
    {
        $pages = Page::all()->map(function ($page) {
            if ($page->image) {
                $page->image = asset('storage/' . $page->image);
            }
            return $page;
        });

        return response()->json([
            'success' => true,
            'data' => $pages
        ]);
    }

    // Ambil halaman berdasarkan id
    public function show($id)
    {
        $page = Page::find($id);

        if (!$page) {
            return response()->json(['success' => false, 'message' => 'Page tidak ditemukan'], 404);
        }

        if ($page->image) {
            $page->image = asset('storage/' . $page->image);
        }

        return response()->json([
            'success' => true,
            'data' => $page
        ]);
    }

    // Buat halaman baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'nullable|string|max:100',
            'tagline' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('pages', 'public');
            $data['image'] = $path;
        }

        $page = Page::create($data);

        if ($page->image) {
            $page->image = asset('storage/' . $page->image);
        }

        return response()->json([
            'success' => true,
            'message' => 'Page berhasil dibuat',
            'data' => $page
        ]);
    }

    // Update halaman
    public function update(Request $request, $id)
    {
        $page = Page::find($id);

        if (!$page) {
            return response()->json(['success' => false, 'message' => 'Page tidak ditemukan'], 404);
        }

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'type' => 'nullable|string|max:100',
            'tagline' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // hapus file lama jika ada
            if ($page->image) {
                Storage::disk('public')->delete($page->image);
            }
            $file = $request->file('image');
            $path = $file->store('pages', 'public');
            $data['image'] = $path;
        }

        $page->update($data);

        if ($page->image) {
            $page->image = asset('storage/' . $page->image);
        }

        return response()->json([
            'success' => true,
            'message' => 'Page berhasil diupdate',
            'data' => $page
        ]);
    }

    // Hapus halaman
    public function destroy($id)
    {
        $page = Page::find($id);

        if (!$page) {
            return response()->json(['success' => false, 'message' => 'Page tidak ditemukan'], 404);
        }

        if ($page->image) {
            Storage::disk('public')->delete($page->image);
        }

        $page->delete();

        return response()->json([
            'success' => true,
            'message' => 'Page berhasil dihapus'
        ]);
    }
}
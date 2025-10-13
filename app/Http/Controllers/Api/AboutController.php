<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => About::all()
        ], 200);
    }

    public function store(Request $request)
    {
        // Cek apakah sudah ada record
        if (About::count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'About sudah ada, tidak bisa menambah lagi'
            ], 400);
        }

        // Validasi input
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        // Simpan
        $about = About::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'About berhasil dibuat',
            'data' => $about
        ]);
    }

    public function show($id)
    {
        $about = About::find($id);

        if (!$about) {
            return response()->json(['success' => false, 'message' => 'Not found'], 404);
        }

        return response()->json(['success' => true, 'data' => $about], 200);
    }

    public function update(Request $request, $id)
    {
        $about = About::find($id);

        if (!$about) {
            return response()->json(['success' => false, 'message' => 'Not found'], 404);
        }

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($about->image) {
                Storage::disk('public')->delete($about->image);
            }
            $data['image'] = $request->file('image')->store('about', 'public');
        }

        $about->update($data);

        return response()->json([
            'success' => true,
            'message' => 'About updated successfully',
            'data' => $about
        ], 200);
    }

    public function destroy($id)
    {
        $about = About::find($id);

        if (!$about) {
            return response()->json(['success' => false, 'message' => 'Not found'], 404);
        }

        if ($about->image) {
            Storage::disk('public')->delete($about->image);
        }

        $about->delete();

        return response()->json([
            'success' => true,
            'message' => 'About deleted successfully'
        ], 200);
    }
}
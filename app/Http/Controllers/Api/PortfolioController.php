<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Portfolio::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'url' => 'nullable|string',
            'image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('portfolio', 'public');
        }

        $portfolio = Portfolio::create([
            'title' => $request->title,
            'url' => $request->url,
            'image' => $imagePath
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Portfolio created successfully',
            'data' => $portfolio
        ]);
    }

    public function show(string $id)
    {
        $portfolio = Portfolio::find($id);

        if (!$portfolio) {
            return response()->json(['success' => false, 'message' => 'Portfolio not found'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $portfolio
        ]);
    }

public function update(Request $request, string $id)
{
    $portfolio = Portfolio::find($id);

    if (!$portfolio) {
        return response()->json([
            'success' => false,
            'message' => 'Portfolio not found'
        ], 404);
    }

    // Validasi: title & url tidak wajib saat PATCH
    $request->validate([
        'title' => 'sometimes|string',
        'url' => 'sometimes|string|nullable',
        'image' => 'sometimes|file|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Update hanya field yang dikirim
    if ($request->has('title')) {
        $portfolio->title = $request->title;
    }

    if ($request->has('url')) {
        $portfolio->url = $request->url;
    }

    if ($request->hasFile('image')) {
        // Hapus file lama
        if ($portfolio->image && Storage::disk('public')->exists($portfolio->image)) {
            Storage::disk('public')->delete($portfolio->image);
        }
        $portfolio->image = $request->file('image')->store('portfolio', 'public');
    }

    $portfolio->save();

    return response()->json([
        'success' => true,
        'message' => 'Portfolio updated successfully',
        'data' => $portfolio
    ]);
}

    public function destroy(string $id)
    {
        $portfolio = Portfolio::find($id);

        if (!$portfolio) {
            return response()->json(['success' => false, 'message' => 'Portfolio not found'], 404);
        }

        if ($portfolio->image && Storage::disk('public')->exists($portfolio->image)) {
            Storage::disk('public')->delete($portfolio->image);
        }

        $portfolio->delete();

        return response()->json([
            'success' => true,
            'message' => 'Portfolio deleted successfully'
        ]);
    }
}
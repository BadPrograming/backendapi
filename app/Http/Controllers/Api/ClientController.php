<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    // Ambil semua client
    public function index()
    {
        $clients = Client::all()->map(function ($client) {
            if ($client->image) {
                $client->image = asset('storage/' . $client->image);
            }
            return $client;
        });

        return response()->json([
            'success' => true,
            'data' => $clients
        ]);
    }

    // Ambil client berdasarkan id
    public function show($id)
    {
        $client = Client::find($id);

        if (!$client) {
            return response()->json(['success' => false, 'message' => 'Client tidak ditemukan'], 404);
        }

        if ($client->image) {
            $client->image = asset('storage/' . $client->image);
        }

        return response()->json([
            'success' => true,
            'data' => $client
        ]);
    }

    // Buat client baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('clients', 'public'); // simpan di storage/app/public/clients
            $data['image'] = $path;
        }

        $client = Client::create($data);
        if ($client->image) {
            $client->image = asset('storage/' . $client->image);
        }

        return response()->json([
            'success' => true,
            'message' => 'Client berhasil dibuat',
            'data' => $client
        ]);
    }

    // Update client
    public function update(Request $request, $id)
    {
        $client = Client::find($id);

        if (!$client) {
            return response()->json(['success' => false, 'message' => 'Client tidak ditemukan'], 404);
        }

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // hapus file lama jika ada
            if ($client->image) {
                Storage::disk('public')->delete($client->image);
            }
            $file = $request->file('image');
            $path = $file->store('clients', 'public');
            $data['image'] = $path;
        }

        $client->update($data);
        if ($client->image) {
            $client->image = asset('storage/' . $client->image);
        }

        return response()->json([
            'success' => true,
            'message' => 'Client berhasil diupdate',
            'data' => $client
        ]);
    }

    // Hapus client
    public function destroy($id)
    {
        $client = Client::find($id);

        if (!$client) {
            return response()->json(['success' => false, 'message' => 'Client tidak ditemukan'], 404);
        }

        if ($client->image) {
            Storage::disk('public')->delete($client->image);
        }

        $client->delete();

        return response()->json([
            'success' => true,
            'message' => 'Client berhasil dihapus'
        ]);
    }
}
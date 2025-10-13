<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    // Get all services
    public function index()
    {
        $Service = Service::with('category')->get(); // ambil Service beserta kategori

        return response()->json([
            'success' => true,
            'data' => $Service
        ]);
    }

    // Create service
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $service = Service::create($request->only(['title', 'description']));

        return response()->json([
            'success' => true,
            'message' => 'Service created successfully',
            'data' => $service
        ]);
    }

    // Show single service
    public function show($id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json(['success' => false, 'message' => 'Service not found'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $service
        ]);
    }

    // Update service
    public function update(Request $request, $id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json(['success' => false, 'message' => 'Service not found'], 404);
        }

        $service->update($request->only(['title', 'description']));

        return response()->json([
            'success' => true,
            'message' => 'Service updated successfully',
            'data' => $service
        ]);
    }

    // Delete service
    public function destroy($id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json(['success' => false, 'message' => 'Service not found'], 404);
        }

        $service->delete();

        return response()->json([
            'success' => true,
            'message' => 'Service deleted successfully'
        ]);
    }
}

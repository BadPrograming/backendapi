<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Admin::all()
        ]);
    }

    public function show($id)
    {
        $admin = Admin::find($id);

        if (!$admin) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }

        return response()->json(['success' => true, 'data' => $admin]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:admin,email',
            'password' => 'required|string|min:6',
            'role' => 'required|string|in:super_admin,admin,user'
        ]);

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        return response()->json(['success' => true, 'message' => 'User created', 'data' => $admin]);
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::find($id);

        if (!$admin) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }

        $request->validate([
            'name' => 'sometimes|string',
            'email' => 'sometimes|email|unique:admin,email,' . $id,
            'password' => 'sometimes|string|min:6',
            'role' => 'sometimes|string|in:super_admin,admin,user',
        ]);

        if ($request->has('name')) $admin->name = $request->name;
        if ($request->has('email')) $admin->email = $request->email;
        if ($request->has('password')) $admin->password = Hash::make($request->password);
        if ($request->has('role')) $admin->role = $request->role;

        $admin->save();

        return response()->json(['success' => true, 'message' => 'User updated', 'data' => $admin]);
    }

    public function destroy($id)
    {
        $admin = Admin::find($id);

        if (!$admin) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }

        $admin->delete();

        return response()->json(['success' => true, 'message' => 'User deleted']);
    }
}

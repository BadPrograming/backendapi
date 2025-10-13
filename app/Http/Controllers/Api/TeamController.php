<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    // GET /team
    public function index()
    {
        $teams = Team::all()->map(function($team){
            $team->profile_url = $team->profile ? asset('storage/team/'.$team->profile) : null;
            return $team;
        });

        return response()->json([
            'success' => true,
            'data' => $teams
        ]);
    }

    // GET /team/{id}
    public function show($id)
    {
        $team = Team::find($id);

        if (!$team) {
            return response()->json(['success' => false, 'message' => 'Team member not found'], 404);
        }

        $team->profile_url = $team->profile ? asset('storage/team/'.$team->profile) : null;

        return response()->json(['success' => true, 'data' => $team]);
    }

    // POST /team
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'profile' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'role' => 'required|string'
        ]);

        $teamData = $request->only(['name','role']);

        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->storeAs('public/team', $filename);
            $teamData['profile'] = $filename;
        }

        $team = Team::create($teamData);
        $team->profile_url = $team->profile ? asset('storage/team/'.$team->profile) : null;

        return response()->json([
            'success' => true,
            'message' => 'Team member created',
            'data' => $team
        ]);
    }

    // PUT/PATCH /team/{id}
    public function update(Request $request, $id)
    {
        $team = Team::find($id);

        if (!$team) {
            return response()->json(['success' => false, 'message' => 'Team member not found'], 404);
        }

        $request->validate([
            'name' => 'sometimes|required|string',
            'profile' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'role' => 'sometimes|required|string'
        ]);

        $teamData = $request->only(['name','role']);

        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->storeAs('public/team', $filename);
            $teamData['profile'] = $filename;
        }

        $team->update($teamData);
        $team->profile_url = $team->profile ? asset('storage/team/'.$team->profile) : null;

        return response()->json([
            'success' => true,
            'message' => 'Team member updated',
            'data' => $team
        ]);
    }

    // DELETE /team/{id}
    public function destroy($id)
    {
        $team = Team::find($id);

        if (!$team) {
            return response()->json(['success' => false, 'message' => 'Team member not found'], 404);
        }

        $team->delete();

        return response()->json([
            'success' => true,
            'message' => 'Team member deleted'
        ]);
    }
}
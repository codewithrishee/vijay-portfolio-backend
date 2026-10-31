<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    // Public: Fetch active skills
    public function index()
    {
        return response()->json(
            Skill::where('is_active', true)
                ->orderBy('sort_order')
                ->get()
        );
    }

    // Admin: Store new skill
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:100',
            'is_active' => 'sometimes|boolean',
            'sort_order' => 'sometimes|integer|min:0',
        ]);

        $skill = Skill::create($validated);

        return response()->json([
            'message' => 'Skill created successfully',
            'data' => $skill,
        ], 201);
    }

    // Admin: Fetch one skill
    public function show(Skill $skill)
    {
        return response()->json($skill);
    }

    // Admin: Update skill
    public function update(Request $request, Skill $skill)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'category' => 'sometimes|required|string|max:100',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:100',
            'is_active' => 'sometimes|boolean',
            'sort_order' => 'sometimes|integer|min:0',
        ]);

        $skill->update($validated);

        return response()->json([
            'message' => 'Skill updated successfully',
            'data' => $skill->fresh(),
        ]);
    }

    // Admin: Delete skill
    public function destroy(Skill $skill)
    {
        $skill->delete();

        return response()->json([
            'message' => 'Skill deleted successfully',
        ]);
    }
}
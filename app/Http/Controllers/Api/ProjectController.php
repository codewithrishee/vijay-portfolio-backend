<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::where('is_visible', true)
            ->orderBy('sort_order')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $projects,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:projects,slug',
            'description' => 'required|string',
            'case_study' => 'nullable|string',
            'features' => 'nullable|array',
            'features.*' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'live_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
            'technologies' => 'nullable|string|max:255',
            'is_featured' => 'sometimes|boolean',
            'is_visible' => 'sometimes|boolean',
            'sort_order' => 'sometimes|integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            $upload = cloudinary()->uploadApi()->upload(
                $request->file('image')->getRealPath(),
                ['folder' => 'portfolio/projects']
            );

            $validated['image'] = $upload['secure_url'];
        }

        $project = Project::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Project created successfully.',
            'data' => $project,
        ], 201);
    }

    public function show(string $id)
    {
        $project = Project::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $project,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $project = Project::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|required|string|max:255|unique:projects,slug,' . $id,
            'description' => 'sometimes|required|string',
            'case_study' => 'sometimes|nullable|string',
            'features' => 'sometimes|nullable|array',
            'features.*' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'live_url' => 'sometimes|nullable|url|max:255',
            'github_url' => 'sometimes|nullable|url|max:255',
            'technologies' => 'sometimes|nullable|string|max:255',
            'is_featured' => 'sometimes|boolean',
            'is_visible' => 'sometimes|boolean',
            'sort_order' => 'sometimes|integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            $upload = cloudinary()->uploadApi()->upload(
                $request->file('image')->getRealPath(),
                ['folder' => 'portfolio/projects']
            );

            $validated['image'] = $upload['secure_url'];
        }

        $project->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Project updated successfully.',
            'data' => $project->fresh(),
        ]);
    }

    public function destroy(string $id)
    {
        $project = Project::findOrFail($id);

        $project->delete();

        return response()->json([
            'success' => true,
            'message' => 'Project deleted successfully.',
        ]);
    }
}

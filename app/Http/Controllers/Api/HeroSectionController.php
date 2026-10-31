<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;
use Illuminate\Http\Request;

class HeroSectionController extends Controller
{
    public function index()
    {
        return response()->json(
            HeroSection::where('is_active', true)->first()
        );
    }

    public function adminIndex()
    {
        return response()->json(
            HeroSection::orderBy('id')->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'eyebrow' => 'required|string|max:255',
            'role_prefix' => 'required|string|max:255',
            'role_suffix' => 'required|string|max:255',
            'technologies' => 'required|string|max:255',
            'heading_line_1' => 'required|string|max:255',
            'heading_line_2' => 'required|string|max:255',
            'roles' => 'required|array|min:1',
            'roles.*' => 'required|string|max:100',
            'description' => 'required|string',
            'primary_button_text' => 'required|string|max:100',
            'primary_button_link' => 'required|string|max:255',
            'secondary_button_text' => 'required|string|max:100',
            'secondary_button_link' => 'required|string|max:255',
            'github_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'experience_value' => 'required|string|max:50',
            'experience_label' => 'required|string|max:100',
            'technology_count' => 'required|string|max:50',
            'technology_label' => 'required|string|max:100',
            'project_count' => 'required|string|max:50',
            'project_label' => 'required|string|max:100',
            'availability_text' => 'required|string|max:100',
            'availability_label' => 'required|string|max:100',
            'is_active' => 'sometimes|boolean',
        ]);

        return response()->json(HeroSection::create($data), 201);
    }

    public function show(HeroSection $heroSection)
    {
        return response()->json($heroSection);
    }

    public function update(Request $request, HeroSection $heroSection)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'eyebrow' => 'sometimes|required|string|max:255',
            'role_prefix' => 'sometimes|required|string|max:255',
            'role_suffix' => 'sometimes|required|string|max:255',
            'technologies' => 'sometimes|required|string|max:255',
            'heading_line_1' => 'sometimes|required|string|max:255',
            'heading_line_2' => 'sometimes|required|string|max:255',
            'roles' => 'sometimes|required|array|min:1',
            'roles.*' => 'required|string|max:100',
            'description' => 'sometimes|required|string',
            'primary_button_text' => 'sometimes|required|string|max:100',
            'primary_button_link' => 'sometimes|required|string|max:255',
            'secondary_button_text' => 'sometimes|required|string|max:100',
            'secondary_button_link' => 'sometimes|required|string|max:255',
            'github_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'experience_value' => 'sometimes|required|string|max:50',
            'experience_label' => 'sometimes|required|string|max:100',
            'technology_count' => 'sometimes|required|string|max:50',
            'technology_label' => 'sometimes|required|string|max:100',
            'project_count' => 'sometimes|required|string|max:50',
            'project_label' => 'sometimes|required|string|max:100',
            'availability_text' => 'sometimes|required|string|max:100',
            'availability_label' => 'sometimes|required|string|max:100',
            'is_active' => 'sometimes|boolean',
        ]);

        $heroSection->update($data);

        return response()->json($heroSection);
    }

    public function destroy(HeroSection $heroSection)
    {
        $heroSection->delete();

        return response()->json([
            'message' => 'Hero section deleted successfully.',
        ]);
    }
}
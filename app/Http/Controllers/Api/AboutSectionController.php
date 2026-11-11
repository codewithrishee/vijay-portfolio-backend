<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AboutSection;
use Illuminate\Http\Request;

class AboutSectionController extends Controller
{
    public function index()
    {
        return response()->json(
            AboutSection::where('is_active', true)->first()
        );
    }

    public function adminIndex()
    {
        return response()->json(
            AboutSection::orderBy('id')->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'education' => 'required|string|max:255',
            'education_description' => 'required|string|max:255',
            'profile_technologies' => 'required|string|max:255',
            'section_number' => 'required|string|max:20',
            'heading' => 'required|string|max:255',
            'paragraph_1' => 'required|string',
            'paragraph_2' => 'required|string',
            'paragraph_3' => 'nullable|string',
            'looking_for' => 'nullable|string|max:255',
            'availability' => 'nullable|string|max:255',
            'technologies' => 'nullable|string|max:255',
            'is_active' => 'sometimes|boolean',
        ]);

        if ($request->hasFile('image')) {
            $upload = cloudinary()->uploadApi()->upload(
                $request->file('image')->getRealPath(),
                ['folder' => 'portfolio/about']
            );

            $data['image'] = $upload['secure_url'];
        }

        $about = AboutSection::create($data);

        return response()->json($about, 201);
    }

    public function show(AboutSection $aboutSection)
    {
        return response()->json($aboutSection);
    }

    public function update(Request $request, AboutSection $aboutSection)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'location' => 'sometimes|required|string|max:255',
            'image' => 'sometimes|nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'education' => 'sometimes|required|string|max:255',
            'education_description' => 'sometimes|required|string|max:255',
            'profile_technologies' => 'sometimes|required|string|max:255',
            'section_number' => 'sometimes|required|string|max:20',
            'heading' => 'sometimes|required|string|max:255',
            'paragraph_1' => 'sometimes|required|string',
            'paragraph_2' => 'sometimes|required|string',
            'paragraph_3' => 'nullable|string',
            'looking_for' => 'nullable|string|max:255',
            'availability' => 'nullable|string|max:255',
            'technologies' => 'nullable|string|max:255',
            'is_active' => 'sometimes|boolean',
        ]);

        if ($request->hasFile('image')) {
            $upload = cloudinary()->uploadApi()->upload(
                $request->file('image')->getRealPath(),
                ['folder' => 'portfolio/about']
            );

            $data['image'] = $upload['secure_url'];
        }

        $aboutSection->update($data);

        return response()->json($aboutSection->fresh());
    }

    public function destroy(AboutSection $aboutSection)
    {
        $aboutSection->delete();

        return response()->json([
            'message' => 'About section deleted successfully.',
        ]);
    }
}

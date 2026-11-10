<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ResumeController extends Controller
{


// Get current resume details for admin
public function show()
{
    $resume = Resume::latest()->first();

    return response()->json([
        'success' => true,
        'data' => $resume,
    ]);
}


    // Download latest resume
    public function download()
    {
        $resume = Resume::latest()->first();

        if (!$resume || !Storage::disk('public')->exists($resume->file_path)) {
            return response()->json([
                'success' => false,
                'message' => 'Resume not found.',
            ], 404);
        }

       return Storage::disk('public')->response(
    $resume->file_path,
    $resume->original_name,
    [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="' . addslashes($resume->original_name) . '"',
    ]
);
    }

    // Upload or replace resume
    public function upload(Request $request)
    {
        $request->validate([
            'resume' => 'required|file|mimes:pdf|max:5120',
        ]);

        $oldResume = Resume::latest()->first();

        $file = $request->file('resume');

        $path = $file->store('resumes', 'public');

        if (!$path) {
            return response()->json([
                'success' => false,
                'message' => 'Resume upload failed.',
            ], 500);
        }

        try {
            $resume = $oldResume ?? new Resume();

            $resume->file_path = $path;
            $resume->original_name = $file->getClientOriginalName();
            $resume->save();

            // Delete previous PDF after successful database save
            if ($oldResume && $oldResume->file_path !== $path) {
                Storage::disk('public')->delete($oldResume->file_path);
            }

            return response()->json([
                'success' => true,
                'message' => 'Resume uploaded successfully.',
                'data' => $resume,
            ]);
        } catch (\Throwable $e) {
            Storage::disk('public')->delete($path);

            throw $e;
        }
    }

    // Delete existing resume
    public function destroy()
    {
        $resume = Resume::latest()->first();

        if (!$resume) {
            return response()->json([
                'success' => false,
                'message' => 'No resume found.',
            ], 404);
        }

        Storage::disk('public')->delete($resume->file_path);

        $resume->delete();

        return response()->json([
            'success' => true,
            'message' => 'Resume deleted successfully.',
        ]);
    }
}

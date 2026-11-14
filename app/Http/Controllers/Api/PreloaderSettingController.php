<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PreloaderSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PreloaderSettingController extends Controller
{
    // Public settings
    public function index()
    {
        $settings = PreloaderSetting::first();

        if (!$settings) {
            return response()->json([
                'is_enabled' => false,
            ]);
        }

        return response()->json($settings);
    }

    // Admin settings
    public function adminIndex()
    {
        return response()->json(
            PreloaderSetting::first()
        );
    }

    // Create or update settings
    public function update(Request $request)
    {
        // Convert FormData string values into actual booleans
        $request->merge([
            'is_enabled' => filter_var(
                $request->input('is_enabled'),
                FILTER_VALIDATE_BOOLEAN,
                FILTER_NULL_ON_FAILURE
            ),

            'show_logo' => filter_var(
                $request->input('show_logo'),
                FILTER_VALIDATE_BOOLEAN,
                FILTER_NULL_ON_FAILURE
            ),
        ]);

        // Validate incoming data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',

            'is_enabled' => 'required|boolean',
            'duration' => 'required|integer|min:500|max:10000',

            'background_color' => [
                'required',
                'regex:/^#[0-9A-Fa-f]{6}$/'
            ],

            'text_color' => [
                'required',
                'regex:/^#[0-9A-Fa-f]{6}$/'
            ],

            'progress_color' => [
                'required',
                'regex:/^#[0-9A-Fa-f]{6}$/'
            ],

            'percentage_color' => [
                'required',
                'regex:/^#[0-9A-Fa-f]{6}$/'
            ],

            'show_logo' => 'required|boolean',
            'logo_size' => 'required|integer|min:20|max:200',

            'animation_style' => 'required|in:progress,fade,spinner',
            'animation_speed' => 'required|integer|min:100|max:10000',

            'logo' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
        ]);

        // Get existing settings
        $settings = PreloaderSetting::first();

        // Handle logo upload
        if ($request->hasFile('logo')) {

            // Delete previous logo
            if ($settings?->logo) {
                Storage::disk('public')->delete($settings->logo);
            }

            // Store new logo
            $validated['logo'] = $request->file('logo')
                ->store('preloader', 'public');
        } else {
            unset($validated['logo']);
        }

        // Create or update without using an artificial ID
        if ($settings) {
            $settings->update($validated);
        } else {
            $settings = PreloaderSetting::create($validated);
        }

        return response()->json([
            'message' => 'Preloader settings updated successfully',
            'settings' => $settings->fresh(),
        ]);
    }
}

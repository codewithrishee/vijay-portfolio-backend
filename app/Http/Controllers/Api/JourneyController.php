<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Journey;
use Illuminate\Http\Request;

class JourneyController extends Controller
{
    public function index()
    {
        return Journey::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'year' => 'required|string|max:20',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'required|string',
            'is_active' => 'sometimes|boolean',
            'sort_order' => 'sometimes|integer|min:0',
        ]);

        return response()->json(Journey::create($data), 201);
    }

    public function show(string $id)
    {
        return Journey::findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        $journey = Journey::findOrFail($id);

        $data = $request->validate([
            'year' => 'sometimes|required|string|max:20',
            'title' => 'sometimes|required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'sometimes|required|string',
            'is_active' => 'sometimes|boolean',
            'sort_order' => 'sometimes|integer|min:0',
        ]);

        $journey->update($data);

        return response()->json($journey);
    }

    public function destroy(string $id)
    {
        Journey::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Journey deleted successfully',
        ]);
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MarqueeItem;
use Illuminate\Http\Request;

class MarqueeItemController extends Controller
{

public function adminIndex()
{
    return response()->json(
        MarqueeItem::orderBy('sort_order')
            ->orderBy('id')
            ->get()
    );
}

    public function index()
    {
        return response()->json(
            MarqueeItem::where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get()
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'technology' => 'required|string|max:100',
            'is_active' => 'sometimes|boolean',
            'sort_order' => 'sometimes|integer|min:0',
        ]);

        $item = MarqueeItem::create($validated);

        return response()->json($item, 201);
    }

    public function show(MarqueeItem $marqueeItem)
    {
        return response()->json($marqueeItem);
    }

    public function update(Request $request, MarqueeItem $marqueeItem)
    {
        $validated = $request->validate([
            'technology' => 'sometimes|required|string|max:100',
            'is_active' => 'sometimes|boolean',
            'sort_order' => 'sometimes|integer|min:0',
        ]);

        $marqueeItem->update($validated);

        return response()->json($marqueeItem);
    }

    public function destroy(MarqueeItem $marqueeItem)
    {
        $marqueeItem->delete();

        return response()->json([
            'message' => 'Technology deleted successfully.',
        ]);
    }
}
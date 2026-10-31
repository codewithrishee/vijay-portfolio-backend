<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;


class ContactMessageController extends Controller
{

public function index()
{
    $messages = ContactMessage::latest()->paginate(10);

    return response()->json([
        'success' => true,
        'data' => $messages,
    ]);
}

public function updateReadStatus(Request $request, string $id)
{
    $validated = $request->validate([
        'is_read' => 'required|boolean',
    ]);

    $contactMessage = ContactMessage::findOrFail($id);

    $contactMessage->update([
        'is_read' => $validated['is_read'],
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Message status updated successfully.',
        'data' => $contactMessage->fresh(),
    ]);
}

public function destroy(string $id)
{
    $contactMessage = ContactMessage::findOrFail($id);
    $contactMessage->delete();

    return response()->json([
        'success' => true,
        'message' => 'Contact message deleted successfully.',
    ]);
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        $contactMessage = ContactMessage::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Your message has been sent successfully!',
            'data' => [
                'id' => $contactMessage->id,
            ],
        ], 201);
    }
}
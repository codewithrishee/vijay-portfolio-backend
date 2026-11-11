<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactMessageController extends Controller
{
    // All contact messages
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(10);

        return response()->json([
            'success' => true,
            'unread_count' => ContactMessage::where('is_read', false)->count(),
            'data' => $messages,
        ]);
    }

    // Bell icon notifications
    public function notifications()
{
    $notifications = ContactMessage::latest()
        ->take(5)
        ->get([
            'id',
            'name',
            'subject',
            'created_at',
            'is_read'
        ]);

    return response()->json([
        'success' => true,
        'unread_count' => ContactMessage::where('is_read', false)->count(),
        'data' => $notifications,
    ]);
}

    // Mark message as read/unread
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

    // Delete message
    public function destroy(string $id)
    {
        $contactMessage = ContactMessage::findOrFail($id);
        $contactMessage->delete();

        return response()->json([
            'success' => true,
            'message' => 'Contact message deleted successfully.',
        ]);
    }


    
    // Store contact form message
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'subject' => 'nullable|string|max:255',
        'message' => 'required|string|max:5000',
    ]);

    // Save message in database
    $contactMessage = ContactMessage::create($validated);

    $emailSent = false;

    try {
        Mail::raw(
            "New Portfolio Contact Message\n\n" .
            "Name: {$validated['name']}\n" .
            "Email: {$validated['email']}\n" .
            "Subject: " . ($validated['subject'] ?? 'No subject') . "\n\n" .
            "Message:\n{$validated['message']}",
            function ($mail) use ($validated) {
                $mail->to(config('mail.from.address'))
                    ->subject('New Portfolio Contact Message')
                    ->replyTo($validated['email'], $validated['name']);
            }
        );

        $emailSent = true;

    } catch (\Throwable $e) {
        Log::error('Contact email failed: ' . $e->getMessage());
    }

    return response()->json([
        'success' => true,
        'message' => 'Your message has been received successfully!',
        'email_sent' => $emailSent,
        'data' => [
            'id' => $contactMessage->id,
        ],
    ], 201);
}
}
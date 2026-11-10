<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ContactMessage;
use App\Models\Skill;

class DashboardController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,

            'stats' => [
                // Projects
                'total_projects' => Project::count(),
                'featured_projects' => Project::where('is_featured', true)->count(),
                'visible_projects' => Project::where('is_visible', true)->count(),
                'hidden_projects' => Project::where('is_visible', false)->count(),

                // Skills
                'total_skills' => Skill::count(),
                'active_skills' => Skill::where('is_active', true)->count(),
                'hidden_skills' => Skill::where('is_active', false)->count(),

                // Messages
                'total_messages' => ContactMessage::count(),
                'unread_messages' => ContactMessage::where('is_read', false)->count(),
            ],

            'recent_projects' => Project::latest()
                ->take(5)
                ->get(),

            'recent_messages' => ContactMessage::latest()
                ->take(5)
                ->get(),

            'recent_skills' => Skill::latest()
                ->take(5)
                ->get(),
        ]);
    }
}

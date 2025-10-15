<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $notifications = $user?->notifications()->latest()->paginate(15);
        return view('notifications.index', compact('notifications'));
    }

    public function fetch()
    {
        $user = Auth::user();
        $unreadCount = $user?->unreadNotifications()->count() ?? 0;
        $items = $user?->notifications()->latest()->take(5)->get()->map(function ($n) {
            return [
                'id' => $n->id,
                'read_at' => $n->read_at,
                'title' => $n->data['title'] ?? 'Notification',
                'message' => $n->data['message'] ?? '',
                'icon' => $n->data['icon'] ?? 'info-circle',
                'url' => $n->data['url'] ?? null,
            ];
        }) ?? collect();

        return response()->json([
            'unread' => $unreadCount,
            'items' => $items,
        ]);
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()?->notifications()->where('id', $id)->firstOrFail();
        if (!$notification->read_at) {
            $notification->markAsRead();
        }
        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        $user = Auth::user();
        $user?->unreadNotifications->markAsRead();
        return response()->json(['success' => true]);
    }
}

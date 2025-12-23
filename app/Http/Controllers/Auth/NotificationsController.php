<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function index()
    {
        $data = Auth::user()->notifications()->limit(15)->get();

        return view('pages.auth.notifications.index', [
            'data' => $data
        ]);
    }

    /**
     * get user notification count
     * 
     * @return Illuminate\Http\JsonResponse
     */
    public function getUserNotificationCount(): JsonResponse
    {
        $notification_count = Auth::user()->unreadNotifications->count();

        return response()->json([
            'data' => $notification_count
        ]);
    }

    /**
     * set read notif
     */
    public function setRead($id)
    {
        $row = Auth::user()->notifications()->where('id', urldecode($id))->first();

        $update = $row->update([
            'read_at' => now()
        ]);

        if (!$update) return response()->json([], 500);

        return response()->json([]);
    }
}

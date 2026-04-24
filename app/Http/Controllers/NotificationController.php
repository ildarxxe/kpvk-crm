<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Support;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function viewNotifications(): Factory|View
    {
        return view('notifications')->with("notifications", auth()->user()->notifications);
    }

    public function respond(Request $request, Support $support): RedirectResponse
    {
        $data = $request->validate([
            "response" => "required|string",
        ]);

        Notification::query()->create([
            "support_id" => $support->id,
            "user_id" => $support->user_id,
            "response" => $data['response'],
        ]);

        return redirect()->back()->with("success", "Ответ успешно отправлен!");
    }

    public function markAllAsRead(): RedirectResponse {
        Notification::query()->where("user_id", auth()->user()->id)->whereNull("read_at")->update([
            "read_at" => now(),
        ]);
        return redirect()->route("notifications");
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function rate(Request $request, Task $task): RedirectResponse
    {
        if (auth()->user()->id !== $task->teacher_id) {
            abort(403);
        }

        $validated = $request->validate([
            "rate" => "required|numeric|min:1|max:5",
            "comment" => "required|string",
        ]);

        Review::query()->create([
            "task_id" => $task->id,
            "rate" => $validated["rate"],
            "comment" => $validated["comment"],
        ]);

        return redirect()->back()->with("success", "Задача успешно оценена");
    }
}

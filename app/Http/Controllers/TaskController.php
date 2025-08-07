<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    public function store(Request $request, $group_id)
    {

        $validated = $request->validate([
            "titulo" => "required|string",
            "descripcion" => "nullable|string|max:1000",
        ]);

        $model = Group::findOrFail($group_id);

        $task = $model->tasks()->create($validated);
        return response()->json(["message" => $task], 201);
    }

    public function update(Request $request, $group_id, $task_id)
    {
        $model = Task::findOrFail($task_id);


        $validated = $request->validate([
            "titulo" => "required|string",
            "descripcion" => "nullable|string|max:1000",
            "finalizado" => "sometimes|boolean",
            "finished_at" => "nullable|date"
        ]);

        $model->update($validated);
    }
}

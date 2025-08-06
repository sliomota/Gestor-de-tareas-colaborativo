<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    public function store(Request $request)
    {

        $validated = $request->validate([
            "titulo" => "required|string",
            "descripcion" => "nullable|string|max:1000",
        ]);

        $task = Auth::user()->tasks()->create($validated);
        return response()->json(["message" => $task], 201);
    }

    public function update(Request $request, $id){
        $model = Task::findOrFail($id);

        $validated = $request->validate([
            "titulo" => "required|string",
            "descripcion" => "nullable|string|max:1000",
            "finalizado"=>"sometimes|boolean",
            "finished_at"=>"nullable|date"
        ]);
        
        $model->update($validated);

    }
}

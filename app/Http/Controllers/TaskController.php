<?php

namespace App\Http\Controllers;

use App\Models\Proyect;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $model = Proyect::findOrFail($id);
        $tasks = $model->tasks;
        return response()->json(["model" => $tasks], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        $model = Proyect::findOrFail($id);
        $validated = $request->validate(["title" => "required|string|max:35", "description" => "required|string"]);
        $task = $model->tasks()->create($validated);

        return response()->json(["model" => $task], 201);
    }

    /**
     * Display the specified resource.
     */
    /**
     * @OA\Get(
     *     path="/api/tasks/{id}",
     *     summary="Obtener tareas de un proyecto",
     *     description="Devuelve todas las tareas de un proyecto que pertenece al usuario autenticado",
     *     operationId="getProjectTasks",
     *     tags={"Tasks"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del proyecto",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de tareas",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Task")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Proyecto no encontrado"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autenticado"
     *     )
     * )
     */

    public function show(string $id)
    {
        $proyect = Auth::user()->proyects()->findOrFail($id);

        $model = $proyect->tasks;
        if (
            $model->count()
        ) {
            return response()->json(["model" => $model], 200);
        } else {
            return response()->json(["message" => "nada que devolver"], 204);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task = Task::findOrFail($id);
        $validated = $request->validate(["title" => 'sometimes|string|max:35', 'description' => 'sometimes|string|']);
        $task->update($validated);
        return response()->json(["model" => $task], 200);
    }

    /**
     * Update the specified resource's status in storage.
     */
    public function updateStatus(string $id)
    {
        $task = Task::findOrFail($id);
        $task->status = $task["status"] ? 0 : 1;
        $task->save();

        return response()->json(["model" => $task], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Task::destroy($id);

        return response()->json(["message" => "eliminado con exito"], 200);
    }
}

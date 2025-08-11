<?php

namespace App\Http\Controllers;

use App\Models\Proyect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Schema(
 *     schema="Proyect",
 *     type="object",
 *     title="Proyect",
 *     required={"name"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Sistema de gestión"),
 *     @OA\Property(property="description", type="string", nullable=true, example="Proyecto para administrar tareas internas"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-08-11T09:00:00.000000Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-08-11T09:00:00.000000Z"),
 *     @OA\Property(property="deleted_at", type="string", format="date-time", nullable=true, example=null)
 * )
 */
class ProyectController extends Controller
{
    /**
     * @OA\Get(
     *     path="/proyects",
     *     summary="Listar proyectos",
     *     tags={"Proyectos"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de proyectos",
     *         @OA\JsonContent(
     *             @OA\Property(property="model", type="array",
     *                 @OA\Items(ref="#/components/schemas/Proyect")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=204, description="No hay proyectos")
     * )
     */
    public function index()
    {
        $model = Auth::user()->proyects()->get();
        if (!$model->count() > 0) {
            return response()->json(["message" => "No hay proyectos"], 204);
        }

        return response()->json(["model" => $model], 200);
    }

    /**
     * @OA\Post(
     *     path="/proyects",
     *     summary="Crear un nuevo proyecto",
     *     tags={"Proyectos"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Sistema de inventario"),
     *             @OA\Property(property="description", type="string", nullable=true, example="Proyecto para control de stock")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Proyecto creado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Proyecto creado exitosamente"),
     *             @OA\Property(property="model", ref="#/components/schemas/Proyect")
     *         )
     *     ),
     *     @OA\Response(response=422, description="Datos inválidos")
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string|max:35",
            "description" => "nullable|string"
        ]);

        $model = Proyect::create($validated);
        Auth::user()->proyects()->attach($model);

        return response()->json(["message" => "Proyecto creado exitosamente", "model" => $model], 201);
    }

    /**
     * @OA\Get(
     *     path="/proyects/{id}",
     *     summary="Obtener un proyecto",
     *     tags={"Proyectos"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del proyecto",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Proyecto encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="model", ref="#/components/schemas/Proyect")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Proyecto no encontrado")
     * )
     */
    public function show(string $id)
    {
        $model = Proyect::findOrFail($id);

        return response()->json(["model" => $model], 200);
    }

    /**
     * @OA\Put(
     *     path="/proyects/{id}",
     *     summary="Actualizar un proyecto",
     *     tags={"Proyectos"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del proyecto",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Sistema de ventas"),
     *             @OA\Property(property="description", type="string", nullable=true, example="Proyecto para registrar ventas")
     *         )
     *     ),
     *     @OA\Response(
     *         response=202,
     *         description="Proyecto actualizado",
     *         @OA\JsonContent(
     *             @OA\Property(property="model", ref="#/components/schemas/Proyect")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Proyecto no encontrado")
     * )
     */
    public function update(Request $request, string $id)
    {
        $model = Proyect::findOrFail($id);
        $validated = $request->validate([
            "name" => "required|string|max:35",
            "description" => "nullable|string"
        ]);

        $model->update($validated);

        return response()->json(["model" => $model], 202);
    }

    /**
     * @OA\Delete(
     *     path="/proyects/{id}",
     *     summary="Eliminar un proyecto",
     *     tags={"Proyectos"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del proyecto",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(response=204, description="Proyecto eliminado correctamente"),
     *     @OA\Response(response=404, description="Proyecto no encontrado")
     * )
     */
    public function destroy(string $id)
    {
        $model = Proyect::findOrFail($id);
        $model->delete();

        return response()->json(["message" => "Proyecto eliminado correctamente"], 204);
    }
}

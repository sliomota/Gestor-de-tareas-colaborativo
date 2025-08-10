<?php

namespace App\Http\Controllers;

use App\Models\Proyect;
use Illuminate\Http\Request;

class ProyectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/api/proyects",
     *     tags={"Proyects"},
     *     summary="Obtener lista de proyectos",
     *     description="Devuelve una lista de todos los proyectos",
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="array",
 @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", format="int64", description="ID del proyecto"),
     *                 @OA\Property(property="nombre", type="string", description="Nombre del proyecto"),
     *                 @OA\Property(property="description", type="string", description="Descripción del proyecto"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", description="Fecha de creación"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", description="Fecha de actualización")
     *             )
     *         )
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="No hay proyectos"
     *     )
     * )
     */
    public function index()
    {
        $model = Proyect::all();

        if (!$model->count() > 0) {
            return response()->json(["message" => "No hay proyectos"], 204);
        }

        return response()->json(["model" => $model], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/api/proyects",
     *     tags={"Proyects"},
     *     summary="Crear un nuevo proyecto",
     *     description="Crea un nuevo proyecto",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre"},
     *             @OA\Property(property="nombre", type="string", format="string", example="Nombre del Proyecto"),
     *             @OA\Property(property="description", type="string", format="string", example="Descripción del Proyecto")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Proyecto creado exitosamente",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validación fallida"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "nombre" => "required|string|max:35",
            "description" => "nullable|string"
        ]);

        $model = Proyect::create($validated);

        return response()->json(["message" => "Proyecto creado exitosamente", "model" => $model], 201);
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *     path="/api/proyects/{id}",
     *     tags={"Proyects"},
     *     summary="Obtener un proyecto por ID",
     *     description="Devuelve un proyecto específico por su ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Proyecto no encontrado"
     *     )
     * )
     */
    public function show(string $id)
    {
        $model = Proyect::findOrFail($id);

        return response()->json(["model" => $model], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/api/proyects/{id}",
     *     tags={"Proyects"},
     *     summary="Actualizar un proyecto por ID",
     *     description="Actualiza un proyecto específico por su ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre"},
     *             @OA\Property(property="nombre", type="string", format="string", example="Nombre del Proyecto"),
     *             @OA\Property(property="description", type="string", format="string", example="Descripción del Proyecto")
     *         )
     *     ),
     *     @OA\Response(
     *         response=202,
     *         description="Proyecto actualizado exitosamente",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Proyecto no encontrado"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validación fallida"
     *     )
     * )
     */
    public function update(Request $request, string $id)
    {
        $model = Proyect::findOrFail($id);
        $validated = $request->validate([
            "nombre" => "required|string|max:35",
            "description" => "nullable|string"
        ]);

        $model->update($validated);

        return response()->json(["model" => $model], 202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/api/proyects/{id}",
     *     tags={"Proyects"},
     *     summary="Eliminar un proyecto por ID",
     *     description="Elimina un proyecto específico por su ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Proyecto eliminado correctamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Proyecto no encontrado"
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $model = Proyect::findOrFail($id);
        $model->delete();

        return response()->json(["message" => "Proyecto eliminado correctamente"], 204);
    }
}

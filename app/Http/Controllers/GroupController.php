<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => 'sometimes|string|max:100'
        ]);

        $group = Group::create($validated);
        $group->users()->attatch(Auth::id());

        return response()->json(["message" => "creado Correctamente", "group_id" => $group->id], 201);
    }

    public function update(Request $request, Group $group)
    {
        $validated = $request->validate(["name" => "required|string|max:100"]);
        $model = $group->update($validated);
        return response()->json(["message" => "Grupo Actualizado", "name" => $model->name], 200);
    }

    public function addUser(Group $group)
    {
        $group->user->attatch(Auth::id());
        return response()->json(['message' => 'Usuario añadido con exito'], 200);
    }
}

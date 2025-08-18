<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Proyect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class InvitationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate(['proyect_id' => 'required|string']);
        $user = Auth::user();
        $proyect = $user->proyects()->findOrFail($validated['proyect_id']);
        $invitation = [
            'token' => Str::uuid(),
            'expires_at' => now()->addDays(3),
        ];
        $model = $proyect->invitations()->create($invitation);
        $url = url("/invitation/{$model->token}");
        return response()->json(["url" => $url], 200);
    }

    public function show($token)
    {
        $invitation = Invitation::where('token', $token)->whereNull('used_at')->where('expirest_at', '>', now())->first();

        if (!$invitation) {
            return response()->json(["message" => "Invitacion expirada o invalida"], 404);
        }

        return response()->json([$invitation], 200);
    }

    public function accept(Request $request)
    {
        $validated = $request->validate(['token' => 'required|string']);

        $invitation = Invitation::where('token', $validated["token"])->whereNull('used_at')->where('expires_at', '>', now())->firstOrFail();

        $user = $request->user();

        $user->proyects()->attach($invitation->proyect_id);

        $invitation->update(['used_at' => now()]);

        return response()->json(["message" => "usuario autenticado exitosamente"], 200);
    }
}

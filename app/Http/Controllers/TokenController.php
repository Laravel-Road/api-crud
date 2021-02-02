<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class TokenController extends Controller
{
    public function store(Request $request)
    {
        $token = $request->user()->createToken(
            $request->has('device') ? $request->get('device') : 'access_token',
            $request->has('abilities') ? $request->get('abilities') : ['*'],
        );

        return response()->json(['token' => $token->plainTextToken]);
    }

    public function destroy(PersonalAccessToken $token)
    {
        request()->user()->tokens()->where('id', $token->id)->delete();

        return response()->json(null, 204);
    }
}

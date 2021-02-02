<?php

namespace App\Http\Controllers;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class TokenController extends Controller
{
    /**
     * @OA\Post(
     *     tags={"/tokens"},
     *     summary="Store a newly created resource in storage.",
     *     description="store a new token on database",
     *     path="/tokens",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="device", type="string"),
     *             @OA\Property(property="abilities", type="string"),
     *       )
     *     ),
     *     @OA\Response(
     *         response="201", description="New tokens created"
     *     )
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $token = $request->user()->createToken(
            $request->has('device') ? $request->get('device') : 'access_token',
            $request->has('abilities') ? $request->get('abilities') : ['*'],
        );

        return response()->json(['token' => $token->plainTextToken]);
    }

    /**
     * @OA\Delete(
     *     tags={"/tokens"},
     *     summary="Remove the specified resource from storage.",
     *     description="remove a token on database",
     *     path="/tokens/{token}",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         description="Token id",
     *         in="path",
     *         name="token",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response="204", description="Token deleted"
     *     )
     * )
     *
     * @param PersonalAccessToken $token
     * @return JsonResponse
     */
    public function destroy(PersonalAccessToken $token)
    {
        request()->user()->tokens()->where('id', $token->id)->delete();

        return response()->json(null, 204);
    }
}

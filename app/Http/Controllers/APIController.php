<?php

namespace App\Http\Controllers;

use App\Models\alatabsensiM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class APIController extends Controller
{
    public function login(Request $request)
    {

        $request->validate([
            'kodealat' => 'required|string',
            'pascode' => 'required|string',
        ]);


        // Cari data alat berdasarkan kodealat
        $alat = alatabsensiM::where('kodealat', $request->kodealat)->first();

        if (!$alat) {
            return response()->json(['message' => 'error'], 404);
        }

        // Cek apakah pascode cocok dengan yang ada di database
        if (!Hash::check($request->pascode, $alat->pascode)) {
            return response()->json(['message' => 'error'], 401);
        }

        // Jika validasi berhasil, generate JWT
        try {
            $token = JWTAuth::fromUser($alat);
        } catch (JWTException $e) {
            return response()->json(['message' => 'error'], 500);
        }

        return response()->json([
            'message' => 'success',
            'token' => $token,
        ]);
    }


    public function me(Request $request)
    {
        return response()->json(Auth::user()->idinstansi);
    }

}

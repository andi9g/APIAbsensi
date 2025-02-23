<?php

namespace App\Http\Controllers;

use App\Models\absenM;
use App\Models\alatabsensiM;
use App\Models\bacakartuM;
use App\Models\instansiM;
use App\Models\kartupelajarM;
use App\Models\kelolawaktuM;
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



    public function absensi(Request $request)
    {
        try{
            $idinstansi = Auth::user()->idinstansi;
            $fungsi = Auth::user()->fungsi;
            $instansi = instansiM::where("idinstansi", $idinstansi)->count();

            // return response()->json(Auth::user());

            $tanggal = date("Y-m-d");
            $jammasuk = kelolawaktuM::first()->jammasuk??"08:00";
            $jamkeluar = kelolawaktuM::first()->jamkeluar??"12:00";
            $hari = date("Y-m-d")." ".$jamkeluar;

            $jsonData = $request->getContent();
            $data = json_decode($jsonData);

            if($instansi === 1 && $fungsi == "absensi") {
                foreach ($data as $value) {

                    $jamabsen = $value->waktu;

                    //CEK KARTU ======================================================
                    $cekkartu = kartupelajarM::with("siswa")
                    ->where("uuid", $value->uuid)
                    ->whereHas("siswa", function ($query) use ($idinstansi) {
                        $query->where("idinstansi", $idinstansi);
                    })->first();


                    //cek absensi hari ini ===========================================
                    $absen = absenM::with("siswa")
                    ->where("nisn", $cekkartu->siswa->nisn)
                    ->whereHas("siswa", function ($query) use ($idinstansi) {
                        $query->from("siswa.siswa")
                        ->where("idinstansi", $idinstansi);
                    })->where("tanggal", $tanggal);


                    // PROSES ========================================================
                    if($value->waktu < strtotime($hari)) {
                        if($absen->count() === 0) {
                            $sendData["nisn"] = $cekkartu->siswa->nisn;
                            $sendData["tanggal"] = $tanggal;
                            $sendData["jammasuk"] = date("H:i", $jamabsen);

                            absenM::create($sendData);
                        }

                    }else {
                        if($absen->count() === 0) {
                            $sendData["nisn"] = $cekkartu->siswa->nisn;
                            $sendData["tanggal"] = $tanggal;
                            $sendData["jamkeluar"] = date("H:i", $jamabsen);

                            absenM::create($sendData);
                        }else if(empty($absen->first()->jamkeluar)){
                            $sendData["jamkeluar"] = date("H:i", $jamabsen);

                            $absen->first()->update($sendData);
                        }
                    }

                } //ini tutup foreach

                return response()->json(["message" => "success"]);

            }else {
                return response()->json(["message" => "Not Found"], 500);

            }
        }catch(\Throwable $th){
            return response()->json(["message" => "error"]);
        }


        // return strtoupper($hasil);
    }

    public function kelola(Request $request)
    {
        // try{
            $idinstansi = Auth::user()->idinstansi;

            $fungsi = Auth::user()->fungsi;

            // $instansi2 = instansiM::where("idinstansi", $idinstansi)->count();
            // dd($instansi2." ".$fungsi);
            $jsonData = $request->getContent();
            $data = json_decode($jsonData, true);
            dd($data);

            if($instansi2 === 1 && $fungsi == "pengelola") {
                $kodealat = Auth::user()->kodealat;
                $bacakartu = bacakartuM::where("idinstansi", $idinstansi)
                ->where("kodealat", $kodealat);

                if($bacakartu->count() === 0) {
                    $sendData["uuid"] = $data[0]["uuid"];
                    $sendData["kodealat"] = $kodealat;
                    $sendData["idinstansi"] = $idinstansi;

                    bacakartuM::create($sendData);
                }else {
                    $sendData["uuid"] = $data[0]["uuid"];
                    $bacakartu->first()->update($sendData);
                }
                return response()->json(["message" => "success"]);
            }else {
                return response()->json(["message" => "Not Found"], 500);
            }

        // }catch(\Throwable $th){
        //     return response()->json(["message" => "error"]);
        // }



    }

}

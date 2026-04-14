<?php

namespace App\Http\Controllers;

use App\Models\Response;
use App\Models\OrganScore;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    // Terima jawaban kuesioner dari frontend
    public function store(Request $request)
    {
        // 1. Hitung BMI
        $tinggi_m = $request->tinggi_badan / 100;
        $bmi = $request->berat_badan / ($tinggi_m * $tinggi_m);

        // 2. Tentukan penalti BMI per organ
        $penalty_semua = 0;
        $penalty_jantung_paru_hati = 0;

        if ($bmi < 18.5) {
            $penalty_jantung_paru_hati = 1;
        } elseif ($bmi >= 23 && $bmi < 27.5) {
            $penalty_semua = 1;
        } elseif ($bmi >= 27.5) {
            $penalty_semua = 2;
        }

        // 3. Simpan jawaban ke database
        $response = Response::create([
            'tinggi_badan' => $request->tinggi_badan,
            'berat_badan' => $request->berat_badan,
            'bmi' => round($bmi, 2),
            'j1' => $request->j1,
            'j2' => $request->j2,
            'j3' => $request->j3,
            'j4' => $request->j4,
            'j5' => $request->j5,
            'j6' => $request->j6,
            'j7' => $request->j7,
            'p1' => $request->p1,
            'p2' => $request->p2,
            'p3' => $request->p3,
            'p4' => $request->p4,
            'p5' => $request->p5,
            'p6' => $request->p6,
            'g1' => $request->g1,
            'g2' => $request->g2,
            'g3' => $request->g3,
            'g4' => $request->g4,
            'g5' => $request->g5,
            'g6' => $request->g6,
            'g7' => $request->g7,
            'h1' => $request->h1,
            'h2' => $request->h2,
            'h3' => $request->h3,
            'h4' => $request->h4,
            'h5' => $request->h5,
            'h6' => $request->h6,
        ]);

        // 4. Hitung skor tiap organ
        $organs = [
            'jantung' => [
                'jawaban' => [
                    $request->j1,
                    $request->j2,
                    $request->j3,
                    $request->j4,
                    $request->j5,
                    $request->j6,
                    $request->j7
                ],
                'penalty' => $penalty_jantung_paru_hati + $penalty_semua,
            ],
            'paru' => [
                'jawaban' => [
                    $request->p1,
                    $request->p2,
                    $request->p3,
                    $request->p4,
                    $request->p5,
                    $request->p6
                ],
                'penalty' => $penalty_jantung_paru_hati + $penalty_semua,
            ],
            'ginjal' => [
                'jawaban' => [
                    $request->g1,
                    $request->g2,
                    $request->g3,
                    $request->g4,
                    $request->g5,
                    $request->g6,
                    $request->g7
                ],
                'penalty' => $penalty_semua,
            ],
            'hati' => [
                'jawaban' => [
                    $request->h1,
                    $request->h2,
                    $request->h3,
                    $request->h4,
                    $request->h5,
                    $request->h6
                ],
                'penalty' => $penalty_jantung_paru_hati + $penalty_semua,
            ],
        ];

        $hasil = [];

        foreach ($organs as $nama => $data) {
            $raw = array_sum($data['jawaban']);
            $max = count($data['jawaban']) * 2; // maks per soal = 2
            $raw_after = max(0, $raw - $data['penalty']);
            $persen = round(($raw_after / $max) * 100, 1);

            // Klasifikasi
            if ($persen >= 70) {
                $status = 'sehat';
            } elseif ($persen >= 40) {
                $status = 'waspada';
            } else {
                $status = 'risiko';
            }

            // Simpan skor ke database
            OrganScore::create([
                'response_id' => $response->id,
                'organ_name' => $nama,
                'raw_score' => $raw_after,
                'max_score' => $max,
                'percentage' => $persen,
                'status' => $status,
                'bmi_penalty' => $data['penalty'],
            ]);

            $hasil[$nama] = [
                'percentage' => $persen,
                'status' => $status,
            ];
        }

        // 5. Kirim hasil ke frontend
        return response()->json([
            'response_id' => $response->id,
            'bmi' => round($bmi, 2),
            'hasil' => $hasil,
        ]);
        //Wleeee
    }

    // Ambil hasil berdasarkan ID
    public function show($id)
    {
        $response = Response::with('organScores')->findOrFail($id);
        return response()->json($response);
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('responses', function (Blueprint $table) {
            $table->id();

            // Data tubuh
            $table->float('tinggi_badan');      // cm
            $table->float('berat_badan');       // kg
            $table->float('bmi');               // dihitung otomatis

            // Jawaban kuesioner Jantung (j1-j7), nilai 0/1/2
            $table->integer('j1'); // aktivitas fisik
            $table->integer('j2'); // nyeri dada
            $table->integer('j3'); // sesak napas
            $table->integer('j4'); // bengkak kaki
            $table->integer('j5'); // jantung berdebar
            $table->integer('j6'); // pola makan
            $table->integer('j7'); // merokok

            // Jawaban kuesioner Paru (p1-p6)
            $table->integer('p1'); // batuk >2 minggu
            $table->integer('p2'); // paparan polusi
            $table->integer('p3'); // aktivitas aerobik
            $table->integer('p4'); // napas berbunyi
            $table->integer('p5'); // sesak aktivitas ringan
            $table->integer('p6'); // ventilasi ruangan

            // Jawaban kuesioner Ginjal (g1-g7)
            $table->integer('g1'); // konsumsi air
            $table->integer('g2'); // warna urin
            $table->integer('g3'); // obat penghilang nyeri
            $table->integer('g4'); // nyeri pinggang
            $table->integer('g5'); // riwayat hipertensi/diabetes
            $table->integer('g6'); // olahraga
            $table->integer('g7'); // pembengkakan wajah/kaki

            // Jawaban kuesioner Hati (h1-h6)
            $table->integer('h1'); // makanan berlemak
            $table->integer('h2'); // mual/kembung
            $table->integer('h3'); // kulit kekuningan
            $table->integer('h4'); // olahraga
            $table->integer('h5'); // obat/jamu tanpa resep
            $table->integer('h6'); // lelah berlebihan

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('responses');
    }
};
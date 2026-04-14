<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('organ_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('response_id')
                ->constrained('responses')
                ->onDelete('cascade');
            $table->string('organ_name');   // jantung, paru, ginjal, hati
            $table->float('raw_score');     // total poin mentah
            $table->float('max_score');     // total poin maksimal organ ini
            $table->float('percentage');    // persentase (raw/max x 100)
            $table->string('status');       // sehat, waspada, risiko
            $table->float('bmi_penalty');   // pengurangan poin akibat BMI
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organ_scores');
    }
};
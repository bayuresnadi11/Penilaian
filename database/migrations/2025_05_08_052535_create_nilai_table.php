<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('nilai', function (Blueprint $table) {
            $table->id(); // auto increment primary key
            $table->string('nip'); // FK ke guru.nip
            $table->string('nis'); // FK ke murid.nis
            $table->string('kode'); // FK ke mata_pelajaran.kode
            $table->integer('nilai');
            $table->string('predikat', 2);
            $table->integer('semester');
            
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('nip')->references('nip')->on('guru')->onDelete('cascade');
            $table->foreign('nis')->references('nis')->on('murid')->onDelete('cascade');
            $table->foreign('kode')->references('kode')->on('mata_pelajaran')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
{
    Schema::dropIfExists('nilai');
}

    }
};

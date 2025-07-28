<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('murid', function (Blueprint $table) {
            // Menghapus kolom id dan menggunakan nis sebagai primary key
            $table->string('nis')->primary(); // Menjadikan nis sebagai primary key
            $table->string('nama');
            $table->string('kelas');
            $table->string('telepon');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->date('tanggal_lahir');
            $table->string('username_user');
            $table->timestamps();

            // Foreign key ke tabel users
            $table->foreign('username_user')->references('username')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('murid');
    }
};

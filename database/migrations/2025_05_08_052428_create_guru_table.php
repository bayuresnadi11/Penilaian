<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateGuruTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('guru', function (Blueprint $table) {
            // Menghapus kolom 'id' dan menjadikan 'nip' sebagai primary key
            $table->string('nip')->primary(); // Menjadikan nip sebagai primary key
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('no_telp')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->date('tgl_lahir');
            $table->string('username_user');
            $table->string('kode_mapel')->nullable();
            $table->timestamps();

            // Foreign key ke tabel users
            $table->foreign('username_user')->references('username')->on('users')->onDelete('cascade');
            // Foreign key ke tabel mata_pelajaran
            $table->foreign('kode_mapel')->references('kode')->on('mata_pelajaran')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guru', function (Blueprint $table) {
            $table->dropForeign(['username_user']);
            $table->dropForeign(['kode_mapel']);
        });
        Schema::dropIfExists('guru');
    }
}

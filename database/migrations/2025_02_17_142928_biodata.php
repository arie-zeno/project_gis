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
        Schema::create('Biodata', function (Blueprint $table) {
            $table->id("id_biodata");
            $table->unsignedBigInteger("nim");
            $table->foreign("nim")->references('nim')->on('users')->onDelete('cascade'); # relasi user
            $table->string("nama");
            $table->string("telepon");
            $table->string("angkatan");
            $table->string("jenis_kelamin");
            $table->string("agama");
            $table->string("foto");
            $table->string("tempat_lahir");
            $table->string("provinsi");
            $table->string("kabupaten");
            $table->string("kecamatan");
            $table->string("kelurahan");
            $table->string("koordinat");
            $table->string("penghasilan");
            $table->unsignedBigInteger("id_sekolah")->nullable();
            $table->foreign("id_sekolah")->references('id')->on('sekolah')->onDelete('cascade'); # relasi sekolah
            $table->unsignedBigInteger("id_tempat_tinggal")->nullable();
            $table->foreign("id_tempat_tinggal")->references('id')->on('tempat_tinggal')->onDelete('cascade'); # relasi tempat tinggal (kost)
            $table->date("tanggal_lahir");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Biodata');
    }
};

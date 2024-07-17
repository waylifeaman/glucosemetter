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
        Schema::create('penyakits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pasien');
            $table->integer('bpm');
            $table->integer('spo2');
            $table->decimal('gula_darah', 8, 2);
            $table->timestamps();

            $table->foreign('id_pasien')->references('id')->on('pasiens')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penyakits', function (Blueprint $table) {
            $table->id();
            $table->dropForeign(['id_pasien']);
            $table->integer('bpm');
            $table->integer('spo2');
            $table->decimal('gula_darah', 8, 2);
            $table->timestamps();
        });
    }
};

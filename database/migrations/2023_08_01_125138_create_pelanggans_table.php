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
        Schema::create('pelanggans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('telepon');
            $table->date('tanggal_register');
            $table->integer('tanggal_tagihan');
            $table->integer('tanggal_isolir')->nullable();
            $table->foreignId('paket_id')->nullable()->constrained()->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('area_id')->nullable()->constrained()->nullOnDelete()->cascadeOnUpdate();
            $table->string('tambahan1')->nullable();
            $table->decimal('biaya1', 65, 0)->nullable();
            $table->string('tambahan2')->nullable();
            $table->decimal('biaya2', 65, 0)->nullable();
            $table->decimal('diskon', 65, 0)->nullable();
            $table->boolean('prorata')->default(false);
            $table->integer('tanggal_pasang')->nullable();
            $table->decimal('hasil_prorata', 65, 0)->nullable();
            $table->string('ppoe')->nullable();
            $table->string('info_modem')->nullable();
            $table->string('alamat')->nullable();
            $table->decimal('latitude', 11, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggans');
    }
};

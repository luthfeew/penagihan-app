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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tagihan_id')->nullable()->constrained()->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('pelanggan_id')->nullable()->constrained()->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('saldo_id')->nullable()->constrained()->nullOnDelete()->cascadeOnUpdate();
            $table->string('kode');
            $table->decimal('total_tagihan', 65, 0)->default(0);
            $table->decimal('bayar', 65, 0)->default(0);
            $table->decimal('lebih', 65, 0)->default(0);
            $table->decimal('kurang', 65, 0)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};

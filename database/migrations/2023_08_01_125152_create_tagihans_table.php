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
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->nullable()->constrained()->nullOnDelete()->cascadeOnUpdate();
            $table->date('bulan');
            $table->decimal('tagihan', 65, 0)->default(0);
            $table->string('tambahan1')->nullable();
            $table->decimal('biaya1', 65, 0)->default(0);
            $table->string('tambahan2')->nullable();
            $table->decimal('biaya2', 65, 0)->default(0);
            $table->decimal('diskon', 65, 0)->default(0);
            $table->decimal('total_tagihan', 65, 0)->default(0);
            $table->boolean('is_lunas')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihans');
    }
};

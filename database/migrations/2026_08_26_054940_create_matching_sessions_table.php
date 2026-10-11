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
        Schema::create('matching_sessions', function (Blueprint $table) {
            $table->id();
              // Nama pemeriksaan
            $table->string('name')->nullable();

            // Informasi sumber A
            $table->string('source_a_file');
            $table->string('source_a_sheet')->nullable();

            // Informasi sumber B
            $table->string('source_b_file')->nullable();
            $table->string('source_b_sheet')->nullable();

            // Jenis perbandingan
            // Contoh: two_files atau two_sheets
            $table->string('comparison_type');

            // Status proses
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matching_sessions');
    }
};

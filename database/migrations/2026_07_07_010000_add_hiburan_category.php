<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!DB::table('kategori')->where('name_categori', 'Hiburan & Entertainment')->exists()) {
            DB::table('kategori')->insert(['name_categori' => 'Hiburan & Entertainment']);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('kategori')->where('name_categori', 'Hiburan & Entertainment')->delete();
    }
};

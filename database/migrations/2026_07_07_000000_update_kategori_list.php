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
        // Update existing category rows to the requested portal categories.
        DB::table('kategori')->where('id', 1)->update(['name_categori' => 'Politik']);
        DB::table('kategori')->where('id', 2)->update(['name_categori' => 'Ekonomi & Bisnis']);
        DB::table('kategori')->where('id', 3)->update(['name_categori' => 'Sosial & Budaya']);

        // Ensure additional categories exist for navigation.
        if (!DB::table('kategori')->where('name_categori', 'Sains & Teknologi')->exists()) {
            DB::table('kategori')->insert(['name_categori' => 'Sains & Teknologi']);
        }
        if (!DB::table('kategori')->where('name_categori', 'Internasional')->exists()) {
            DB::table('kategori')->insert(['name_categori' => 'Internasional']);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('kategori')->where('id', 1)->update(['name_categori' => 'sports']);
        DB::table('kategori')->where('id', 2)->update(['name_categori' => 'kriminal']);
        DB::table('kategori')->where('id', 3)->update(['name_categori' => 'Testing']);
        DB::table('kategori')->where('name_categori', 'Sains & Teknologi')->delete();
        DB::table('kategori')->where('name_categori', 'Internasional')->delete();
    }
};

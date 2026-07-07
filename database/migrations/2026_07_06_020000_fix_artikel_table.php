<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE artikel MODIFY id INT NOT NULL AUTO_INCREMENT PRIMARY KEY');
        DB::statement('ALTER TABLE artikel MODIFY foto VARCHAR(255) NULL');
        DB::statement('ALTER TABLE artikel MODIFY lokasi_id INT NULL');

        if (!Schema::hasColumn('artikel', 'posisi')) {
            DB::statement('ALTER TABLE artikel ADD COLUMN posisi VARCHAR(255) NULL AFTER kategori_id');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE artikel MODIFY id INT NOT NULL');
        DB::statement('ALTER TABLE artikel MODIFY foto VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE artikel MODIFY lokasi_id INT NOT NULL');

        if (Schema::hasColumn('artikel', 'posisi')) {
            Schema::table('artikel', function (Blueprint $table) {
                $table->dropColumn('posisi');
            });
        }
    }
};

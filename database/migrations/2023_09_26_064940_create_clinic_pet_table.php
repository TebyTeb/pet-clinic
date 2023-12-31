<?php

use App\Models\Pet;
use App\Models\Clinic;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('clinic_pet', function (Blueprint $table) {
            $table->foreignIdFor(Clinic::class);
            $table->foreignIdFor(Pet::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clinic_pet', function (Blueprint $table) {
            //
        });
    }
};

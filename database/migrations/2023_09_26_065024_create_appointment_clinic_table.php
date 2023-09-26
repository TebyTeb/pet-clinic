<?php

use App\Models\Appointment;
use App\Models\Clinic;
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
        Schema::table('appointment_clinic', function (Blueprint $table) {
            $table->foreignIdFor(Appointment::class);
            $table->foreignIdFor(Clinic::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointment_clinic', function (Blueprint $table) {
            //
        });
    }
};

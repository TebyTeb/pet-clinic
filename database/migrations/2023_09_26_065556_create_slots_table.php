<?php

use App\Models\User;
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
        Schema::create('slots', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'owner_id');
            $table->date('date');
            $table->time('start');
            $table->time('end');
            $table->string('status');
            $table->timestamps();
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->after('pet_id', function (Blueprint $table) {
                $table->foreignId('slot_id')
                    ->constrained('slots');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slots');
        Schema::dropColumns('appointments', 'slot_id');
    }
};

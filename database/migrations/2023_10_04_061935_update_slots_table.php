<?php

use App\Models\User;
use App\Models\Schedule;
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
        Schema::table('slots', function (Blueprint  $table) {
            $table->dropColumn('date');
            $table->dropColumn('owner_id');
            $table->foreignIdFor(Schedule::class);
            $table->string('status')->default('available')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('slots', function (Blueprint  $table) {
            $table->date('date');
            $table->foreignIdFor(User::class, 'owner_id');
            $table->dropColumn('schedule_id');
            $table->string('status')->change();
        });
    }
};

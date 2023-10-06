<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Slot extends Model
{
    use HasFactory;

    protected $casts = [
        //? Convierte las fechas a instancias de Carbon, para poder usar metodos de Carbon directamente
        'start' => 'datetime',
        'end' => 'datetime',
    ];

    public function appointment(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'age',
        'grade_id',
    ];

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}

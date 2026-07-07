<?php

namespace App\Models;

use App\Http\Controllers\AppointmentController;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'category',
        'duration_minutes',
        'price',
        'description',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'duration_minutes' => 'integer',
            'price' => 'decimal:2',
        ];
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
        
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Availability extends Model
{
    use HasFactory;

    protected $table = 'availability';

    protected $guarded = [];

    public function availability(): BelongsTo {
        return $this->belongsTo(Performance::class);
    }

    public function oee(): BelongsTo {
        return $this->belongsTo(OverallEquipmentEffectiveness::class);
    }

}

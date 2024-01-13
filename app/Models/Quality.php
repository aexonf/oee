<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quality extends Model
{
    use HasFactory;

    protected $table = 'quality';

    protected $guarded = [];

    public function performance(): BelongsTo {
        return $this->belongsTo(Performance::class);
    }

    public function oee(): BelongsTo {
        return $this->belongsTo(OverallEquipmentEffectiveness::class);
    }
}

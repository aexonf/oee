<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Performance extends Model
{
    use HasFactory;

    protected $table = 'performance';

    protected $guarded = [];

    public function availability(): BelongsTo {
        return $this->belongsTo(Availability::class);
    }

    public function quality(): BelongsTo {
        return $this->belongsTo(Quality::class);
    }
    public function oee(): BelongsTo {
        return $this->belongsTo(OverallEquipmentEffectiveness::class);
    }
}

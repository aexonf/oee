<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OverallEquipmentEffectiveness extends Model
{
    use HasFactory;

    protected $table = 'overall_equipment_effectiveness';

    protected $guarded = [];

    protected $dates = ['created_at', 'updated_at'];


    public function performance(): BelongsTo {
        return $this->belongsTo(Performance::class);
    }

    public function availability(): BelongsTo {
        return $this->belongsTo(Availability::class);
    }

    public function quality(): BelongsTo {
        return $this->belongsTo(Quality::class);
    }
}

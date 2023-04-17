<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelHasCalendarEvent extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'model_id',
        'model_type',
        'calendar_event_id'
    ];
}

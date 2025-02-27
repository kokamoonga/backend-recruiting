<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetricValue extends Model
{
    protected $fillable = ['metric_id', 'external_id', 'achieved_at', 'value'];
}

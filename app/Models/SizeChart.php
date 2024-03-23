<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SizeChart extends Model
{
    protected $guarded = [];
    
    public function sizeChartDetails()
    {
        return $this->hasMany(SizeChartDetail::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pipeline extends Model
{
    protected $fillable = ['name', 'previous_pipeline_id', 'next_pipeline_id'];

    // Define relationships for previous and next pipelines
    public function previousPipeline()
    {
        return $this->belongsTo(Pipeline::class, 'previous_pipeline_id');
    }

    public function nextPipeline()
    {
        return $this->belongsTo(Pipeline::class, 'next_pipeline_id');
    }

    public function cards()
    {
        return $this->hasMany(Card::class);
    }
}
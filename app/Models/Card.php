<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'pipeline_id'];

    public function pipeline()
    {
        return $this->belongsTo(Pipeline::class);
    }
}

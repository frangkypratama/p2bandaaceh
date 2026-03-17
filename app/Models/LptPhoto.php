<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LptPhoto extends Model
{
    use HasFactory;

    protected $fillable = ['lpt_id', 'file_path'];

    public function lpt()
    {
        return $this->belongsTo(Lpt::class);
    }
}
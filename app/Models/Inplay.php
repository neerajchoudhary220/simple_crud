<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inplay extends Model
{
    use HasFactory;
    protected $fillable =['sport_id','data'];
    protected $casts = ['data'=>'json'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreMatchMarket extends Model
{
    use HasFactory;
    protected $fillable =['upcoming_event_id','data'];
    protected $casts =['data'=>'json'];
}

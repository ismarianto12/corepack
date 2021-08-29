<?php

namespace Ismarianto\Ismarianto\Models;

use Illuminate\Database\Eloquent\Model;

class Ismarianto extends Model
{
    protected $fillable = [
        'name', 'duration', 'status'
    ];
}

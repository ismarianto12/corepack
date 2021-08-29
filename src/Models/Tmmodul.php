<?php

namespace Ismarianto\Ismarianto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tmmodul extends Model
{
    use HasFactory;

    protected $table = 'tmmodul';
    public $incrementing = false;
    public $datetime = false;
    protected $guarded = [];
}

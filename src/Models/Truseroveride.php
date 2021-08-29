<?php

namespace Ismarianto\Ismarianto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Truseroveride extends Model
{
    use HasFactory;

    protected $table = 'truseroveride';
    public $incrementing = false;
    public $datetime = false;
    protected $guarded = [];
}

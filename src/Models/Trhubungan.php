<?php

namespace Ismarianto\Ismarianto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Trhubungan extends Model
{
    use HasFactory;

    protected $table = 'tmhubungan';
    public $incrementing = false;
    public $datetime = false;
    public $timestamps = false;


    protected $guarded = [];
}

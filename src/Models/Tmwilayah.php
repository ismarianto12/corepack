<?php

namespace Ismarianto\Ismarianto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tmwilayah extends Model
{
    use HasFactory;

    protected $table = 'tmwilayah';
    public $incrementing = false;
    public $datetime = false;
    protected $guarded = [];
}

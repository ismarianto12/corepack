<?php

namespace Ismarianto\Ismarianto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tmstatus_aplikasi extends Model
{
    use HasFactory;

    protected $table = 'tmstatus_aplikasi';
    public $incrementing = false;
    public $datetime = false;
    protected $guarded = [];
}

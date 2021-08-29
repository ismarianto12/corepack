<?php

namespace Ismarianto\Ismarianto\Models;

use Illuminate\Database\Eloquent\Model;
use Ismarianto\Ismarianto\Models\Tmparameter;

class Tmsla extends Model
{
    // protected $fillable = [
    //     'name', 'duration', 'status'
    // ];
    protected $table = 'tmsla';
    protected $guarded = [];
    protected $datetime = FALSE;
    public $timestamps = false;
}

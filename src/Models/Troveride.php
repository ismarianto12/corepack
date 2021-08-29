<?php

namespace Ismarianto\Ismarianto\Models;

use Illuminate\Database\Eloquent\Model;
use Ismarianto\Ismarianto\Models\Tmparameter;

class Troveride extends Model
{
    protected $table = 'troveride';
    protected $guarded = [];
    protected $datetime = FALSE;
    public $timestamps = false;
}

<?php

namespace Ismarianto\Ismarianto\Models;

use Illuminate\Database\Eloquent\Model;
use Ismarianto\Ismarianto\Models\Tmparameter;

class Tmlevelakses extends Model
{
    protected $table = 'tmlevelakses';
    protected $guarded = [];
    protected $datetime = FALSE;
    public $timestamps = false;
}

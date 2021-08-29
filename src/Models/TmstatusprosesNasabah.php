
<?php

namespace Ismarianto\Ismarianto\Models;

use Illuminate\Database\Eloquent\Model;
use Ismarianto\Ismarianto\Models\Tmparameter;
use Ismarianto\Ismarianto\Models\Tmnasabah;

class TmstatusprosesNasabah extends Model
{
    protected $table = 'tmstatusproses_nasabah';
    protected $guarded = [];
    protected $datetime = FALSE;
    public $timestamps = false;
}

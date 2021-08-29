<?php

namespace Ismarianto\Ismarianto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Trbiayapenutupan extends Model
{
    use HasFactory;

    protected $table = 'trbiayapenutupan';
    public $incrementing = false;
    public $datetime = false;
    protected $guarded = [];

    public function Tmparameter()
    {
        return $this->belongsTo(Tmparameter::class);
    }
}

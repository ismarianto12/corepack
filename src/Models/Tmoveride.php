<?php

namespace Ismarianto\Ismarianto\Models;

use Illuminate\Database\Eloquent\Model;
use Ismarianto\Ismarianto\Models\Tmparameter;
use Ismarianto\Ismarianto\Models\Tmnasabah;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;

class Tmoveride extends Model
{

    protected $table = 'tmoveride';
    protected $guarded = [];
    protected $datetime = FALSE;
    public $timestamps = true;


    // public function Tmparameter()
    // {
    //     return $this->belongsTo(Tmparameter::class);
    // }

    // public function Tmnasabah()
    // {
    //     return $this->belongsTo(Tmnasabah::class);
    // }
    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {

            $model->user_id = Session::get('username');
            $model->created_at = Carbon::now();
            $model->updated_at =  Carbon::now();
        });
        
        static::updating(function ($model) { 
            $model->user_id = Session::get('username');
            $model->created_at = Carbon::now();
            $model->updated_at =  Carbon::now();
        });
    }
}
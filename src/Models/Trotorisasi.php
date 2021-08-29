<?php

namespace Ismarianto\Ismarianto\Models;

use Illuminate\Database\Eloquent\Model;
use Ismarianto\Ismarianto\Models\Tmparameter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;

class Trotorisasi extends Model
{
    protected $table = 'trotorisasi';
    protected $guarded = [];
    protected $datetime = FALSE;
    public $timestamps = false;

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {

            $model->user_id = Session::get('username');
            $model->created_at = Carbon::now();
        });

        static::updating(function ($model) {
            $model->user_id = Session::get('username');
            $model->updated_at =  Carbon::now();
        });
    }
}

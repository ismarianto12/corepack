<?php

namespace Ismarianto\Ismarianto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;

class Trstatus_otorisasi extends Model
{
    protected $table = 'trstatus_otorisasi';
    protected $guarded = [];
    protected $datetime = FALSE;
    public $timestamps = false;

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {

            $model->users_id = Session::get('username');
            $model->created_at = Carbon::now();
        });

        static::updating(function ($model) {
            $model->users_id = Session::get('username');
            $model->updated_at =  Carbon::now();
        });
    }
}

<?php

namespace Ismarianto\Ismarianto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;

class Tmupload_jaminan extends Model
{

    // use HasFactory;
    protected $table = 'tmupload_jaminan';
    public $incrementing = false;
    public $datetime = false;
    protected $guarded = [];

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

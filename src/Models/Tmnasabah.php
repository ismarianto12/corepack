<?php

namespace Ismarianto\Ismarianto\Models;

use Illuminate\Database\Eloquent\Model;
use Ismarianto\Ismarianto\Models\Tmparameter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;

class Tmnasabah extends Model
{
    // protected $fillable = [
    //     'name', 'duration', 'status'
    // ];
    protected $table = 'tmnasabah';
    protected $guarded = [];
    protected $datetime = FALSE;
    public $timestamps = true;


    public function Tmparameter()
    {
        return  $this->belongsTo(Tmparameter::class);
    }

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

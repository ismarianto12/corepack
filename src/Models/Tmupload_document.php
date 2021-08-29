<?php

namespace Ismarianto\Ismarianto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Ismarianto\Ismarianto\Models\Tmparameterdoc;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;


class Tmupload_document extends Model
{

    use HasFactory;

    protected $table = 'tmupload_document';
    public $incrementing = false;
    public $datetime = false;
    protected $guarded = [];

    public static function cekdocument($par)
    {
        return Tmparameterdoc::select(
            \DB::raw('count(tmparameter_doc.nama_doc) as jdoc, 
        count(tmupload_document.nama_file) as jnfileupload')
        )->join(
            'tmupload_document',
            'tmupload_document.tmparameter_doc_id',
            '=',
            'tmparameter_doc.id',
            'LEFT'
        )
            ->where('tmparameter_doc.category', $par['category']);
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

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deuda extends Model
{
    use SoftDeletes;
    protected $table = "deudas";
    public $timestamps = false;
    protected $dates = ['deleted_at'];
}

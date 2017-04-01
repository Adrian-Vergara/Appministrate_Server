<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ingreso extends Model
{
    use SoftDeletes;
    protected $table = "ingresos";
    public $timestamps = false;
    protected $dates = ['deleted_at'];
}

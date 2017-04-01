<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gasto extends Model
{
    use SoftDeletes;
    protected $table = "gastos";
    public $timestamps = false;
    protected $dates = ['deleted_at'];
}

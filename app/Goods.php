<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
     protected  $table='goods';

	protected $primaryKey='shop_id';

	public $timestamps = false;

	protected $guarded = [];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected  $table='member';

	protected $primaryKey='user_id';

	public $timestamps = false;

	protected $guarded = [];
}

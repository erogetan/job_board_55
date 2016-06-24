<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{

	//restricted form data to guarded.
	//fillable is a white list of what is accepted
	//guarded is like a black list of what you don't want accepted
    protected $guarded = [];

	public function comments()
	{

		//
		return $this->hasMany('App\Comment', 'job_id');

		

	}

	//Base function name off of plural or singular
	public function author()
	{


		return $this->belongsTo('App\User','author_id');

	}



}

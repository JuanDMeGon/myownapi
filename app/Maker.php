<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Maker extends Model
{
	protected $table = 'makers';

	protected $fillable = ['name', 'phone'];

	protected $hidden = ['id', 'updated_at', 'created_at'];

	public function vehicles()
	{
		return $this->hasMany('App\Vehicle');
	}
}
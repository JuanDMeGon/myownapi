<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
	protected $table = 'vehicles';

	protected $primaryKey = 'serie';

	protected $fillable = ['color', 'power', 'capacity', 'speed', 'maker_id'];

	protected $hidden = ['serie', 'created_at', 'updated_at', 'maker_id'];

	public function maker()
	{
		return $this->belongsTo('App\Maker');
	}
}
<?php
namespace Model\Table\Eloquent;
use Illuminate\Database\Eloquent\Model as Eloquent;
class Profiles extends Eloquent {

	protected $table = 'profiles';
    public $timestamps = false;
    public function users(){
		return $this->hasOne('Model\Table\EloquentUsers','id', 'profiles_id');
	}
}
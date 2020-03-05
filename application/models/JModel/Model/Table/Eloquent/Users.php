<?php
namespace Model\Table\Eloquent;
use Illuminate\Database\Eloquent\Model as Eloquent;
class Users extends Eloquent {

	protected $table = 'users';
	// protected $primaryKey = "id";
    public $timestamps = false;
	
	public function roles(){
		return $this->belongsTo('Model\Table\Eloquent\Roles','roles_id', 'id');
	}
	public function profiles(){
		return $this->belongsTo('Model\Table\Eloquent\Profiles','profiles_id', 'id');
	}
}
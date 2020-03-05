<?php
namespace Model\Table\Eloquent;
use Illuminate\Database\Eloquent\Model as Eloquent;
class Roles extends Eloquent {

	protected $table = 'roles';
    public $timestamps = false;
    public function users(){
		return $this->hasOne('Model\Table\Eloquent\Users','id', 'roles_id');
	}
}
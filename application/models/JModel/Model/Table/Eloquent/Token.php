<?php 
namespace Model\Table\Eloquent;
use Illuminate\Database\Eloquent\Model as Eloquent;
class Token extends Eloquent {

	protected $table = 'customer_sessions';
	// protected $primaryKey = "id";
	// public $incrementing = false;
    public $timestamps = false;
    
}
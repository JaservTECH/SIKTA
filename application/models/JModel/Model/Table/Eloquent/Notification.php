<?php 
namespace Model\Table\Eloquent;
use Illuminate\Database\Eloquent\Model as Eloquent;
class Notification extends Eloquent {

	protected $table = 'notification_state';
	// protected $primaryKey = "id";
	// public $incrementing = false;
    public $timestamps = false;
    
}
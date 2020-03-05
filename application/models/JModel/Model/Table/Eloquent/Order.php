<?php 
namespace Model\Table\Eloquent;
use Illuminate\Database\Eloquent\Model as Eloquent;
class Order extends Eloquent {

	protected $table = 'orders';
	// protected $primaryKey = "id";
    public $timestamps = false;
    
}
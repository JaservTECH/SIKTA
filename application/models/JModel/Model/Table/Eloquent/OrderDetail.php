<?php 
namespace Model\Table\Eloquent;
use Illuminate\Database\Eloquent\Model as Eloquent;
class OrderDetail extends Eloquent {

	protected $table = 'order_details';
	// protected $primaryKey = "id";
    public $timestamps = false;
    
}
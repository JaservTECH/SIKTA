<?php 
namespace Model\Table\Eloquent;
use Illuminate\Database\Eloquent\Model as Eloquent;
class Customer extends Eloquent {

	protected $table = 'customers';
	// protected $primaryKey = "id";
    public $timestamps = false;
    
}
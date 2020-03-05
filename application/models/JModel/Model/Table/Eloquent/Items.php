<?php 
namespace Model\Table\Eloquent;
use Illuminate\Database\Eloquent\Model as Eloquent;
class Items extends Eloquent {

	protected $table = 'items';
	// protected $primaryKey = "id";
    public $timestamps = false;
    
}
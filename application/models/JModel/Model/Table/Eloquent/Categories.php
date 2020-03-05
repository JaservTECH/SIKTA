<?php 
namespace Model\Table\Eloquent;
use Illuminate\Database\Eloquent\Model as Eloquent;
class Categories extends Eloquent {

	protected $table = 'categories';
	// protected $primaryKey = "id";
    public $timestamps = false;
    
}
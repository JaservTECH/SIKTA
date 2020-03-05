<?php 

use Illuminate\Database\Eloquent\Model as Eloquent;

class ExampleMod extends Eloquent {

	protected $table = 'migrations';
	protected $primaryKey = "version";
	public $incrementing = false;
    public $timestamps = false;
    
}
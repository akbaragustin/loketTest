<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;
class Users extends Model {

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['id', 'username','created_at', 'updated_at'];
    
}

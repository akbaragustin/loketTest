<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;
class Location extends Model {

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 't_location';
    protected $primaryKey = 'id_location';
    public $timestamps = false;
    protected $fillable = ['id_location', 'name_location','address_location','city_location','state_location', 'created_at', 'updated_at'];

    public static function getAll()
   {
       $id_user = \Session::get('auth');
       $input = Input::get('search.value');
       $get = Input::all();
       $where = "";
       if (!empty($input)) {
           $where = " WHERE t_location.name_location like '%".$input."%' OR t_location.address_location like '%".$input."%' OR t_location.city_location like '%".$input."%'";
       }

       if (!empty($get['name_location'])) {
           if (!empty($where)) {
               $where .= " or name_location  like '%".$get['name_location']."%'";
           } else {
               $where .= " WHERE name_location like '%".$get['name_location']."%'";
           }
           if (!empty($where)) {
               $where .= " or name_location  like '%".$get['name_location']."%'";
           } else {
               $where .= " WHERE name_location like '%".$get['name_location']."%'";
           }
       }

       // limit 10 OFFSET 1
       $start = Input::get('start');
       $length = Input::get('length');
       $limit  = "LIMIT ".$length." OFFSET ".$start;
       $query = " select * From t_location
               ".$where."
               ".$limit."
               ";
       $listData = \DB::select($query);


       return $listData;
   }

   public static function gettotalAsetTaker(){
       $query = "SELECT count(id_employe) as total FROM m_employe";

       $total = \DB::select($query);
       // print_r($total);die;
       $tot = $total[0]->total;
       if ($tot == NULL) {
         $tot = 0;
       }
       return $tot;
   }

}

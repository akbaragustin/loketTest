<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;
class Event extends Model {

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 't_event';
    protected $primaryKey = 'id_event';
    public $timestamps = false;
    protected $fillable = ['id_event', 'name_event','description_event','date_start_event','date_end_event','id_location' ,'created_at', 'updated_at'];

    public static function getAll()
   {
       $id_user = \Session::get('auth');
       $input = Input::get('search.value');
       $get = Input::all();
       $where = "";
       if (!empty($input)) {
           $where = " WHERE t_event.name_event like '%".$input."%' OR t_event.description_event like '%".$input."%'";
       }

       if (!empty($get['name_event'])) {
           if (!empty($where)) {
               $where .= " or name_event  like '%".$get['name_event']."%'";
           } else {
               $where .= " WHERE name_event like '%".$get['name_event']."%'";
           }
           if (!empty($where)) {
               $where .= " or name_event  like '%".$get['name_event']."%'";
           } else {
               $where .= " WHERE name_event like '%".$get['name_event']."%'";
           }
       }

       // limit 10 OFFSET 1
       $start = Input::get('start');
       $length = Input::get('length');
       $limit  = "LIMIT ".$length." OFFSET ".$start;
       $query = " select t_event.id_event,t_event.name_event,t_event.description_event,t_event.date_start_event,t_event.date_end_event,t_location.id_location,t_location.name_location From t_event
                 JOIN t_location ON t_location.id_location = t_event.id_location
               ".$where."
               ".$limit."
               ";
       $listData = \DB::select($query);


       return $listData;
   }
}

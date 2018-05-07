<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;
class MyEvent extends Model {

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 't_transaction_event';
    protected $primaryKey = 'id_transaction';
    public $timestamps = false;
    protected $fillable = ['id_user', 'id_ticket','created_at', 'updated_at'];

    public static function getAll()
   {
       $id_user = \Session::get('auth');
       $input = Input::get('search.value');
       $get = Input::all();
       $where = "";
       if (!empty($id_user)){
        $where = " WHERE t_transaction_event.id_user = '".$id_user['id_user']."' ";
       }
    //    if (!empty($input)) {
    //        $where = " WHERE t_transaction_event.name_ticket like '%".$input."%' OR t_ticket.description_ticket like '%".$input."%'";
    //    }

    //    if (!empty($get['name_ticket'])) {
    //        if (!empty($where)) {
    //            $where .= " or name_ticket  like '%".$get['name_ticket']."%'";
    //        } else {
    //            $where .= " WHERE name_ticket like '%".$get['name_ticket']."%'";
    //        }
    //        if (!empty($where)) {
    //            $where .= " or name_ticket  like '%".$get['name_ticket']."%'";
    //        } else {
    //            $where .= " WHERE name_ticket like '%".$get['name_ticket']."%'";
    //        }
    //    }

       // limit 10 OFFSET 1
       $start = Input::get('start');
       $length = Input::get('length');
       $limit  = "LIMIT ".$length." OFFSET ".$start;
       $query = " select t_ticket.id_ticket,t_ticket.name_ticket,t_ticket.capacity_ticket,t_ticket.date_start_ticket,t_ticket.date_end_ticket,t_event.id_event,t_event.name_event,t_location.name_location,users.username From t_transaction_event
                JOIN t_ticket ON t_ticket.id_ticket = t_transaction_event.id_ticket
                JOIN users ON users.id = t_transaction_event.id_user 
                JOIN t_event ON t_event.id_event = t_ticket.id_event
                 JOIN t_location ON t_event.id_location = t_location.id_location
               ".$where."
               ".$limit."
               ";
       $listData = \DB::select($query);


       return $listData;
   }
}

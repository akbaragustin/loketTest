<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;
class Ticket extends Model {

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 't_ticket';
    protected $primaryKey = 'id_ticket';
    public $timestamps = false;
    protected $fillable = ['id_ticket', 'name_ticket','date_start_ticket','date_end_ticket','id_event' ,'capacity_ticket','created_at', 'updated_at'];

    public static function getAll()
   {
       $id_user = \Session::get('auth');
       $input = Input::get('search.value');
       $get = Input::all();
       $where = "";
       if (!empty($input)) {
           $where = " WHERE t_ticket.name_ticket like '%".$input."%' OR t_ticket.description_ticket like '%".$input."%'";
       }

       if (!empty($get['name_ticket'])) {
           if (!empty($where)) {
               $where .= " or name_ticket  like '%".$get['name_ticket']."%'";
           } else {
               $where .= " WHERE name_ticket like '%".$get['name_ticket']."%'";
           }
           if (!empty($where)) {
               $where .= " or name_ticket  like '%".$get['name_ticket']."%'";
           } else {
               $where .= " WHERE name_ticket like '%".$get['name_ticket']."%'";
           }
       }

       // limit 10 OFFSET 1
       $start = Input::get('start');
       $length = Input::get('length');
       $limit  = "LIMIT ".$length." OFFSET ".$start;
       $query = " select t_ticket.id_ticket,t_ticket.name_ticket,t_ticket.capacity_ticket,t_ticket.date_start_ticket,t_ticket.date_end_ticket,t_event.id_event,t_event.name_event From t_ticket
                 JOIN t_event ON t_event.id_event = t_ticket.id_event
               ".$where."
               ".$limit."
               ";
       $listData = \DB::select($query);


       return $listData;
   }
}

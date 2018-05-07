<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\PayUservice\Exception;
use App\Models\MyEvent;
use App\Models\Event;
use Abraham\TwitterOAuth\TwitterOAuth;
use Response;
use URL;


/**
 * Handle event My
 *
 * @author akbar.agustin55@gmail.com <akbar.agustin55@gmail.com>
 */

class myEventController extends Controller
{
    
    public function index()
    {
        return view ('admin/myevent');
    }
    public function indexAjax()
    {
        $draw=$_REQUEST['draw'];
        $length=$_REQUEST['length'];
        $start=$_REQUEST['start'];
        $search=$_REQUEST['search']["value"];
        $listJabatan = new MyEvent;
        // ======= count ===== //
        $total= MyEvent::count();
        // ======= count ===== //
        $output=array();
        $output['draw']=$draw;
        $output['recordsTotal']=$output['recordsFiltered']=$total;
        $output['data']=array();
        $query = MyEvent::getAll();
        $list = [];
        $no = 1;
        foreach ($query as $key => $row) {
            $json['username'] = $row->username;
            $json['no'] = $no;
            $json['id_ticket'] = $row->id_ticket;
            $json['name_event'] = $row->name_event;
            $json['name_location'] = $row->name_location;
            $json['name_ticket'] = $row->name_ticket;
            $json['capacity_ticket'] = $row->capacity_ticket;
            $json['id_event'] = $row->id_event;
            $json['date_start_ticket'] = date("d-m-Y H:i:s", strtotime($row->date_start_ticket));
            $json['date_end_ticket'] = date("d-m-Y H:i:s", strtotime($row->date_end_ticket));
            $list[] = $json;
            $no++;
        }

        $output['data']  = $list;
        echo json_encode($output);
    }

    public function edit()
    {
     $id_event =Input::get('id_event');
    $getDataEvent = Event::Where("id_event",$id_event)->get()->toArray();
    $dataSession = \Session::get('auth');
      $twitter = new TwitterOAuth(
            config('twitter.consumer_key'),
            config('twitter.consumer_secret'),
            $dataSession['oauth_token'],
            $dataSession['oauth_token_secret']
        );
        $status = $twitter->post(
            "statuses/update", [
                "status" => "Please see my ".$getDataEvent[0]['name_event']." Here ".url('/feevent')."/".$id_event
            ]
        );
            $json['status'] = true;
            $json['messages'] = 'Success';
            $json['data'] = "check";
        //send view with data
        return Response::json($json);
    }
}

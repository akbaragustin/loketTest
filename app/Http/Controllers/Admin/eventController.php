<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\PayUservice\Exception;
use App\Models\Event;
use App\Models\Location;
use Response;
use URL;

/**
 * Handle event controller
 *
 * @author akbar.agustin55@gmail.com <akbar.agustin55@gmail.com>
 */

class eventController extends Controller
{
    
    public function index()
    {
         //get data event where Name event submissions from
         $data['location'] = Location::get()->toArray();
        return view ('admin/event',$data);
    }
    public function save()
    {
        //this is valdate for laravel
        $rules=[
            'name_event'=>'required',
        ];
        //this is massages if checked validate true
        $messages=[
            'name_event.required'=>'please enter your name event',      
        ];
        // if data NULL do the in this
        $validator=Validator::make(Input::all(), $rules, $messages);
                if ($validator->passes()) {
                    //get Data session for creator
                    if (!empty(Input::get('id_event'))) {
                        //this is update event
                    $return = $this->update(Input::all());
                    }else {
                        //create data event
                    $return = $this->create(Input::all());
                    }
                } else {
                    $return['status'] =false;
                    $return['messages'] =$messages;
                    $return['data'] =[];
                }
                echo json_encode($return);
    }
    public function indexAjax()
    {
        $draw=$_REQUEST['draw'];
        $length=$_REQUEST['length'];
        $start=$_REQUEST['start'];
        $search=$_REQUEST['search']["value"];
        $listJabatan = new Event;
        // ======= count ===== //
        $total=Event::count();
        // ======= count ===== //
        $output=array();
        $output['draw']=$draw;
        $output['recordsTotal']=$output['recordsFiltered']=$total;
        $output['data']=array();
        $query = Event::getAll();

        $list = [];
        $no = 1;
        foreach ($query as $key => $row) {
            $json['no'] = $no;
            $json['id_event'] = $row->id_event;
            $json['name_event'] = $row->name_event;
            $json['name_location'] = $row->name_location;
            $json['description_event'] = $row->description_event;
            $json['date_start_event'] = date("d-m-Y H:i:s", strtotime($row->date_start_event));
            $json['date_end_event'] = date("d-m-Y H:i:s", strtotime($row->date_end_event));
            $list[] = $json;
            $no++;
        }

        $output['data']  = $list;
        echo json_encode($output);
    }

    public function delete($id_event)
    {
        try {
            $event = Event::find($id_event);
            $event->delete();
        } catch (\Exception $e) {
            \Session::flash('DeleteFails', 'this data is used in other tables');
            return \Redirect::to(route('event.index'));
        }

        \Session::flash('DeleteSucces', 'SUCCESS');
        return \Redirect::to(route('event.index'));
    }

    public function edit()
    {
        //get id event
        $id_event =Input::get('id_event');
        //get event where id event
        $edit = Event::where('id_event', $id_event)->get();
        // this is declaration for data
        $data   = [];
        foreach ($edit as $key => $value) {
            $data['name_event'] = $value->name_event;
            $data['id_location'] = $value->id_location;
            $data['description_event'] = $value->description_event;
            $data['date_start_event'] = date('d-m-Y H:i:s',strtotime($value->date_start_event));
            $data['date_end_event'] = date('d-m-Y H:i:s',strtotime($value->date_end_event));
            $data['id_event'] = $value->id_event;
            $data['submit'] = 'Update';
        }

        if ($edit) {
            $json['status'] = true;
            $json['messages'] = 'Success';
            $json['data'] = $data;
        }else{
            $json['status'] = false;
            $json['messages'] = 'Failed';
            $json['data'] = [];
        }
        //send view with data
        return Response::json($json);
    }
    // this is process update for table event
    public function update($data)
    {
      
        //get data event where Name event submissions from
        $check_name = Event::where('name_event','=',Input::get('name_event'))->where('id_event','!=',Input::get('id_event'))->get()->toArray();
        //check name for database if the data exists then do the command in this
        if ($check_name) {
            $return['status'] = false;
            $return['messages'] ='(Event Must Be unique)';
            $return['data'] =[];
        }else{
        $dataSession = \Session::get('auth');
        $event = Event::find($data['id_event']);
        $event->name_event =$data['name_event'];
        $event->id_location =$data['id_location'];
        $event->description_event =$data['description_event'];
        $event->date_start_event =date("Y-m-d H:i:s",strtotime($data['date_start_event']));
        $event->date_end_event =date("Y-m-d H:i:s",strtotime($data['date_end_event']));
        $event->created_at =date('Y-m-d H:i:s');
        $event->updated_at = date('Y-m-d H:i:s');
        $event->update();

        $return['status'] = true;
        $return['messages'] ='SUCCSESS';
        $return['data'] =[];
        }
        return $return;
    }
    //this is process create table event
    public function create($data){
        //get data event where name_event submissions from
        $check_name = Event::where('name_event',Input::get('name_event'))->get()->toArray();
        //check name for database if the data exists then do the command in this
        if ($check_name) {
            $return['status'] = false;
            $return['messages'] ='(Event Must Be unique)';
            $return['data'] =[];
        }else{
        $data['date_start_event'] = date("Y-m-d H:i:s", strtotime($data['date_start_event']));
        $data['date_end_event'] = date("Y-m-d H:i:s", strtotime($data['date_end_event']));
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $query=Event::create($data);

        $return['status'] = true;
        $return['messages'] ='SUCCSESS';
        $return['data'] =[];
        }
        return $return;
    }

}

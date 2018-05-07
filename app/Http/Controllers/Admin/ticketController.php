<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\PayUservice\Exception;
use App\Models\Ticket;
use App\Models\Event;
use Response;
use URL;


/**
 * Handle event Ticket
 *
 * @author akbar.agustin55@gmail.com <akbar.agustin55@gmail.com>
 */

class ticketController extends Controller
{
    
    public function index()
    {
         //get data ticket where Name ticket submissions from
         $data['event'] = Event::get()->toArray();
        return view ('admin/ticket',$data);
    }
    public function save()
    {
        //this is valdate for laravel
        $rules=[
            'name_ticket'=>'required',
        ];
        //this is massages if checked validate true
        $messages=[
            'name_ticket.required'=>'please enter your name ticket',      
        ];
        // if data NULL do the in this
        $validator=Validator::make(Input::all(), $rules, $messages);
                if ($validator->passes()) {
                    //get Data session for creator
                    if (!empty(Input::get('id_ticket'))) {
                        //this is update ticket
                    $return = $this->update(Input::all());
                    }else {
                        //create data ticket
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
        $listJabatan = new Ticket;
        // ======= count ===== //
        $total=Ticket::count();
        // ======= count ===== //
        $output=array();
        $output['draw']=$draw;
        $output['recordsTotal']=$output['recordsFiltered']=$total;
        $output['data']=array();
        $query = Ticket::getAll();

        $list = [];
        $no = 1;
        foreach ($query as $key => $row) {
            $json['no'] = $no;
            $json['id_ticket'] = $row->id_ticket;
            $json['capacity_ticket'] = $row->capacity_ticket;
            $json['name_ticket'] = $row->name_ticket;
            $json['name_event'] = $row->name_event;
            $json['date_start_ticket'] = date("d-m-Y H:i:s", strtotime($row->date_start_ticket));
            $json['date_end_ticket'] = date("d-m-Y H:i:s", strtotime($row->date_end_ticket));
            $list[] = $json;
            $no++;
        }

        $output['data']  = $list;
        echo json_encode($output);
    }

    public function delete($id_ticket)
    {
        try {
            $ticket = Ticket::find($id_ticket);
            $ticket->delete();
        } catch (\Exception $e) {
            \Session::flash('DeleteFails', 'this data is used in other tables');
            return \Redirect::to(route('ticket.index'));
        }

        \Session::flash('DeleteSucces', 'SUCCESS');
        return \Redirect::to(route('ticket.index'));
    }

    public function edit()
    {
        //get id ticket
        $id_ticket =Input::get('id_ticket');
        //get ticket where id ticket
        $edit = Ticket::where('id_ticket', $id_ticket)->get();
        // this is declaration for data
        $data   = [];
        foreach ($edit as $key => $value) {
            $data['name_ticket'] = $value->name_ticket;
            $data['id_event'] = $value->id_event;
            $data['capacity_ticket'] =$value->capacity_ticket;
            $data['date_start_ticket'] = date('d-m-Y H:i:s',strtotime($value->date_start_ticket));
            $data['date_end_ticket'] = date('d-m-Y H:i:s',strtotime($value->date_end_ticket));
            $data['id_ticket'] = $value->id_ticket;
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
    // this is process update for table ticket
    public function update($data)
    {
      
        //get data ticket where Name ticket submissions from
        $check_name = Ticket::where('name_ticket','=',Input::get('name_ticket'))->where('id_ticket','!=',Input::get('id_ticket'))->get()->toArray();
        //check name for database if the data exists then do the command in this
        if ($check_name) {
            $return['status'] = false;
            $return['messages'] ='(ticket Must Be unique)';
            $return['data'] =[];
        }else{
        $dataSession = \Session::get('auth');
        $ticket = Ticket::find($data['id_ticket']);
        $ticket->name_ticket =$data['name_ticket'];
        $ticket->capacity_ticket = $data['capacity_ticket'];
        $ticket->id_event =$data['id_event'];
        $ticket->date_start_ticket =date("Y-m-d H:i:s",strtotime($data['date_start_ticket']));
        $ticket->date_end_ticket =date("Y-m-d H:i:s",strtotime($data['date_end_ticket']));
        $ticket->created_at =date('Y-m-d H:i:s');
        $ticket->updated_at = date('Y-m-d H:i:s');
        $ticket->update();

        $return['status'] = true;
        $return['messages'] ='SUCCSESS';
        $return['data'] =[];
        }
        return $return;
    }
    //this is process create table ticket
    public function create($data){
        //get data ticket where name_ticket submissions from
        $check_name = Ticket::where('name_ticket',Input::get('name_ticket'))->get()->toArray();
        //check name for database if the data exists then do the command in this
        if ($check_name) {
            $return['status'] = false;
            $return['messages'] ='(ticket Must Be unique)';
            $return['data'] =[];
        }else{
        $data['date_start_ticket'] = date("Y-m-d H:i:s", strtotime($data['date_start_ticket']));
        $data['date_end_ticket'] = date("Y-m-d H:i:s", strtotime($data['date_end_ticket']));
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $query=Ticket::create($data);

        $return['status'] = true;
        $return['messages'] ='SUCCSESS';
        $return['data'] =[];
        }
        return $return;
    }

}

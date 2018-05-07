<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\PayUservice\Exception;
use App\Models\Transactions;
use App\Models\Ticket;
use Response;
use DB;
use URL;


/**
 * Handle Transaction
 *
 * @author akbar.agustin55@gmail.com <akbar.agustin55@gmail.com>
 */

class transactionController extends Controller
{
    
    public function index()
    {
         //get data event where Name event submissions from
        return view ('admin/transaction');
    }
    public function indexAjax()
    {
        $draw=$_REQUEST['draw'];
        $length=$_REQUEST['length'];
        $start=$_REQUEST['start'];
        $search=$_REQUEST['search']["value"];
        // ======= count ===== //
        $total=Transactions::count();
        // ======= count ===== //
        $output=array();
        $output['draw']=$draw;
        $output['recordsTotal']=$output['recordsFiltered']=$total;
        $output['data']=array();
        $query = Transactions::getAll();
        $list = [];
        $no = 1;
        foreach ($query as $key => $row) {
            $json['no'] = $no;
            $json['id_ticket'] = $row->id_ticket;
            $json['name_event'] = $row->name_event;
            $json['name_location'] = $row->name_location;
            $json['name_ticket'] = $row->name_ticket;
            $json['capacity_ticket'] = $row->capacity_ticket;
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
        DB::beginTransaction();
        try {
        //get id ticket
        $id_ticket =Input::get('id_ticket');
        //Update ticket where id ticket
        $ticket = Ticket::find($id_ticket);
        $ticket->capacity_ticket =  $ticket->capacity_ticket - 1;
        if ($ticket->capacity_ticket >=  0) {
         $ticket->updated_at = date('Y-m-d H:i:s');
         $ticket->update();
        }else{
            DB::rollback();
            $json['status'] = false;
            $json['messages'] = 'Failed Capacity Full';
            $json['data'] = [];
            return Response::json($json);
        }
        $id_user = \Session::get('auth');
        //create Transaction ticket
        $data['id_ticket'] = $id_ticket;
        $data['id_user'] = $id_user['id_user'];
        $data['created_at'] = date("Y-m-d H:i:s");
        $data['updated_at'] = date("Y-m-d H:i:s");
        $transaction = Transactions::create($data);
            DB::commit();
            $json['status'] = true;
            $json['messages'] = 'Success';
            $json['data'] = $data;
            // all good
            } catch (\Exception $e) {
            DB::rollback();
            $json['status'] = false;
            $json['messages'] = 'Failed';
            $json['data'] = [];
            // something went wrong
            }
        //send view with data
        return Response::json($json);
    }
    

}

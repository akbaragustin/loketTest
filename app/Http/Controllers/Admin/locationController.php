<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\PayUservice\Exception;
use App\Models\Location;
use Response;
use URL;

/**
 * Handle event location
 *
 * @author akbar.agustin55@gmail.com <akbar.agustin55@gmail.com>
 */

class locationController extends Controller
{
    
    public function index()
    {
        return view ('admin/location');
    }
    public function save()
    {
        //this is valdate for laravel
        $rules=[
            'name_location'=>'required',
        ];
        //this is massages if checked validate true
        $messages=[
            'name_location.required'=>'please enter your name location',      
        ];
        // if data NULL do the in this
        $validator=Validator::make(Input::all(), $rules, $messages);
                if ($validator->passes()) {
                    //get Data session for creator
                    if (!empty(Input::get('id_location'))) {
                        //this is update location
                    $return = $this->update(Input::all());
                    }else {
                        //create data location
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
        $listJabatan = new Location;
        // ======= count ===== //
        $total=Location::count();
        // ======= count ===== //
        $output=array();
        $output['draw']=$draw;
        $output['recordsTotal']=$output['recordsFiltered']=$total;
        $output['data']=array();
        $query = Location::getAll();

        $list = [];
        $no = 1;
        foreach ($query as $key => $row) {
            $json['no'] = $no;
            $json['id_location'] = $row->id_location;
            $json['name_location'] = $row->name_location;
            $json['address_location'] = $row->address_location;
            $json['city_location'] = $row->city_location;
            $json['state_location'] = $row->state_location;
            $json['created'] = date('d-m-Y', strtotime($row->created_at));
            $list[] = $json;
            $no++;
        }

        $output['data']  = $list;
        echo json_encode($output);
    }

    public function delete($id_location)
    {
        try {
            $location = Location::find($id_location);
            $location->delete();
        } catch (\Exception $e) {
            \Session::flash('DeleteFails', 'this data is used in other tables');
            return \Redirect::to(route('location.index'));
        }

        \Session::flash('DeleteSucces', 'SUCCESS');
        return \Redirect::to(route('location.index'));
    }

    public function edit()
    {
        //get id location
        $id_location =Input::get('id_location');
        //get location where id location
        $edit = Location::where('id_location', $id_location)->get();
        // this is declaration for data
        $data   = [];
        foreach ($edit as $key => $value) {
            $data['name_location'] = $value->name_location;
            $data['address_location'] = $value->address_location;
            $data['city_location'] = $value->city_location;
            $data['state_location'] = $value->state_location;
            $data['id_location'] = $value->id_location;
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
    // this is process update for table location
    public function update($data)
    {
      
        //get data Location where Name Location submissions from
        $check_name = Location::where('name_location','=',Input::get('name_location'))->where('id_location','!=',Input::get('id_location'))->get()->toArray();
        //check name for database if the data exists then do the command in this
        if ($check_name) {
            $return['status'] = false;
            $return['messages'] ='(Location Must Be unique)';
            $return['data'] =[];
        }else{
        $dataSession = \Session::get('auth');
        $location = Location::find($data['id_location']);
        $location->name_location =$data['name_location'];
        $location->address_location =$data['address_location'];
        $location->city_location =$data['city_location'];
        $location->state_location =$data['state_location'];
        $location->created_at =date('Y-m-d H:i:s');
        $location->updated_at = date('Y-m-d H:i:s');
        $location->update();

        $return['status'] = true;
        $return['messages'] ='SUCCSESS';
        $return['data'] =[];
        }
        return $return;
    }
    //this is process create table location
    public function create($data)
    {
        //get data location where name_location submissions from
        $check_name = Location::where('name_location',Input::get('name_location'))->get()->toArray();
        //check name for database if the data exists then do the command in this
        if ($check_name) {
            $return['status'] = false;
            $return['messages'] ='(Location Must Be unique)';
            $return['data'] =[];
        }else{
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $query=Location::create($data);

        $return['status'] = true;
        $return['messages'] ='SUCCSESS';
        $return['data'] =[];
        }
        return $return;
    }

}

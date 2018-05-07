<?php namespace App\Http\Controllers;

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

class frontendController extends Controller
{
    public function index($id_event)
    {
        //get event where id event
        $data['event'] = Event::where('id_event', $id_event)->get()->toArray();
        return view ('frontend/event',$data);
    }
  
}

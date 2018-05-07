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
use Session;

/**
 * Handle Login With twitter or login on web default
 *
 * @author akbar.agustin55@gmail.com <akbar.agustin55@gmail.com>
 */

class dashboardController extends Controller
{ 
    public function index() 
    {
       
        return view ('admin.landingAdmin');
    }

    public function logout() 
    {
        session::forget('user_id');
        session::forget('user_name');
        session::forget('auth');
        return redirect(route('landingLogin.index'));
    }

}
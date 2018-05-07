<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\PayUservice\Exception;
use App\Models\Event;
use App\Models\Location;
use App\Models\Users;
use Response;
use URL;
use Abraham\TwitterOAuth\TwitterOAuth;
use Session;

/**
 * Handle Login With twitter or login on web default
 *
 * @author akbar.agustin55@gmail.com <akbar.agustin55@gmail.com>
 */

class loginController extends Controller
{   

    /** For Landing Page Login */
    public function index()
    {
        return view ('frontend.login');
    }

    /** 
     * Do login with twiiter 
     * use liblary Abraham\TwitterOAuth\TwitterOAuth
     */
    public function twitterLogin() 
    {
        $twitteroauth = new TwitterOAuth(config("twitter.consumer_key"), config("twitter.consumer_secret"));
        
        // request token of application
        $request_token = $twitteroauth->oauth(
            'oauth/request_token', [
                'oauth_callback' => config("twitter.url_callback")
            ]
        );

        // throw exception if something gone wrong
        if($twitteroauth->getLastHttpCode() != 200) {
            throw new \Exception('There was a problem performing this request');
        }
        
        // save token of application to session
        session(['oauth_token' => $request_token['oauth_token']]);
        session(['oauth_token_secret' => $request_token['oauth_token_secret']]);

        $url = $twitteroauth->url(
            'oauth/authorize', [
                'oauth_token' => $request_token['oauth_token']
            ]
        );
        return redirect($url);
    }

    /** 
     * Do login with twiiter for callback process from twitter
     * use liblary Abraham\TwitterOAuth\TwitterOAuth
     */
    public function twitterCallback() {
        $oauth_verifier = filter_input(INPUT_GET, 'oauth_verifier');
          
        if (empty($oauth_verifier) ||
            empty(session::get('oauth_token')) ||
            empty(session::get('oauth_token_secret'))
        ) {
            // something's missing, go and login again
            return redirect(config('twitter.url_login'));
        }
       
        $connection = new TwitterOAuth(
            config('twitter.consumer_key'),
            config('twitter.consumer_secret'),
            session::get('oauth_token'),
            session::get('oauth_token_secret')
        );
       
        try {
           // request user token
            $token = $connection->oauth(
                'oauth/access_token', [
                    'oauth_verifier' => $oauth_verifier
                ]
            );
        } catch (Exception $e) {
            return redirect(config('twitter.url_login'));
        }

        if (empty($token['user_id']) && empty($token['screen_name'])) 
        {
            // something's missing, go and login again
            return redirect(config('twitter.url_login'));
        } 

        session(['auth' => $token]);
        $data['username'] = $token['screen_name'];
        $data['created_at'] = date("Y-m-d H:i:s");
        $data['updated_at'] = date("Y-m-d H:i:s");
        $getUser = Users::where("username",$data['username'])->get()->toArray();
       
        if (empty($getUser)) {
            $query = Users::create($data);     
            $token['id_user'] = $query->id; 
        }else{
            $token['id_user'] = $getUser[0]['id'];
        }
        
        session(['auth' => $token]);
        // $twitter = new TwitterOAuth(
        //     config('twitter.consumer_key'),
        //     config('twitter.consumer_secret'),
        //     $token['oauth_token'],
        //     $token['oauth_token_secret']
        // );
        // $status = $twitter->post(
        //     "statuses/update", [
        //         "status" => "Thank you @nedavayruby, now I know how to authenticate users with Twitter because of this tutorial https://goo.gl/N2Znbb"
        //     ]
        // );
        // do something's after success get user_id and screen name
        return redirect(route('dashboardController.index'));

    }



}
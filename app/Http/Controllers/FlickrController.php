<?php

namespace App\Http\Controllers;


use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;


class FlickrController extends Controller
{

    private  $client;
    private $api_key = "efcb819f8237668fbae3bc2ab8b2a1fc";
    private $secret = "92b6bcb43f09b974";
    private $callback_url = "/get_access_token";
    private $phpFlickr;

    public function getReadFlickr(bool $api = false){
        if(!is_null(session('read_oauth_token'))){
            $f = new phpFlickr($this->api_key, $this->secret);
            $f->setOauthToken(session('read_oauth_token'), session('read_oauth_secret'));
            return $f;
        }

        if(is_null(session('read_oauth_token')) && request()->has('oauth_verifier')){
            $f = new phpFlickr($this->api_key, $this->secret);
            $f->getAccessToken();
            $OauthToken = $f->getOauthToken();
            $OauthSecretToken = $f->getOauthSecretToken();
            session(['read_oauth_token' =>$OauthToken]);
            session(['read_oauth_secret' => $OauthSecretToken]);

            return $f;
        }

        $f = new phpFlickr($this->api_key, $this->secret);
        $authorize_url = $f->getRequestToken(url()->current(),'read');
        if($api){
           return [
               'need_redirect' => true,
                'url' => $authorize_url
           ];
        }
        return Redirect::away($authorize_url)->send();
    }

    public function setWriteOauthToken(Request $request){
        if(is_null(session('write_oauth_token')) && request()->has('oauth_verifier')){
            $f = new phpFlickr($this->api_key, $this->secret);
            $f->getAccessToken();
            $OauthToken = $f->getOauthToken();
            $OauthSecretToken = $f->getOauthSecretToken();
            session(['write_oauth_token' =>$OauthToken]);
            session(['write_oauth_secret' => $OauthSecretToken]);

        }
        return redirect(url('my_flickr'));
    }

    public function getWriteFlickr($callback = null ,$api = false){
        if(!is_null(session('write_oauth_token'))){
            $f = new phpFlickr($this->api_key, $this->secret, true);
            $f->setOauthToken(session('write_oauth_token'), session('write_oauth_secret'));
            return $f;
        }

        $f = new phpFlickr($this->api_key, $this->secret);
        if(!is_null($callback)){
               $collback_flikc = url($callback);
        }else{
            $collback_flikc = url()->current();
        }
        $authorize_url = $f->getRequestToken($collback_flikc,'write', true);
        if($api){
            return [
                'need_redirect' => true,
                'url' => $authorize_url
            ];
        }
        return Redirect::away($authorize_url)->send();
    }

    public function logout(){
        request()->session()->forget('read_oauth_token');
        request()->session()->forget('read_oauth_secret');
        request()->session()->forget('write_oauth_token');
        request()->session()->forget('write_oauth_secret');

        return redirect('/');
    }

    public function myFlickrView(Request $request){

       $f = $this->getReadFlickr();
       $user_id = $f->test_login()['id'];
       $response = $f->people_getPhotos($user_id);

        $photos = [];

        if($response['stat'] == 'ok'){
            $photos = $response['photos']['photo'];
        }

        return view('flickr/my_flickr', compact('photos'));
    }


   public function showFlickerImageInfo(Request $request){
       $f = $this->getReadFlickr();
       $f->test_login();
       $response = $f->photos_getInfo($request->photo_id);

       return $response;
   }

    public function setFlickerImageInfo(Request $request)
    {
        $f = $this->getWriteFlickr('/set_write_oauth_token',true);

        if(is_array($f)){
            return [
                'need_redirect' => 'true',
                'url' => $f['url'],
            ];
        }
        $f->test_login();
        $response = $f->photos_setMeta($request->photo_info['id'],$request->photo_info['title'],$request->photo_info['description'] );
        if($response){ return [ 'ok' => true ];
        }else{
            return [ 'ok' => false ];
        }

    }

    public function flickrImageUpload(Request $request){

        $f = $this->getWriteFlickr('/set_write_oauth_token',true);
        $f->test_login();
        $asd = $f->people_getUploadStatus();

        if(is_array($f)){
            return [
                'need_redirect' => 'true',
                'url' => $f['url'],
            ];
        }

        $id_flickr = $f->sync_upload('C:\1.jpg', $request->title, $request->description);

    }



}

<?php

namespace Tests\Feature\Unit;


use App\Http\Controllers\FlickrController;
use App\Http\Controllers\phpFlickr;
use GuzzleHttp\Client;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FlickrTest extends TestCase
{
    private $api_key = "efcb819f8237668fbae3bc2ab8b2a1fc";
    private $secret = "92b6bcb43f09b974";

    public function setUp(){
        parent::setUp();
        file_put_contents(storage_path('logs\laravel.log'), "");

    }

    public function testgetRequestToken(){
        $ctrl = new FlickrController();
        $oauth_token = $ctrl->getRequestToken();
        dd($oauth_token);
    }


    public function AAAtestRequestToken(){

        $request_token_url = "https://www.flickr.com/services/oauth/request_token";
        $nonce = '89601180';
        $timestamp = gmdate('U');
        $cc_key = $this->api_key;
        $cc_secret = $this->secret;
        $sig_method = "HMAC-SHA1";
        $oversion = "1.0";
        $callbackURL = url()->current();

        $basestring = "oauth_callback=".urlencode($callbackURL).
            "&oauth_consumer_key=".$cc_key.
            "&oauth_nonce=".$nonce
            ."&oauth_signature_method=".$sig_method
            ."&oauth_timestamp=".$timestamp
            ."&oauth_version=".$oversion;

        $basestring = "GET&".urlencode($request_token_url)."&".urlencode($basestring);

        $hashkey = $cc_secret."&";
        $oauth_signature = base64_encode( hash_hmac('sha1', $basestring, $hashkey, true) );


        $fields = array(
            'oauth_nonce'=>$nonce,
            'oauth_timestamp'=>$timestamp,
            'oauth_consumer_key'=>$cc_key,
            'oauth_signature_method'=>$sig_method,
            'oauth_version'=>$oversion,
            'oauth_signature'=>$oauth_signature,
            'oauth_callback'=>$callbackURL
        );

        $fields_string = "";
        foreach($fields as $key=>$value){
            $fields_string .= "$key=".urlencode($value)."&";
        }
        $fields_string = rtrim($fields_string,'&');

        $url = $request_token_url."?".$fields_string;


        $this->client = new Client();
        $guzzleResponse = $this->client->get($url);
        $content = $guzzleResponse->getBody()->getContents();
        parse_str($content, $resp_array);

        $this->assertTrue((bool)$resp_array['oauth_callback_confirmed']);

    }

}

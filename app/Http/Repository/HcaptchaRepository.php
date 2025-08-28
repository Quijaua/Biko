<?php

namespace App\Http\Repository;

/*use Illuminate\Http\Request;*/
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class HcaptchaRepository
{
  public function validate($challenge)
  {
    if (config('app.env') === 'develop' || config('app.env') === 'local') {
      return true;
    }

    $secret = config('services.hcaptcha.secret');

    //dd($secret);
    //dd($challenge);

    $client = new Client([
        'base_uri' => 'https://hcaptcha.com',
    ]);

    $response = $client->request('POST', '/siteverify', [
       'form_params' => [
            'secret'    =>  $secret,
            'response'  =>  $challenge
       ]
    ]);

    $body = $response->getBody();
    $arr_body = json_decode($body);
    if( $arr_body->success ) {
      return true;
    };
    return false;
    /*dd($arr_body->success);*/
  }
}

<?php

namespace common\components\helpers;
use Yii;

class SmsHelper
{
  /*public function generateOTP()
  {
  	return "1233";
  }*/

  public function generateOTP()
  {
    /*$string = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $string_shuffled = str_shuffle($string);
    $password = substr($string_shuffled, 1, 4);
    return $password;*/
    //return strtoupper(substr(md5(uniqid()), 0, 4));
    return mt_rand(1000,9999);
  }

	public function sendSMS($to, $message) {
        $fields = array(
            'to' => $to,
            'message' => urlencode($message),
            'smsContentType'=>'English',
            'senderId'=>'MALANG',
            'routeId'=>1
            );
        return $this->sendMessage($fields);
    }

    // function makes curl request to firebase servers
    private function sendMessage($fields) {

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "http://msg.msgclub.net/rest/services/sendSMS/sendGroupSms?AUTH_KEY=".Yii::$app->smsgateway->authkey."&message=".$fields['message']."&senderId=".$fields['senderId']."&routeId=".$fields['routeId']."&mobileNos=".$fields['to']."&smsContentType=".$fields['smsContentType'],
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            ),
          ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        }
        else {
            return $response;
        }
    }
}
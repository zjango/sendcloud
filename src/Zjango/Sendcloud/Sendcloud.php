<?php
namespace Zjango\Sendcloud;

class Sendcloud{

    public function send($to = null,$subject = null,$content = null)
    {
        if($res = self::checkData($to,$subject,$content)){
            return $res;
        }else{
            return self::doSend($to,$subject,$content);
        }
    }

    public function checkData($to,$subject,$content)
    {
        if(!preg_match("/^[_.0-9a-z-]+@([0-9a-z][0-9a-z-]+.)+[a-z]{2,3}$/",$to)){
            return json_encode(['message'=>'error','errors'=>'wrong address']);
        }

        if(empty($subject) or empty($content)){
            return json_encode(['message'=>'error','errors'=>'wrong subject or content']);
        }
        return 0;
    }

    public function doSend($to,$subject,$content)
    {
        $url = 'http://sendcloud.sohu.com/webapi/mail.send.json';
        $param = array(
            'api_user' => SENDCLOUD_API_USER,
            'api_key' => SENDCLOUD_API_KEY,
            'from' => SENDCLOUD_FROM_ADDR,
            'fromname' => SENDCLOUD_FROM_NAME,
            'to' => $to,
            'subject' => $subject,
            'html' => $content
        );
        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => "Content-type: application/x-www-form-urlencoded ",
                'content' => http_build_query($param)
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return $result;
    }
    
}

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
        $sendcloud_config=\Config::get('mail.sendcloud');
        $url = 'http://sendcloud.sohu.com/webapi/mail.send.json';
        $param = array(
            'api_user' => $sendcloud_config['api_user'],
            'api_key' => $sendcloud_config['api_key'],
            'from' => $sendcloud_config['from_addr'],
            'fromname' => $sendcloud_config['from_name'],
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

<?php
namespace Zjango\Sendcloud;

class Sendcloud{

    public function send($to = array(),$subject = null,$content = null,$file=null)
    {
        if(!is_array($to)){
            $to=array($to);
        }
        if($res = self::checkData($to,$subject,$content)){
            return $res;
        }else{
            return self::doSend($to,$subject,$content,$file);
        }
    }

    public function encodeEmails($emails)
    {
        return implode(';',$emails);
    }

    public function checkData($to,$subject,$content)
    {
        if(empty($to))
        {
            return json_encode(['message'=>'error','errors'=>'wrong address']);
        }
        foreach($to as $email)
        {
            if(!preg_match("/^[_.0-9a-z-]+@([0-9a-z][0-9a-z-]+.)+[a-z]{2,3}$/",$email)){
                return json_encode(['message'=>'error','errors'=>'wrong address']);
            }
        }

        if(empty($subject) or empty($content)){
            return json_encode(['message'=>'error','errors'=>'wrong subject or content']);
        }
        return 0;
    }

    public function doSend($to,$subject,$content,$filePath)
    {
        $sendcloud_config=\Config::get('mail.sendcloud');
        $ch = curl_init();
        $param=array(
            'api_user' => $sendcloud_config['api_user'], # 使用api_user和api_key进行验证
            'api_key' => $sendcloud_config['api_key'],
            'from' => $sendcloud_config['from_addr'], # 发信人，用正确邮件地址替代
            'fromname' => $sendcloud_config['from_name'],
            'to' =>self::encodeEmails($to), # 收件人地址，用正确邮件地址替代，多个地址用';'分隔
            'subject' => $subject,
            'html' => $content
        );
        if(!is_null($filePath))
        {
            if (class_exists('\CURLFile')) {
                curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);
            } else {
                if (defined('CURLOPT_SAFE_UPLOAD')) {
                    curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
                }
            }

            if (class_exists('\CURLFile')) {
                $files = new \CURLFile(realpath($filePath));
                $files->postname=basename($filePath);
            } else {
                $files = '@' . realpath($filePath).';filename='.basename($filePath);
            }
            $param['files']=$files;
        }

        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_URL, 'http://sendcloud.sohu.com/webapi/mail.send.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS,$param);

        $result = curl_exec($ch);
        if($result === false) {
            return json_encode(['message'=>'error','errors'=>'Request error!']);
        }
        curl_close($ch);
        return $result;
    }
}

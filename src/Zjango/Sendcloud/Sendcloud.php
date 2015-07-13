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

    public function doSend($to,$subject,$content,$files='')
    {
        $sendcloud_config=\Config::get('mail.sendcloud');
        $ch = curl_init();
        if(!empty($files))
        {
            if (class_exists('\CURLFile')) {
                curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);
            } else {
                if (defined('CURLOPT_SAFE_UPLOAD')) {
                    curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
                }
            }

            if (class_exists('\CURLFile')) {
                $files = new \CURLFile(realpath($files));
            } else {
                $files = '@' . realpath($files);
            }          
        }

        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_URL, 'http://sendcloud.sohu.com/webapi/mail.send.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
                                'api_user' => $sendcloud_config['api_user'], # 使用api_user和api_key进行验证
                                'api_key' => $sendcloud_config['api_key'],
                                'from' => $sendcloud_config['from_addr'], # 发信人，用正确邮件地址替代
                                'fromname' => $sendcloud_config['from_name'],
                                'to' => $to, # 收件人地址，用正确邮件地址替代，多个地址用';'分隔
                                'subject' => $subject,
                                'html' => $content,
                                'files' => $files
                            ));

        $result = curl_exec($ch);
        if($result === false) {
            return json_encode(['message'=>'error','errors'=>'Request error!']);
        }
        curl_close($ch);
        return $result;
    }
}

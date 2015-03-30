## sendcloud for laravel

---
#Use
发送文本
```php
Sendcloud::send('test@test.com','来自SendCloud的第一封邮件!','你太棒了！你已成功的从SendCloud发送了一封测试邮件，接下来快登录前台去完善账户信息吧！');
```
发送视图
```php
Sendcloud::send('test@test.com','来自SendCloud的第一封邮件!',(string)(View::make('test');
```
#Installation

Require this package in your `composer.json` and update composer. This will download the package.
```php
"zjango/sendcloud":"dev-master"
```

After updating composer, add the ServiceProvider to the providers array in `app/config/app.php`


```php
'Zjango\Sendcloud\SendcloudServiceProvider',
```

You can use the facade for shorter code. Add this to your aliases:

```php
'Sendcloud' 		=> 'Zjango\Sendcloud\Facades\SendcloudClass',
```
Add config 

update file app/config/mail.php
add config
```php
	'sendcloud'=>array(	
		'api_user'=>'Sendcloud的api_user',		
		'api_key'=>'Sendcloud的api_key',
		'from_addr'=>'发信地址',
		'from_name'=>'服务',
	),
```
# QA
Q:这个doSend($to,$subject,$content)中$content能否是一个view呢

A:需要(string)转换一下.另外邮件发送函数为send. 发送View视图实例为
```php
Sendcloud::send('test@test.com','来自SendCloud的第一封邮件!',(string)(View::make('test');
```
# License

This package is licensed under LGPL. You are free to use it in personal and commercial projects. The code can be forked and modified, but the original copyright author should always be included!

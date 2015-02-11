## sendcloud for laravel

---
#Use

```php
Sendcloud::send('test@test.com','来自SendCloud的第一封邮件!','你太棒了！你已成功的从SendCloud发送了一封测试邮件，接下来快登录前台去完善账户信息吧！');
```

#Installation

Require this package in your `composer.json` and update composer. This will download the package and PHPExcel of PHPOffice.

```php
"zjango/sendcloud":"dev-master"
```

After updating composer, add the ServiceProvider to the providers array in `app/config/app.php`


```php
'Zjango\Sendcloud\SendcloudServiceProvider',
```

You can use the facade for shorter code. Add this to your aliases:

```php
		'Sendcloud' 			=> 'Zjango\Sendcloud\Facades\SendcloudClass',
```
Update config 

update config in src/config/sendcloud.php

# License

This package is licensed under LGPL. You are free to use it in personal and commercial projects. The code can be forked and modified, but the original copyright author should always be included!
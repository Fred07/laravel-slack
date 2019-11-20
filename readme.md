[![Build Status](https://travis-ci.com/Fred07/laravel-slack.svg?branch=master)](https://travis-ci.com/Fred07/laravel-slack)

# slack service provider

本專案以 service provider 方式

提供 `laravel/lumen` 專案操作 slack 物件 

傳遞 `錯誤/訊息` 至 slack channel

## 安裝

執行 composer 安裝，在根目錄下指令

```
composer require fred/laravel-slack
```

`laravel/lumen` 專案下設定 `SlackServiceProvider`

[lumen] - 在 `/bootstrap/app.php` 加入

```php
$app->register(Fred\SlackService\SlackServiceProvider::class);
```
[laravel] - 支援 laravel auto discovery

若 laravel 版本不支援則需手動加入 `/config/app.php`

```php
'providers' => [
    //...
    
    Fred\SlackService\SlackServiceProvider::class,
];
```

## 套用設定檔

[laravel] - 在專案目錄下透過 artisan 指令

```sh
$ php artisan vendor:publish --provider="Fred\SlackService\SlackServiceProvider" --tag="config"
```

[lumen] - 在 `/config` 資料夾下放入 `slack.php`

--- 

到 `/config/slack.php` 設定內容:

```php
return [
    // 可設定多組 client 面對不同的 slack channel 及用途
    // key 值必需做區分
    'clients'   =>  [
        // 'clientName' => []
        // service provider 將綁定名稱為 "slack-{client_name}" 的 instance 在 container 中
        'error-report' => [
            'endpoint' => 'https://hooks.slack.com/services/xxxxxxx',  // slack web hook url
            'channel'  => 'my-test-channel',                           // slack channel
            'username' => 'Error Report'                               // slack messages' user name
        ],
        'custom-name' => [
            // 其他組 slack client 設定
        ],
    ],
];
```

## 使用方式

以下依據上述的註冊範例延伸

基本傳遞訊息:

```php
$slack = app('slack-error-report');
$slack->compose(function (Message $message) {
    $message->setText('slack message sending!');
    return $message;
})->send();
```

透過 `MessageComposer` 套用模板，強化訊息內容

```php
$slack = app('slack-error-report');
$slack->compose(function (Message $message) {
    // 產生 MessageComposer 物件    
    $messageComposer = new Fred\SlackServiceProvider\MessageComposer($message);
    
    // 套用模板所需的參數和值，預設使用 Exception template
    $data = [
        'exceptionContent' => 'Invalid user id',
        'requestContent' => 'https://oobox.com.tw',
        'envContent' => 'testing',
        'timeContent' => Carbon\Carbon::now()->toDateTimeString(),
        'traceContent' => "error trace code",
    ];
    $messageComposer->apply($data);
    return $messageComposer->getMessage();
})->send();
```

**預設模板 (Exception template) 可帶入之變數列表**
- exceptionTitle: 例外標題 (default: Exception)
- exceptionContent: 例外內容
- requestTitle: 請求 url 標題 (default: Request)
- requestContent: 請求 url
- envTitle: 環境標題 (default: Environment)
- envContent: 環境
- timeTitle: 時間標題 (default: Time)
- timeContent: 時間
- traceTitle: code trace 標題 (default: Trace)
- traceContent: code trace

### 自訂模板

欲自訂模板請參考 `slack` payload 文件，範例可參考套件預設的 exception template `/src/templates/ExceptionTemplate.php`

產生 MessageComposer 物件後帶入自訂的模板路徑

```php
// ...

// 產生 MessageComposer 物件    
$messageComposer = new Fred\SlackServiceProvider\MessageComposer($message);

// 帶入自定義的模板路徑
$messageComposer->useTemplate('/path/to/template');

// 後續組成資料
$data = [];
$messageComposer->apply($data);
return $messageComposer->getMessage();

// ...
```

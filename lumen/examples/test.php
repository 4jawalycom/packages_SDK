<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Sms4jawaly\Lumen\Gateway;

// Initialize the client with your API credentials
// قم بتهيئة العميل باستخدام بيانات اعتماد API الخاصة بك
$client = new Gateway(
    'your_api_key',
    'your_api_secret'
);

// With custom options / مع خيارات مخصصة
// $client = new Gateway('your_api_key', 'your_api_secret', [
//     'timeout'  => 60,
//     'base_url' => 'https://api-sms.4jawaly.com/api/v1',
// ]);

// ──────────────────────────────────────────
// Get sender names / جلب أسماء المرسلين
// ──────────────────────────────────────────
echo "\nGetting sender names / جلب أسماء المرسلين:\n";
$senders = $client->getSenders();
print_r($senders);

// ──────────────────────────────────────────
// Get balance / جلب الرصيد
// ──────────────────────────────────────────
echo "\nGetting balance / جلب الرصيد:\n";
$balance = $client->getBalance();
print_r($balance);

// ──────────────────────────────────────────
// Send single SMS / إرسال رسالة واحدة
// ──────────────────────────────────────────
echo "\nSending single SMS / إرسال رسالة واحدة:\n";
$response = $client->sendSms(
    'Test message from 4jawaly / رسالة تجريبية من فورجوالي',
    ['966500000000'],
    '4jawaly'
);
print_r($response);

// ──────────────────────────────────────────
// Send bulk SMS / إرسال رسائل متعددة
// ──────────────────────────────────────────
echo "\nSending bulk SMS / إرسال رسائل متعددة:\n";
$bulkResponse = $client->sendSms(
    'First bulk message / الرسالة الأولى',
    ['966500000001', '966500000002'],
    '4jawaly'
);
print_r($bulkResponse);

// ──────────────────────────────────────────
// Send batch (multiple messages) / إرسال دفعة
// ──────────────────────────────────────────
echo "\nSending batch SMS / إرسال دفعة رسائل:\n";
$batchResponse = $client->sendBatch([
    [
        'text'    => 'رسالة أولى',
        'numbers' => ['966500000001'],
        'sender'  => '4jawaly',
    ],
    [
        'text'    => 'رسالة ثانية',
        'numbers' => ['966500000002', '966500000003'],
        'sender'  => '4jawaly',
    ],
]);
print_r($batchResponse);

// ──────────────────────────────────────────
// Usage in Laravel/Lumen controller
// استخدام في Laravel/Lumen controller
// ──────────────────────────────────────────
echo "\n--- Example controller usage ---\n";
echo <<<'EXAMPLE'

use Sms4jawaly\Lumen\Gateway;

class SmsController extends Controller
{
    private $sms;

    public function __construct(Gateway $sms)
    {
        $this->sms = $sms;
    }

    public function sendMessage()
    {
        $response = $this->sms->sendSms(
            'Your verification code is: 1234',
            ['966500000000'],
            '4jawaly'
        );

        return response()->json($response);
    }
}

EXAMPLE;

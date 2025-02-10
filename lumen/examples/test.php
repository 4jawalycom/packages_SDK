<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Sms4jawaly\Lumen\Gateway;

// Initialize the client with your API credentials
// قم بتهيئة العميل باستخدام بيانات اعتماد API الخاصة بك
// Initialisez le client avec vos identifiants API
// अपने API क्रेडेंशियल्स के साथ क्लाइंट को इनिशियलाइज़ करें
// اپنے API کریڈنشلز کے ساتھ کلائنٹ کو شروع کریں
$client = new Gateway(
    'your_api_key',      // Replace with your API key / استبدل بمفتاح API الخاص بك
    'your_api_secret'    // Replace with your API secret / استبدل بسر API الخاص بك
);

// Get sender names / جلب أسماء المرسلين / Obtenir les noms d'expéditeur
echo "\nGetting sender names / جلب أسماء المرسلين:\n";
$senders = $client->getSenders();
print_r($senders);

// Get balance / جلب الرصيد / Obtenir le solde
echo "\nGetting balance / جلب الرصيد:\n";
$balance = $client->getBalance();
print_r($balance);

// Send single SMS / إرسال رسالة واحدة / Envoyer un SMS unique
echo "\nSending single SMS / إرسال رسالة واحدة:\n";
$response = $client->sendSms(
    'Test message from 4jawaly / رسالة تجريبية من فورجوالي',  // Message text / نص الرسالة
    ['966500000000'],                                         // Recipients list / قائمة المستلمين
    '4jawaly'                                                // Sender name / اسم المرسل
);
print_r($response);

// Send bulk SMS / إرسال رسائل متعددة / Envoyer des SMS en masse
echo "\nSending bulk SMS / إرسال رسائل متعددة:\n";
$bulkResponse = $client->sendSms(
    'First bulk message / الرسالة الأولى',                   // Message text / نص الرسالة
    ['966500000001', '966500000002'],                       // Recipients list / قائمة المستلمين
    '4jawaly'                                               // Sender name / اسم المرسل
);
print_r($bulkResponse);

// Example of how to use in a Laravel/Lumen application
// مثال على كيفية الاستخدام في تطبيق Laravel/Lumen
echo "\nExample usage in Laravel/Lumen application / مثال على الاستخدام في تطبيق Laravel/Lumen:\n";
echo "
// In your controller:
use Sms4jawaly\Lumen\Gateway;

class SmsController extends Controller
{
    private \$sms;

    public function __construct(Gateway \$sms)
    {
        \$this->sms = \$sms;
    }

    public function sendMessage()
    {
        \$response = \$this->sms->sendSms(
            'Your verification code is: 1234',
            ['966500000000'],
            '4jawaly'
        );

        return response()->json(\$response);
    }
}
";

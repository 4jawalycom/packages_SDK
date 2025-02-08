# SMS4Jawaly for Lumen

مكتبة SMS4Jawaly لإطار العمل Lumen

## التثبيت | Installation

```bash
composer require sms4jawaly/lumen
```

## الإعداد | Configuration

أضف بيانات الاعتماد الخاصة بك في ملف `.env`:

Add your credentials to your `.env` file:

```env
SMS4JAWALY_API_KEY=your_api_key
SMS4JAWALY_API_SECRET=your_api_secret
```

قم بإضافة التكوين التالي في ملف `config/services.php`:

Add the following configuration to your `config/services.php`:

```php
'sms4jawaly' => [
    'api_key' => env('SMS4JAWALY_API_KEY'),
    'api_secret' => env('SMS4JAWALY_API_SECRET'),
],
```

قم بتسجيل مزود الخدمة في ملف `bootstrap/app.php`:

Register the service provider in your `bootstrap/app.php`:

```php
$app->register(Sms4jawaly\Lumen\Sms4jawalyServiceProvider::class);
```

## الاستخدام | Usage

### إرسال رسالة SMS | Sending an SMS

```php
use Sms4jawaly\Lumen\Gateway;

$sms = app(Gateway::class);

$response = $sms->sendSms(
    'رسالة تجريبية من فورجوالي', // نص الرسالة | Message text
    ['966500000000'],            // أرقام المستلمين | Recipient numbers
    '4jawaly'                    // اسم المرسل | Sender name
);
```

### جلب الرصيد | Get Balance

```php
$balance = $sms->getBalance();
```

### جلب أسماء المرسلين | Get Sender Names

```php
$senders = $sms->getSenders();
```

## المساهمة | Contributing

نرحب بمساهماتكم! يرجى إرسال pull request.

Contributions are welcome! Please submit a pull request.

## الترخيص | License

هذه المكتبة مرخصة تحت رخصة MIT.

This library is licensed under the MIT License.

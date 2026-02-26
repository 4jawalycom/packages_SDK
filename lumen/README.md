# SMS4Jawaly for Lumen & Laravel

مكتبة SMS4Jawaly لإرسال رسائل SMS و WhatsApp عبر إطار العمل Lumen و Laravel

## المتطلبات | Requirements

| الحزمة | الإصدارات المدعومة |
|---|---|
| PHP | 7.3, 7.4, 8.0, 8.1, 8.2, 8.3, 8.4 |
| Laravel | 8.x, 9.x, 10.x, 11.x, 12.x |
| Lumen | 8.x, 9.x, 10.x |
| Guzzle | 7.x |

> **ملاحظة:** تم إيقاف Lumen بعد الإصدار 10. للمشاريع الجديدة يُنصح باستخدام Laravel.

## التثبيت | Installation

```bash
composer require sms4jawaly/lumen
```

## الإعداد | Configuration

### Laravel 8 - 12

#### 1. متغيرات البيئة | Environment Variables

أضف بيانات الاعتماد في ملف `.env`:

```env
# SMS
SMS4JAWALY_API_KEY=your_api_key
SMS4JAWALY_API_SECRET=your_api_secret

# WhatsApp
SMS4JAWALY_WA_APP_KEY=your_wa_app_key
SMS4JAWALY_WA_API_SECRET=your_wa_api_secret
SMS4JAWALY_WA_PROJECT_ID=your_wa_project_id
```

#### 2. نشر ملف الإعدادات (اختياري) | Publish Config (optional)

```bash
php artisan vendor:publish --tag=sms4jawaly-config
```

> **Laravel 11+:** يتم اكتشاف مزود الخدمة تلقائياً (Auto-Discovery). لا حاجة لتسجيله يدوياً.

---

### Lumen 8 - 10

#### 1. متغيرات البيئة | Environment Variables

نفس المتغيرات أعلاه في ملف `.env`.

#### 2. تسجيل مزود الخدمة | Register Service Provider

أضف في ملف `bootstrap/app.php`:

```php
$app->configure('sms4jawaly');
$app->register(Sms4jawaly\Lumen\Sms4jawalyServiceProvider::class);
```

---

### التوافق مع الإعداد القديم | Legacy Configuration

إذا كنت تستخدم الطريقة القديمة عبر `config/services.php`، فهي لا تزال مدعومة لـ SMS:

```php
// config/services.php
'sms4jawaly' => [
    'api_key' => env('SMS4JAWALY_API_KEY'),
    'api_secret' => env('SMS4JAWALY_API_SECRET'),
],
```

---

## استخدام SMS | SMS Usage

### إرسال رسالة SMS | Send SMS

```php
use Sms4jawaly\Lumen\Gateway;

$sms = app(Gateway::class);

$response = $sms->sendSms(
    'رسالة تجريبية من فورجوالي',
    ['966500000000'],
    '4jawaly'
);
```

### إرسال رسائل متعددة (Batch) | Send Batch SMS

```php
$response = $sms->sendBatch([
    [
        'text'    => 'الرسالة الأولى',
        'numbers' => ['966500000001', '966500000002'],
        'sender'  => '4jawaly',
    ],
    [
        'text'    => 'الرسالة الثانية',
        'numbers' => ['966500000003'],
        'sender'  => '4jawaly',
    ],
]);
```

### جلب الرصيد | Get Balance

```php
$balance = $sms->getBalance();
```

### جلب أسماء المرسلين | Get Sender Names

```php
$senders = $sms->getSenders();
```

---

## استخدام WhatsApp | WhatsApp Usage

### الأنواع المدعومة | Supported Message Types

| # | النوع | الدالة |
|---|---|---|
| 1 | رسالة نصية | `sendText()` |
| 2 | أزرار تفاعلية (حتى 3) | `sendButtons()` |
| 3 | قائمة تفاعلية (حتى 10 عناصر) | `sendList()` |
| 4 | صورة | `sendImage()` |
| 5 | فيديو | `sendVideo()` |
| 6 | ملف صوتي | `sendAudio()` |
| 7 | مستند | `sendDocument()` |
| 8 | موقع جغرافي | `sendLocation()` |
| 9 | جهة اتصال | `sendContact()` |

### 1. رسالة نصية | Text

```php
use Sms4jawaly\Lumen\WhatsAppGateway;

$wa = app(WhatsAppGateway::class);

$response = $wa->sendText('966500000000', 'مرحباً من 4Jawaly!');
```

### 2. أزرار تفاعلية | Interactive Buttons

```php
$response = $wa->sendButtons('966500000000', 'اختر أحد الخيارات', [
    ['id' => 'btn_yes',  'title' => 'نعم'],
    ['id' => 'btn_no',   'title' => 'لا'],
    ['id' => 'btn_help', 'title' => 'مساعدة'],
]);
```

### 3. قائمة تفاعلية | Interactive List

```php
$response = $wa->sendList(
    '966500000000',
    'قائمة الخدمات',                          // header
    'اختر الخدمة المطلوبة من القائمة أدناه',  // body
    '4Jawaly Services',                       // footer
    'عرض القائمة',                            // button label
    [
        [
            'title' => 'الخدمات الأساسية',
            'rows'  => [
                ['id' => 'svc_sms',      'title' => 'خدمة SMS',    'description' => 'إرسال رسائل نصية'],
                ['id' => 'svc_whatsapp', 'title' => 'خدمة واتساب', 'description' => 'رسائل تفاعلية'],
            ],
        ],
        [
            'title' => 'الدعم',
            'rows'  => [
                ['id' => 'support', 'title' => 'فتح تذكرة', 'description' => 'تواصل مع الدعم'],
            ],
        ],
    ]
);
```

### 4. صورة | Image

```php
$response = $wa->sendImage('966500000000', 'https://example.com/image.jpg', 'وصف الصورة');
```

### 5. فيديو | Video

```php
$response = $wa->sendVideo('966500000000', 'https://example.com/video.mp4', 'وصف الفيديو');
```

### 6. ملف صوتي | Audio

```php
$response = $wa->sendAudio('966500000000', 'https://example.com/audio.mp3');
```

### 7. مستند | Document

```php
$response = $wa->sendDocument(
    '966500000000',
    'https://example.com/file.pdf',
    'وصف المستند',    // caption (optional)
    'invoice.pdf'     // filename (optional)
);
```

### 8. موقع جغرافي | Location

```php
$response = $wa->sendLocation(
    '966500000000',
    24.7136,                    // lat
    46.6753,                    // lng
    'Riyadh, Saudi Arabia',     // address
    'المكتب الرئيسي'            // name (optional)
);
```

### 9. جهة اتصال | Contact

```php
$response = $wa->sendContact('966500000000', [
    [
        'name'   => [
            'formatted_name' => 'Ahmed Ali',
            'first_name'     => 'Ahmed',
            'last_name'      => 'Ali',
        ],
        'phones' => [
            ['phone' => '+966501234567', 'type' => 'CELL'],
        ],
    ],
]);
```

---

## الاستخدام المباشر بدون Framework | Standalone Usage

### SMS

```php
use Sms4jawaly\Lumen\Gateway;

$sms = new Gateway('your_api_key', 'your_api_secret');
$response = $sms->sendSms('مرحباً', ['966500000000'], '4jawaly');
```

### WhatsApp

```php
use Sms4jawaly\Lumen\WhatsAppGateway;

$wa = new WhatsAppGateway('your_app_key', 'your_api_secret', 'your_project_id');
$response = $wa->sendText('966500000000', 'مرحباً من واتساب!');
```

### خيارات متقدمة | Advanced Options

```php
$wa = new WhatsAppGateway('app_key', 'api_secret', 'project_id', [
    'timeout' => 60,
]);
```

---

## مثال Controller كامل | Full Controller Example

```php
use Sms4jawaly\Lumen\Gateway;
use Sms4jawaly\Lumen\WhatsAppGateway;

class NotificationController extends Controller
{
    private $sms;
    private $wa;

    public function __construct(Gateway $sms, WhatsAppGateway $wa)
    {
        $this->sms = $sms;
        $this->wa = $wa;
    }

    public function sendOtp(Request $request)
    {
        $phone = $request->input('phone');
        $otp = rand(1000, 9999);
        $channel = $request->input('channel', 'sms'); // sms or whatsapp

        if ($channel === 'whatsapp') {
            $response = $this->wa->sendText($phone, "رمز التحقق: {$otp}");
        } else {
            $response = $this->sms->sendSms("رمز التحقق: {$otp}", [$phone], '4jawaly');
        }

        return response()->json($response);
    }
}
```

## مصفوفة التوافق | Compatibility Matrix

| PHP | Laravel | Lumen | Guzzle | PHPUnit |
|-----|---------|-------|--------|---------|
| 7.3 | 8.x | 8.x | 7.x | 9.x |
| 7.4 | 8.x | 8.x | 7.x | 9.x |
| 8.0 | 8.x, 9.x | 8.x, 9.x | 7.x | 9.x, 10.x |
| 8.1 | 9.x, 10.x | 9.x, 10.x | 7.x | 9.x, 10.x |
| 8.2 | 10.x, 11.x, 12.x | 10.x | 7.x | 10.x, 11.x |
| 8.3 | 10.x, 11.x, 12.x | 10.x | 7.x | 10.x, 11.x |
| 8.4 | 11.x, 12.x | — | 7.x | 10.x, 11.x |

## معلومات API | API Information

| الخدمة | Base URL | المصادقة |
|---|---|---|
| SMS | `https://api-sms.4jawaly.com/api/v1` | Basic Auth (api_key:api_secret) |
| WhatsApp | `https://api-users.4jawaly.com/api/v1/whatsapp/{project_id}` | Basic Auth (app_key:api_secret) |

## المساهمة | Contributing

نرحب بمساهماتكم! يرجى إرسال pull request.

## الترخيص | License

هذه المكتبة مرخصة تحت رخصة MIT.

<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Sms4jawaly\Lumen\WhatsAppGateway;

$wa = new WhatsAppGateway(
    'your_app_key',
    'your_api_secret',
    'your_project_id'
);

// With custom options / مع خيارات مخصصة
// $wa = new WhatsAppGateway('app_key', 'api_secret', 'project_id', [
//     'timeout' => 60,
// ]);

$recipient = '9665XXXXXXXX';

// ──────────────────────────────────────────
// 1. Text / رسالة نصية
// ──────────────────────────────────────────
echo "\n=== Send Text / إرسال نص ===\n";
$res = $wa->sendText($recipient, 'مرحباً من 4Jawaly!');
print_r($res);

// ──────────────────────────────────────────
// 2. Interactive Buttons / أزرار تفاعلية
// ──────────────────────────────────────────
echo "\n=== Send Buttons / إرسال أزرار ===\n";
$res = $wa->sendButtons($recipient, 'اختر أحد الخيارات التالية', [
    ['id' => 'btn_yes',  'title' => 'نعم'],
    ['id' => 'btn_no',   'title' => 'لا'],
    ['id' => 'btn_help', 'title' => 'مساعدة'],
]);
print_r($res);

// ──────────────────────────────────────────
// 3. Interactive List / قائمة تفاعلية
// ──────────────────────────────────────────
echo "\n=== Send List / إرسال قائمة ===\n";
$res = $wa->sendList(
    $recipient,
    'قائمة الخدمات',
    'اختر الخدمة المطلوبة من القائمة أدناه',
    '4Jawaly Services',
    'عرض القائمة',
    [
        [
            'title' => 'الخدمات الأساسية',
            'rows'  => [
                ['id' => 'svc_sms',      'title' => 'خدمة الرسائل النصية', 'description' => 'إرسال رسائل SMS'],
                ['id' => 'svc_whatsapp', 'title' => 'خدمة واتساب',         'description' => 'رسائل واتساب تفاعلية'],
            ],
        ],
        [
            'title' => 'الدعم الفني',
            'rows'  => [
                ['id' => 'support_ticket', 'title' => 'فتح تذكرة دعم', 'description' => 'تواصل مع الدعم الفني'],
            ],
        ],
    ]
);
print_r($res);

// ──────────────────────────────────────────
// 4. Image / صورة
// ──────────────────────────────────────────
echo "\n=== Send Image / إرسال صورة ===\n";
$res = $wa->sendImage($recipient, 'https://example.com/image.jpg', 'وصف الصورة');
print_r($res);

// ──────────────────────────────────────────
// 5. Video / فيديو
// ──────────────────────────────────────────
echo "\n=== Send Video / إرسال فيديو ===\n";
$res = $wa->sendVideo($recipient, 'https://example.com/video.mp4', 'وصف الفيديو');
print_r($res);

// ──────────────────────────────────────────
// 6. Audio / صوت
// ──────────────────────────────────────────
echo "\n=== Send Audio / إرسال صوت ===\n";
$res = $wa->sendAudio($recipient, 'https://example.com/audio.mp3');
print_r($res);

// ──────────────────────────────────────────
// 7. Document / مستند
// ──────────────────────────────────────────
echo "\n=== Send Document / إرسال مستند ===\n";
$res = $wa->sendDocument(
    $recipient,
    'https://example.com/document.pdf',
    'وصف المستند',
    'document.pdf'
);
print_r($res);

// ──────────────────────────────────────────
// 8. Location / موقع جغرافي
// ──────────────────────────────────────────
echo "\n=== Send Location / إرسال موقع ===\n";
$res = $wa->sendLocation($recipient, 24.7136, 46.6753, 'Riyadh, Saudi Arabia', 'المكتب');
print_r($res);

// ──────────────────────────────────────────
// 9. Contact / جهة اتصال
// ──────────────────────────────────────────
echo "\n=== Send Contact / إرسال جهة اتصال ===\n";
$res = $wa->sendContact($recipient, [
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
print_r($res);

// ──────────────────────────────────────────
// Usage in Laravel/Lumen controller
// استخدام في Laravel/Lumen controller
// ──────────────────────────────────────────
echo "\n--- Example controller usage ---\n";
echo <<<'EXAMPLE'

use Sms4jawaly\Lumen\WhatsAppGateway;

class WhatsAppController extends Controller
{
    private $wa;

    public function __construct(WhatsAppGateway $wa)
    {
        $this->wa = $wa;
    }

    public function sendOtp(Request $request)
    {
        $otp = rand(1000, 9999);

        $response = $this->wa->sendText(
            $request->input('phone'),
            "رمز التحقق الخاص بك: {$otp}"
        );

        return response()->json($response);
    }

    public function sendMenu(Request $request)
    {
        $response = $this->wa->sendButtons(
            $request->input('phone'),
            'كيف يمكننا مساعدتك؟',
            [
                ['id' => 'sales',   'title' => 'المبيعات'],
                ['id' => 'support', 'title' => 'الدعم الفني'],
                ['id' => 'info',    'title' => 'معلومات'],
            ]
        );

        return response()->json($response);
    }
}

EXAMPLE;

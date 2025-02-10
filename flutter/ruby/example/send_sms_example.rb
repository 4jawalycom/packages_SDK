require 'sms4jawaly'

# Initialize the client with your API credentials
# قم بتهيئة العميل باستخدام بيانات اعتماد API الخاصة بك
# Initialisez le client avec vos identifiants API
# अपने API क्रेडेंशियल्स के साथ क्लाइंट को इनिशियलाइज़ करें
# اپنے API کریڈنشلز کے ساتھ کلائنٹ کو شروع کریں
client = Sms4jawaly::Gateway.new(
  'your_api_key',      # Replace with your API key / استبدل بمفتاح API الخاص بك
  'your_api_secret'    # Replace with your API secret / استبدل بسر API الخاص بك
)

# Get sender names / جلب أسماء المرسلين / Obtenir les noms d'expéditeur / प्रेषक के नाम प्राप्त करें / بھیجنے والے کے نام حاصل کریں
puts "\nGetting sender names / جلب أسماء المرسلين:"
senders = client.get_senders
puts senders.inspect

# Get balance / جلب الرصيد / Obtenir le solde / बैलेंस प्राप्त करें / بیلنس حاصل کریں
puts "\nGetting balance / جلب الرصيد:"
balance = client.get_balance
puts balance.inspect

# Send SMS / إرسال رسالة / Envoyer un SMS / एसएमएस भेजें / ایس ایم ایس بھیجیں
puts "\nSending SMS / إرسال رسالة:"
response = client.send_sms(
  'Test message from 4jawaly / رسالة تجريبية من فورجوالي',  # Message text / نص الرسالة
  ['966500000000'],                                         # Recipients / المستلمين
  '4jawaly'                                                # Sender name / اسم المرسل
)
puts response.inspect

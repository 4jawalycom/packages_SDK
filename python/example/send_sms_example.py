from sms4jawaly import SMS4Jawaly

# Initialize the client with your API credentials
# قم بتهيئة العميل باستخدام بيانات اعتماد API الخاصة بك
# Initialisez le client avec vos identifiants API
# अपने API क्रेडेंशियल्स के साथ क्लाइंट को इनिशियलाइज़ करें
# اپنے API کریڈنشلز کے ساتھ کلائنٹ کو شروع کریں
client = SMS4Jawaly(
    api_key='your_api_key',      # Replace with your API key / استبدل بمفتاح API الخاص بك
    api_secret='your_api_secret'  # Replace with your API secret / استبدل بسر API الخاص بك
)

def main():
    # Get sender names / جلب أسماء المرسلين / Obtenir les noms d'expéditeur
    print("\nGetting sender names / جلب أسماء المرسلين:")
    senders = client.get_senders()
    print(senders)

    # Get balance / جلب الرصيد / Obtenir le solde
    print("\nGetting balance / جلب الرصيد:")
    balance = client.get_balance()
    print(balance)

    # Send single SMS / إرسال رسالة واحدة / Envoyer un SMS unique
    print("\nSending single SMS / إرسال رسالة واحدة:")
    response = client.send_message(
        sender_name='4jawaly',  # Sender name / اسم المرسل
        message='Test message from 4jawaly / رسالة تجريبية من فورجوالي',  # Message text / نص الرسالة
        recipients=['966500000000']  # Recipients list / قائمة المستلمين
    )
    print(response)

    # Send bulk SMS / إرسال رسائل متعددة / Envoyer des SMS en masse
    print("\nSending bulk SMS / إرسال رسائل متعددة:")
    bulk_response = client.send_bulk_messages(
        sender_name='4jawaly',
        messages=[
            {
                'message': 'First bulk message / الرسالة الأولى',
                'recipients': ['966500000001']
            },
            {
                'message': 'Second bulk message / الرسالة الثانية',
                'recipients': ['966500000002']
            }
        ]
    )
    print(bulk_response)

if __name__ == '__main__':
    main()

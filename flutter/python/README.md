# 4Jawaly Python SDK Example

This directory contains example code for using the 4Jawaly SMS service with Python.

## Directory Structure

```
python/
├── example/
│   ├── requirements.txt        # Python dependencies
│   └── send_sms_example.py    # Example code
└── README.md                  # This file
```

## Prerequisites

- Python 3.6 or higher
- pip (Python package installer)

## Installation

### Arabic (العربية)
1. قم بتثبيت المكتبة باستخدام pip:
```bash
pip install sms4jawaly-py
```
2. أو أضف المكتبة إلى ملف requirements.txt:
```
sms4jawaly-py>=1.0.0
```
ثم قم بالتثبيت:
```bash
pip install -r requirements.txt
```

### English
1. Install using pip:
```bash
pip install sms4jawaly-py
```
2. Or add to requirements.txt:
```
sms4jawaly-py>=1.0.0
```
Then install:
```bash
pip install -r requirements.txt
```

### Français
1. Installer avec pip:
```bash
pip install sms4jawaly-py
```
2. Ou ajouter à requirements.txt:
```
sms4jawaly-py>=1.0.0
```
Puis installer:
```bash
pip install -r requirements.txt
```

### Hindi (हिंदी)
1. pip का उपयोग करके इंस्टॉल करें:
```bash
pip install sms4jawaly-py
```
2. या requirements.txt में जोड़ें:
```
sms4jawaly-py>=1.0.0
```
फिर इंस्टॉल करें:
```bash
pip install -r requirements.txt
```

### Urdu (اردو)
1. pip کے ذریعے انسٹال کریں:
```bash
pip install sms4jawaly-py
```
2. یا requirements.txt میں شامل کریں:
```
sms4jawaly-py>=1.0.0
```
پھر انسٹال کریں:
```bash
pip install -r requirements.txt
```

## Usage Example

```python
from sms4jawaly import SMS4Jawaly

# Initialize client
client = SMS4Jawaly(
    api_key='your_api_key',
    api_secret='your_api_secret'
)

# Send SMS
response = client.send_message(
    sender_name='4jawaly',
    message='Test message',
    recipients=['966500000000']
)
print(response)
```

## Running the Example

1. Clone this repository
2. Navigate to the example directory:
```bash
cd python/example
```
3. Install dependencies:
```bash
pip install -r requirements.txt
```
4. Update the API credentials in `send_sms_example.py`
5. Run the example:
```bash
python send_sms_example.py
```

## Features

1. Send single SMS messages
2. Send bulk SMS messages
3. Get sender names
4. Check balance
5. Comprehensive error handling
6. Support for multiple languages

## API Documentation

For complete API documentation, visit:
- [PyPI Package](https://pypi.org/project/sms4jawaly-py/)
- [API Key Tutorial](https://youtu.be/oTB6hLbJXPU?si=_Bn0Zi-VxULnz-r2)

## Support

For support, please contact:
- Email: support@4jawaly.com
- Website: https://www.4jawaly.com

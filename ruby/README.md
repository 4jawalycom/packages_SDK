# 4Jawaly Ruby SDK Example

This directory contains example code for using the 4Jawaly SMS service with Ruby.

## Directory Structure

```
ruby/
├── example/
│   ├── Gemfile                 # Ruby dependencies
│   └── send_sms_example.rb     # Example code
└── README.md                   # This file
```

## Prerequisites

- Ruby 2.0 or higher
- RubyGems

## Installation

1. Install the gem:
```bash
gem install sms4jawaly
```

2. Or add to your Gemfile:
```ruby
gem 'sms4jawaly'
```

Then run:
```bash
bundle install
```

## Running the Example

1. Clone this repository
2. Navigate to the example directory:
```bash
cd ruby/example
```
3. Update the API credentials in `send_sms_example.rb`:
```ruby
client = Sms4jawaly::Gateway.new(
  'your_api_key',
  'your_api_secret'
)
```
4. Run the example:
```bash
ruby send_sms_example.rb
```

## API Documentation

For complete API documentation, visit:
- [RubyGems Page](https://rubygems.org/gems/sms4jawaly)
- [API Key Tutorial](https://youtu.be/oTB6hLbJXPU?si=_Bn0Zi-VxULnz-r2)

## Support

For support, please contact:
- Email: support@4jawaly.com
- Website: https://www.4jawaly.com

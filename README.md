# DianaHost-WhatsappAPI
WhatsApp SMS API Notification Service is your solution for sending important messages via WhatsApp. It’s a simple and effective way to reach your audience instantly.
# WhatsApp API Gateway (PHP)

A clean, lightweight, and production-ready **WhatsApp API Gateway written in PHP (7.4+)** using the **wacloud.app Send Message API**.

This package allows developers to send **WhatsApp text and media messages** easily using a simple PHP class.

---

## 🚀 Features

- ✅ Send WhatsApp text messages
- ✅ Send media messages (PDF, image, etc.)
- ✅ PHP 7.4+ strict typing
- ✅ OOP-based clean structure
- ✅ Input validation
- ✅ Error handling with logging
- ✅ Shared hosting & production ready

---

## 📦 Requirements

- PHP **7.4 or higher**
- cURL extension enabled
- Valid **API Key**
- Valid **Instance ID** from wacloud.app

---

## 📂 Project Structure

├── WhatsAppApiGateway.php
├── send.php
├── whatsapp_gateway.log
└── README.md


---

## 🔑 API Credentials

Obtain the following from **wacloud.app**:
- API Key
- Instance ID

---

## 📥 Installation

Clone the repository:

```bash
git clone https://github.com/yourusername/whatsapp-api-gateway-php.git

Include the gateway class:
require_once "WhatsAppApiGateway.php";

🛠 Usage
Initialize Gateway

$apiKey = "YOUR_API_KEY";
$instanceId = "YOUR_INSTANCE_ID";

$wa = new WhatsAppApiGateway($apiKey, $instanceId);

📩 Send Text Message
$response = $wa->sendMessage(
    "8801XXXXXXXXX",
    "Hello from WhatsApp API Gateway!"
);

print_r($response);

📎 Send Media Message
$response = $wa->sendMessage(
    "8801XXXXXXXXX",
    "Here is your document",
    "https://example.com/file.pdf"
);

print_r($response);


🧪 Error Logging

Errors are logged automatically in:
whatsapp_gateway.log


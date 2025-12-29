<?php
require_once "WhatsAppApiGateway.php";

$apiKey     = "YOUR_API_KEY";
$instanceId = "YOUR_INSTANCE_ID";

$wa = new WhatsAppApiGateway($apiKey, $instanceId);

// Send text message
$response = $wa->sendMessage(
    "8801816035135",
    "Hello from WhatsApp API Gateway!"
);

print_r($response);

// Send media message
$response = $wa->sendMessage(
    "8801816035135",
    "Here is your document:",
    "https://example.com/file.pdf"
);

print_r($response);

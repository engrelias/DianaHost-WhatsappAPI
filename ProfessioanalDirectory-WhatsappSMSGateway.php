<?php

class WhatsappSMSGateway {

    private $apiUrl = "https://api.wacloud.app/send-message";
	private $apiKey = "api key here";
	private $instance_id = 'isntance id here';
	

    // Constructor takes API key
    public function __construct() {
        //$this->apiKey = $apiKey;
    }

    /**
     * Send WhatsApp Message
     * @param string $recipient - Phone number (88017xxxxxxx)
     * @param string $content - Text content
     * @param string|null $media_url - If empty => text only
     * @param string $instance_id - Instance ID
     * @return array - API Response
     */
    public function sendSMS($recipient, $message, $media_url = "") {
        
        $payload = [
            "recipient" => $recipient,
            "content" => $message,
            "media_url" => $media_url, // keep blank for text message
            "instance_id" => $this->instance_id
        ];

        $headers = [
            "Content-Type: application/json",
            "API-Key: " . $this->apiKey
        ];

        $ch = curl_init($this->apiUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        $error = curl_error($ch);

        curl_close($ch);

        if ($error) {
            return [
                "success" => false,
                "message" => "Curl Error: " . $error,
                "code" => 500
            ];
        }

        return json_decode($result, true);
    }
}

/*
$gateway = new WhatsappSMSGateway();

// Example Text Message
$response = $gateway->sendSMS(
    "8801816035135",      // recipient
    "Hello from PHP API", // message
);

print_r($response);


// Send text message
$response = $wa->sendSMS(
    "8801816035135",
    "Hello from your WhatsApp API Gateway!"
);

print_r($response);

//Example for Media Message
$response = $wa->sendSMS(
    "8801816035135",
    "Here is your document:",
    "https://example.com/file.pdf"
);

print_r($response);
*/
<?php
/**
 * WhatsApp API Gateway
 * Author: Engr. Md. Elias Jabed
 * PHP Version: 7.4+
 */

class WhatsAppApiGateway
{
    private string $apiUrl = "https://api.wacloud.app/send-message";
    private string $apiKey;
    private string $instanceId;

    /**
     * Constructor
     *
     * @param string $apiKey
     * @param string $instanceId
     */
    public function __construct(string $apiKey, string $instanceId)
    {
        $this->apiKey     = $apiKey;
        $this->instanceId = $instanceId;
    }

    /**
     * Send WhatsApp Message (Text or Media)
     *
     * @param string $recipient  Phone number (8801XXXXXXXXX)
     * @param string $message    Message content
     * @param string $mediaUrl   Media URL (optional)
     * @return array
     */
    public function sendMessage(string $recipient, string $message, string $mediaUrl = ""): array
    {
        // Validate phone number
        if (!$this->isValidPhone($recipient)) {
            return $this->errorResponse("Invalid recipient number format");
        }

        // Validate message
        if (trim($message) === "") {
            return $this->errorResponse("Message content cannot be empty");
        }

        // Payload
        $payload = [
            "recipient"   => $recipient,
            "content"     => $message,
            "media_url"   => $mediaUrl,
            "instance_id" => $this->instanceId
        ];

        // Headers
        $headers = [
            "Content-Type: application/json",
            "API-Key: {$this->apiKey}"
        ];

        // CURL Request
        $ch = curl_init($this->apiUrl);
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode($payload),
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2
        ]);

        $response  = curl_exec($ch);
        $curlError = curl_error($ch);
        $httpCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // CURL error
        if ($curlError) {
            $this->logError($curlError);
            return $this->errorResponse("Gateway connection failed", 500);
        }

        // Decode JSON
        $decoded = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->logError("Invalid JSON Response: " . $response);
            return $this->errorResponse("Invalid response from WhatsApp server");
        }

        // Append HTTP code
        $decoded["http_code"] = $httpCode;

        return $decoded;
    }

    /**
     * Phone number validation
     */
    private function isValidPhone(string $number): bool
    {
        return (bool) preg_match('/^[0-9]{11,15}$/', $number);
    }

    /**
     * Standard error response
     */
    private function errorResponse(string $message, int $code = 400): array
    {
        return [
            "success" => false,
            "message" => $message,
            "code"    => $code
        ];
    }

    /**
     * Error logger
     */
    private function logError(string $message): void
    {
        error_log(
            "[" . date("Y-m-d H:i:s") . "] WhatsAppApiGateway: " . $message . PHP_EOL,
            3,
            __DIR__ . "/whatsapp_gateway.log"
        );
    }
}

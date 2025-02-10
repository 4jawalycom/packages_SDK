<?php

namespace Sms4jawaly\Lumen;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Gateway
{
    const API_BASE_URL = 'https://api-sms.4jawaly.com/api/v1';
    
    private $apiKey;
    private $apiSecret;
    private $client;

    public function __construct(string $apiKey, string $apiSecret)
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
        $this->client = new Client([
            'base_uri' => self::API_BASE_URL,
            'headers' => $this->createHeaders()
        ]);
    }

    /**
     * Get account balance
     * @return array
     */
    public function getBalance(): array
    {
        try {
            $response = $this->client->get('/account/area/me/packages', [
                'query' => [
                    'is_active' => 1,
                    'p_type' => 1
                ]
            ]);
            
            return [
                'success' => true,
                'data' => json_decode($response->getBody()->getContents(), true)
            ];
        } catch (GuzzleException $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get sender names
     * @return array
     */
    public function getSenders(): array
    {
        try {
            $allSenders = [];
            $defaultSenders = [];
            $page = 1;
            
            do {
                $response = $this->client->get('/account/area/senders', [
                    'query' => ['page' => $page]
                ]);
                
                $data = json_decode($response->getBody()->getContents(), true);
                $items = $data['items'];
                
                foreach ($items['data'] as $item) {
                    $senderName = $item['sender_name'];
                    $allSenders[] = $senderName;
                    if ($item['is_default'] === 1) {
                        $defaultSenders[] = $senderName;
                    }
                }
                
                $page++;
            } while ($page <= $items['last_page']);

            return [
                'success' => true,
                'all_senders' => $allSenders,
                'default_senders' => $defaultSenders,
                'message' => 'تم'
            ];
        } catch (GuzzleException $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Send SMS messages
     * @param string $message
     * @param array $numbers
     * @param string $sender
     * @return array
     */
    public function sendSms(string $message, array $numbers, string $sender): array
    {
        $result = [
            'success' => true,
            'total_success' => 0,
            'total_failed' => 0,
            'job_ids' => [],
            'errors' => []
        ];

        try {
            $response = $this->client->post('/account/area/sms/send', [
                'json' => [
                    'messages' => [
                        [
                            'text' => $message,
                            'numbers' => $numbers,
                            'sender' => $sender
                        ]
                    ]
                ]
            ]);
            
            $data = json_decode($response->getBody()->getContents(), true);
            $result['total_success'] = count($numbers);
            if (isset($data['job_id'])) {
                $result['job_ids'][] = $data['job_id'];
            }
        } catch (GuzzleException $e) {
            $result['success'] = false;
            $result['total_failed'] = count($numbers);
            $result['errors'][$e->getMessage()] = $numbers;
        }

        return $result;
    }

    /**
     * Create authorization headers
     * @return array
     */
    private function createHeaders(): array
    {
        return [
            'Authorization' => 'Basic ' . base64_encode($this->apiKey . ':' . $this->apiSecret),
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];
    }
}

<?php

namespace Sms4jawaly\Lumen;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class WhatsAppGateway
{
    const API_BASE_URL = 'https://api-users.4jawaly.com/api/v1/whatsapp';

    /** @var string */
    private $appKey;

    /** @var string */
    private $apiSecret;

    /** @var string */
    private $projectId;

    /** @var Client */
    private $client;

    /**
     * @param string $appKey
     * @param string $apiSecret
     * @param string $projectId
     * @param array  $options   Optional: 'base_url', 'timeout', 'guzzle'
     */
    public function __construct(string $appKey, string $apiSecret, string $projectId, array $options = [])
    {
        $this->appKey = $appKey;
        $this->apiSecret = $apiSecret;
        $this->projectId = $projectId;

        $baseUrl = rtrim($options['base_url'] ?? self::API_BASE_URL, '/') . '/' . $projectId;

        $guzzleConfig = array_merge(
            $options['guzzle'] ?? [],
            [
                'base_uri' => $baseUrl,
                'timeout'  => $options['timeout'] ?? 30,
                'headers'  => [
                    'Authorization' => 'Basic ' . base64_encode($appKey . ':' . $apiSecret),
                    'Accept'        => 'application/json',
                    'Content-Type'  => 'application/json',
                ],
            ]
        );

        $this->client = new Client($guzzleConfig);
    }

    // ─── Text ────────────────────────────────────────────────────

    /**
     * @param string $recipient  e.g. "9665XXXXXXXX"
     * @param string $body
     * @return array
     */
    public function sendText(string $recipient, string $body): array
    {
        return $this->sendGlobal($recipient, [
            'type' => 'text',
            'text' => ['body' => $body],
        ]);
    }

    // ─── Interactive Buttons ─────────────────────────────────────

    /**
     * @param string $recipient
     * @param string $bodyText
     * @param array  $buttons  [['id' => 'btn_1', 'title' => 'Yes'], ...] (max 3)
     * @return array
     */
    public function sendButtons(string $recipient, string $bodyText, array $buttons): array
    {
        $formatted = [];
        foreach ($buttons as $btn) {
            $formatted[] = [
                'type'  => 'reply',
                'reply' => [
                    'id'    => $btn['id'] ?? '',
                    'title' => $btn['title'] ?? '',
                ],
            ];
        }

        return $this->sendGlobal($recipient, [
            'type'        => 'interactive',
            'interactive' => [
                'type'   => 'button',
                'body'   => ['text' => $bodyText],
                'action' => ['buttons' => $formatted],
            ],
        ]);
    }

    // ─── Interactive List ────────────────────────────────────────

    /**
     * @param string $recipient
     * @param string $headerText
     * @param string $bodyText
     * @param string $footerText
     * @param string $buttonLabel  Label of the list button
     * @param array  $sections     [['title' => '...', 'rows' => [['id','title','description'], ...]], ...]
     * @return array
     */
    public function sendList(
        string $recipient,
        string $headerText,
        string $bodyText,
        string $footerText,
        string $buttonLabel,
        array $sections
    ): array {
        return $this->sendGlobal($recipient, [
            'type'        => 'interactive',
            'interactive' => [
                'type'   => 'list',
                'header' => ['type' => 'text', 'text' => $headerText],
                'body'   => ['text' => $bodyText],
                'footer' => ['text' => $footerText],
                'action' => [
                    'button'   => $buttonLabel,
                    'sections' => $sections,
                ],
            ],
        ]);
    }

    // ─── Image ───────────────────────────────────────────────────

    /**
     * @param string      $recipient
     * @param string      $link     Image URL
     * @param string|null $caption
     * @return array
     */
    public function sendImage(string $recipient, string $link, $caption = null): array
    {
        $image = ['link' => $link];
        if ($caption !== null) {
            $image['caption'] = $caption;
        }

        return $this->sendGlobal($recipient, [
            'type'  => 'image',
            'image' => $image,
        ]);
    }

    // ─── Video ───────────────────────────────────────────────────

    /**
     * @param string      $recipient
     * @param string      $link     Video URL
     * @param string|null $caption
     * @return array
     */
    public function sendVideo(string $recipient, string $link, $caption = null): array
    {
        $video = ['link' => $link];
        if ($caption !== null) {
            $video['caption'] = $caption;
        }

        return $this->sendGlobal($recipient, [
            'type'  => 'video',
            'video' => $video,
        ]);
    }

    // ─── Audio ───────────────────────────────────────────────────

    /**
     * @param string $recipient
     * @param string $link  Audio URL
     * @return array
     */
    public function sendAudio(string $recipient, string $link): array
    {
        return $this->sendGlobal($recipient, [
            'type'  => 'audio',
            'audio' => ['link' => $link],
        ]);
    }

    // ─── Document ────────────────────────────────────────────────

    /**
     * @param string      $recipient
     * @param string      $link      Document URL
     * @param string|null $caption
     * @param string|null $filename
     * @return array
     */
    public function sendDocument(string $recipient, string $link, $caption = null, $filename = null): array
    {
        $document = ['link' => $link];
        if ($caption !== null) {
            $document['caption'] = $caption;
        }
        if ($filename !== null) {
            $document['filename'] = $filename;
        }

        return $this->sendGlobal($recipient, [
            'type'     => 'document',
            'document' => $document,
        ]);
    }

    // ─── Location ────────────────────────────────────────────────

    /**
     * @param string      $recipient
     * @param float       $lat
     * @param float       $lng
     * @param string      $address
     * @param string|null $name
     * @return array
     */
    public function sendLocation(string $recipient, float $lat, float $lng, string $address, $name = null): array
    {
        $params = [
            'phone'   => $recipient,
            'lat'     => $lat,
            'lng'     => $lng,
            'address' => $address,
        ];
        if ($name !== null) {
            $params['name'] = $name;
        }

        return $this->sendCustomPath('message/location', $params);
    }

    // ─── Contact ─────────────────────────────────────────────────

    /**
     * @param string $recipient
     * @param array  $contacts  [['name' => ['formatted_name','first_name','last_name'], 'phones' => [['phone','type']]], ...]
     * @return array
     */
    public function sendContact(string $recipient, array $contacts): array
    {
        return $this->sendCustomPath('message/contact', [
            'phone'    => $recipient,
            'contacts' => $contacts,
        ]);
    }

    // ─── Internal helpers ────────────────────────────────────────

    /**
     * Send via the "global" path (text, interactive, media).
     *
     * @param string $recipient
     * @param array  $messagePayload
     * @return array
     */
    private function sendGlobal(string $recipient, array $messagePayload): array
    {
        $payload = [
            'path'   => 'global',
            'params' => [
                'url'    => 'messages',
                'method' => 'post',
                'data'   => array_merge(
                    [
                        'messaging_product' => 'whatsapp',
                        'to'                => $recipient,
                    ],
                    $messagePayload
                ),
            ],
        ];

        return $this->post($payload);
    }

    /**
     * Send via a custom path (location, contact).
     *
     * @param string $path
     * @param array  $params
     * @return array
     */
    private function sendCustomPath(string $path, array $params): array
    {
        return $this->post([
            'path'   => $path,
            'params' => $params,
        ]);
    }

    /**
     * @param array $payload
     * @return array{success: bool, data?: array, error?: string, http_code?: int}
     */
    private function post(array $payload): array
    {
        try {
            $response = $this->client->post('', [
                'json' => $payload,
            ]);

            $body = $response->getBody()->getContents();

            return [
                'success'   => true,
                'http_code' => $response->getStatusCode(),
                'data'      => json_decode($body, true) ?? ['raw' => $body],
            ];
        } catch (GuzzleException $e) {
            $httpCode = method_exists($e, 'getResponse') && $e->getResponse()
                ? $e->getResponse()->getStatusCode()
                : 0;

            return [
                'success'   => false,
                'http_code' => $httpCode,
                'error'     => $e->getMessage(),
            ];
        }
    }
}

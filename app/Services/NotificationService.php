<?php

namespace App\Services;

use App\Interfaces\NotificationServiceInterface;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use App\Constants\StringConstants;

class NotificationService implements NotificationServiceInterface
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function notifyUsers(User $sender, User $receiver, float $amount): bool
    {
        $url_notification = StringConstants::NOTIFICATION_MOCK_URL;
        $message = [
            'email' => $receiver->email,
            'amount' => $amount,
            'message' => "You received $" . number_format($amount, 2) . " from " . $sender->name
        ];

        try {
            $response = $this->client->request('POST', $url_notification, [
                RequestOptions::JSON => $message
            ]);
            $data = json_decode($response->getBody()->getContents(), true);

            return $data['message'] === true;
        } catch (GuzzleException $e) {
            return false;
        }
    }
}

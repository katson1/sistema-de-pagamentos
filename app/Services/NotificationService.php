<?php

namespace App\Services;

use App\Interfaces\NotificationServiceInterface;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use App\Constants\StringConstants;

/**
 * Classe que implementa a interface de serviço de notificação para notificar usuários via um serviço externo.
 */
class NotificationService implements NotificationServiceInterface
{
    protected $client;

    /**
     * Construtor que inicializa o cliente HTTP.
     */
    public function __construct()
    {
        $this->client = $client;
    }

    /**
     * Método para notificar usuários sobre uma transferência financeira.
     * @param User $sender - O usuário remetente da transferência.
     * @param User $receiver - O usuário destinatário da transferência.
     * @param float $amount - A quantia de dinheiro transferida.
     * @return bool - Retorna verdadeiro se a notificação foi enviada com sucesso, falso caso contrário.
     */
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
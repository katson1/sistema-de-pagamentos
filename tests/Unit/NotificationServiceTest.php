<?php

use PHPUnit\Framework\TestCase;
use App\Services\NotificationService;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class NotificationServiceTest extends TestCase
{
    public function testNotifyUsersWithGuzzleException()
    {
        $httpClientMock = $this->createMock(Client::class);
        $httpClientMock->method('request')->willThrowException(new RequestException("Erro de requisição", new \GuzzleHttp\Psr7\Request('POST', 'http://example.com')));

        $notificationService = new NotificationService($httpClientMock);

        $sender = new User();
        $sender->name = "Teste";
        $sender->email = "teste@example.com";

        $receiver = new User();
        $receiver->name = "Teste Dois";
        $receiver->email = "teste_dois@example.com";

        $amount = 100.00;

        $this->assertFalse($notificationService->notifyUsers($sender, $receiver, $amount));
    }
}
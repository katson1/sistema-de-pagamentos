<?php

use PHPUnit\Framework\TestCase;
use App\Services\Authorization\ExternalAuthorizationService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;

class ExternalAuthorizationServiceTest extends TestCase
{
    public function test_authorize_with_failed_connection()
    {
        $invalidUrl = "http://url-invalida.com";

        $httpClientMock = $this->createMock(Client::class);
        $httpClientMock->method('request')->willThrowException(
            new RequestException("Erro", new Request('GET', $invalidUrl))
        );

        $authorizationService = new ExternalAuthorizationService($httpClientMock);

        $this->expectException(\Exception::class);
        $authorizationService->authorize();
    }
}
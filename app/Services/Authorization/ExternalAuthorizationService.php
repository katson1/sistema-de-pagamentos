<?php

namespace App\Services\Authorization;

use App\Interfaces\Authorization\AuthorizationServiceInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ExternalAuthorizationService implements AuthorizationServiceInterface
{
    private $httpClient;

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function authorize(): bool
    {
        try {
            $response = $this->httpClient->request('GET', 'https://run.mocky.io/v3/5794d450-d2e2-4412-8131-73d0293ac1cc');
            $data = json_decode($response->getBody()->getContents(), true);
            return $data['message'] === 'Autorizado';
        } catch (GuzzleException $e) {
            throw new \Exception("Failed to connect to authorization service: " . $e->getMessage());
        }
    }
}

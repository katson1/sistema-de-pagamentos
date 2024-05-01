<?php

namespace App\Services\Authorization;

use App\Interfaces\Authorization\AuthorizationServiceInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use App\Constants\StringConstants;

class ExternalAuthorizationService implements AuthorizationServiceInterface
{
    private $httpClient;

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function authorize(): bool
    {
        $url_auth = StringConstants::AUTHORIZATION_MOCK_URL;
        try {
            $response = $this->httpClient->request('GET', $url_auth);
            $data = json_decode($response->getBody()->getContents(), true);
            return $data['message'] === 'Autorizado';
        } catch (GuzzleException $e) {
            throw new \Exception(StringConstants::AUTHORIZATION_CONNECTION_FAILED . ': ' . $e->getMessage());
        }
    }
}

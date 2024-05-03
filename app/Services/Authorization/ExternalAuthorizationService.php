<?php

namespace App\Services\Authorization;

use App\Interfaces\Authorization\AuthorizationServiceInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use App\Constants\StringConstants;

/**
 * Classe que implementa a interface de serviço de autorização para integração externa.
 */
class ExternalAuthorizationService implements AuthorizationServiceInterface
{
    // Cliente HTTP privado para fazer requisições
    private $httpClient;

    /**
     * Construtor para injetar uma instância do cliente HTTP.
     * @param Client $httpClient - Cliente HTTP para fazer a requisição de autorização.
     */
    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Método que realiza uma requisição GET a um serviço externo para autorizar uma transação.
     * @return bool - Retorna verdadeiro se a transação for autorizada, falso caso contrário.
     * @throws \Exception - Lança uma exceção se a conexão com o serviço externo falhar.
     */
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

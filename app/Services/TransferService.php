<?php

namespace App\Services;

use App\Interfaces\TransferInterface;
use App\Services\Authorization\ExternalAuthorizationService;
use App\Services\NotificationService;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Constants\StringConstants;

/**
 * Classe que implementa a interface para serviços de transferência.
 */
class TransferService implements TransferInterface
{
    private ExternalAuthorizationService $authorizationService;
    private NotificationService $notificationService;

    /**
     * Construtor que inicializa os serviços de autorização e notificação.
     * @param ExternalAuthorizationService $authorizationService - Serviço para autorização de transações.
     * @param NotificationService $notificationService - Serviço para notificar os usuários sobre a transferência.
     */
    public function __construct(
        ExternalAuthorizationService $authorizationService,
        NotificationService $notificationService
    ) {
        $this->authorizationService = $authorizationService;
        $this->notificationService = $notificationService;
    }

    /**
     * Método que executa a transferência de fundos entre dois usuários.
     * @param User $sender - Usuário que envia o dinheiro.
     * @param User $receiver - Usuário que recebe o dinheiro.
     * @param float $amount - Quantia de dinheiro a ser transferida.
     * @return array - Retorna os resultados da transação e notificação.
     */
    public function execute(User $sender, User $receiver, float $amount): array
    {
        $this->validateTransaction($sender, $receiver, $amount);

        $notificationResult = false;

        // Inicia uma transação no banco de dados e desfaz de modo seguro em caso de erro.
        DB::beginTransaction();
        try {
            $sender->decrement('balance', $amount);
            $this->authorizeTransaction();
            $receiver->increment('balance', $amount);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        // Notifica os usuários envolvidos na transferência
        $notificationResult = $this->notificationService->notifyUsers($sender, $receiver, $amount);

        return [
            'transaction' => true,
            'notification' => $notificationResult
        ];
    }

    /**
     * Valida se a transação pode ser realizada.
     * @throws \Exception - Lança exceções se alguma validação falhar.
     */
    private function validateTransaction(User $sender, User $receiver, float $amount): void
    {
        if ($sender == $receiver) {
            throw new \Exception(StringConstants::SAME_SENDER_RECEIVER);
        }

        if (!$sender->canSendMoney()) {
            throw new \Exception(StringConstants::SENDER_CANNOT_SEND);
        }

        if (!$receiver->canReceiveMoney()) {
            throw new \Exception(StringConstants::RECEIVER_CANNOT_RECEIVE);
        }

        if ($sender->balance < $amount) {
            throw new \Exception(StringConstants::INSUFFICIENT_BALANCE);
        }
    }

    /**
     * Verifica a autorização da transação.
     * @throws \Exception - Lança exceção se a transação não for autorizada.
     */
    private function authorizeTransaction(): void
    {
        if (!$this->authorizationService->authorize()) {
            throw new \Exception(StringConstants::AUTHORIZATION_FAILED);
        }
    }
}

<?php

namespace App\Constants;

/**
 * Classe criada para guardar as Strings/Constantes para utilizar no codigo
 */
class StringConstants
{
    // URLs de serviços mock para testes de autorização e notificação
    public const AUTHORIZATION_MOCK_URL = "https://run.mocky.io/v3/5794d450-d2e2-4412-8131-73d0293ac1cc";
    public const NOTIFICATION_MOCK_URL = "https://run.mocky.io/v3/54dc2cf1-3add-45b5-b5a9-6bf7e7f1f4a6";

    // Mensagem de sucesso para transferências completadas
    public const TRANSFER_SUCCESSFUL = 'Transfer successful!';

    // Mensagem de erro para dados inválidos fornecidos
    public const INVALID_DATA_GIVEN = 'Data given is invalid.';

    // Mensagens de validação para detalhes do remetente na transferência
    public const ID_SENDER_REQUIRED = 'The sender ID is required.';
    public const ID_SENDER_NUMERIC = 'The sender ID must be a numeric value.';

    // Mensagens de validação para detalhes do destinatário na transferência
    public const ID_RECEIVER_REQUIRED = 'The receiver ID is required.';
    public const ID_RECEIVER_NUMERIC = 'The receiver ID must be a numeric value.';

    // Mensagens de validação para o montante da transferência
    public const AMOUNT_REQUIRED = 'The amount is required.';
    public const AMOUNT_NUMERIC = 'The amount must be a numeric value.';
    public const AMOUNT_MIN = 'The amount must be at least 0.01.';

    // Mensagens de validação para cadastro e atualização de usuário
    public const NAME_REQUIRED = 'The name field is required.';
    public const EMAIL_REQUIRED = 'The email field is required.';
    public const EMAIL_EMAIL = 'Please enter a valid email address.';
    public const EMAIL_UNIQUE = 'This email address is already in use.';
    public const CPF_CNPJ_REQUIRED = 'The CPF/CNPJ field is required.';
    public const CPF_CNPJ_UNIQUE = 'This CPF/CNPJ is already in use.';
    public const CPF_CNPJ_NUMERIC = 'The CPF/CNPJ is not valid.';
    public const CPF_CNPJ_DIGITS_BETWEEN = 'The CPF/CNPJ must be between 11 and 14 digits long.';
    public const USER_TYPE_REQUIRED = 'The user type is required.';
    public const USER_TYPE_IN = 'The user type must be "common" or "store".';
    public const BALANCE_NUMERIC = 'The balance must be a numeric value.';
    public const BALANCE_MIN = 'The balance cannot be less than 0.';
    public const PASSWORD_REQUIRED = 'The password field is required.';
    public const PASSWORD_MIN = 'The password must be at least 8 characters long.';

    // Mensagens de erro para validação de transações
    public const SAME_SENDER_RECEIVER = 'The sender cannot be the same as the receiver.';
    public const SENDER_CANNOT_SEND = 'Sender cannot send money.';
    public const RECEIVER_CANNOT_RECEIVE = 'Receiver cannot receive money.';
    public const INSUFFICIENT_BALANCE = 'Sender does not have enough balance.';

    // Mensagens de erro para falhas na autorização de transações
    public const AUTHORIZATION_FAILED = 'Transaction not authorized by external service.';
    public const AUTHORIZATION_CONNECTION_FAILED = 'Failed to connect to authorization service.';
}

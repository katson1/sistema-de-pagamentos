<?php

namespace App\Constants;

class StringConstants
{
    //mock strings
    const AUTHORIZATION_MOCK_URL = "https://run.mocky.io/v3/5794d450-d2e2-4412-8131-73d0293ac1cc";
    const NOTIFICATION_MOCK_URL = "https://run.mocky.io/v3/54dc2cf1-3add-45b5-b5a9-6bf7e7f1f4a6";

    // Success message for transfer
    const TRANSFER_SUCCESSFUL = 'Transfer successful!';

    //error message for failed validation
    const INVALID_DATA_GIVEN = 'Data given is invalid.';

    //transfer validation messages
    const ID_SENDER_REQUIRED = 'The sender ID is required.';
    const ID_SENDER_NUMERIC = 'The sender ID must be a numeric value.';
    const ID_RECEIVER_REQUIRED = 'The receiver ID is required.';
    const ID_RECEIVER_NUMERIC = 'The receiver ID must be a numeric value.';
    const AMOUNT_REQUIRED = 'The amount is required.';
    const AMOUNT_NUMERIC = 'The amount must be a numeric value.';
    const AMOUNT_MIN = 'The amount must be at least 0.1.';

    //user validation messages
    const NAME_REQUIRED = 'The name field is required.';
    const EMAIL_REQUIRED = 'The email field is required.';
    const EMAIL_EMAIL = 'Please enter a valid email address.';
    const EMAIL_UNIQUE = 'This email address is already in use.';
    const CPF_CNPJ_REQUIRED = 'The CPF/CNPJ field is required.';
    const CPF_CNPJ_UNIQUE = 'This CPF/CNPJ is already in use.';
    const CPF_CNPJ_NUMERIC = 'The CPF/CNPJ is not valid.';
    const CPF_CNPJ_DIGITS_BETWEEN = 'The CPF/CNPJ must be between 11 and 14 digits long.';
    const USER_TYPE_REQUIRED = 'The user type is required.';
    const USER_TYPE_IN = 'The user type must be "common" or "store".';
    const BALANCE_NUMERIC = 'The balance must be a numeric value.';
    const BALANCE_MIN = 'The balance cannot be less than 0.';
    const PASSWORD_REQUIRED = 'The password field is required.';
    const PASSWORD_MIN = 'The password must be at least 8 characters long.';

    //error messages for transaction validation
    const SAME_SENDER_RECEIVER = 'The sender cannot be the same as the receiver.';
    const SENDER_CANNOT_SEND = 'Sender cannot send money.';
    const RECEIVER_CANNOT_RECEIVE = 'Receiver cannot receive money.';
    const INSUFFICIENT_BALANCE = 'Sender does not have enough balance.';

    //error message for authorization
    const AUTHORIZATION_FAILED = 'Transaction not authorized by external service.';
    const AUTHORIZATION_CONNECTION_FAILED = 'Failed to connect to authorization service.';
}

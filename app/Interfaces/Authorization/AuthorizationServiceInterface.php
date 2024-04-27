<?php

namespace App\Interfaces\Authorization;

interface AuthorizationServiceInterface
{
    public function authorize(): bool;
}

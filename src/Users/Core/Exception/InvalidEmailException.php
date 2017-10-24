<?php

declare(strict_types = 1);

namespace Core\Exception;

use Exception;

class InvalidEmailException extends Exception
{
    public function __construct(string $email)
    {
        $this->message = sprintf("Given email (%s) is invalid.", $email);
    }
}
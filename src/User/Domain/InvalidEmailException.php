<?php

declare(strict_types=1);

namespace User\Domain;

use Exception;

class InvalidEmailException extends Exception
{
    public function __construct(string $email)
    {
        $message = sprintf('Given email (%s) is invalid.', $email);
        parent::__construct($message);
    }
}

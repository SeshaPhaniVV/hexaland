<?php

declare(strict_types=1);

namespace App\Domain\Hexagon;

use App\Domain\DomainException\DomainException;

class HexagonAlreadyExistsException extends DomainException
{
    public $message = 'The hexagon you requested to create already exists. Please make sure name is unique and there is no prior hexagon at that position to neighbor.';
}

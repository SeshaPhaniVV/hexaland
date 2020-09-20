<?php
declare(strict_types=1);

namespace App\Domain\Hexagon;

use App\Domain\DomainException\DomainException;

class CriticalHexagonDeleteException extends DomainException
{
    public $message = 'The hexagon you requested to delete is critical. Hence it cannot be deleted';
}

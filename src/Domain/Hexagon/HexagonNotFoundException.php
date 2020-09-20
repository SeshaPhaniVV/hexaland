<?php
declare(strict_types=1);

namespace App\Domain\Hexagon;

use App\Domain\DomainException\DomainRecordNotFoundException;

class HexagonNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'The hexagon you requested does not exist.';
}

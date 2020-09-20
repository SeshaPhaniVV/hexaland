<?php
declare(strict_types=1);

namespace App\Application\Actions\Hexagon;

use App\Application\Actions\Action;
use App\Domain\Hexagon\HexagonRepository;
use Psr\Log\LoggerInterface;

abstract class HexagonAction extends Action
{
    /**
     * @var HexagonRepository
     */
    protected $hexagonRepository;

    /**
     * @param LoggerInterface $logger
     * @param HexagonRepository  $hexagonRepository
     */
    public function __construct(LoggerInterface $logger, HexagonRepository $hexagonRepository)
    {
        parent::__construct($logger);
        $this->hexagonRepository = $hexagonRepository;
    }
}

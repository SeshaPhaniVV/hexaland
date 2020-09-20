<?php
declare(strict_types=1);

use App\Domain\Hexagon\HexagonRepository;
use App\Infrastructure\Persistence\Hexagon\HexagonService;
use DI\ContainerBuilder;
use function DI\autowire;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        HexagonRepository::class => autowire(HexagonService::class),
    ]);
};

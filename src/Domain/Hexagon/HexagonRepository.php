<?php
declare(strict_types=1);

namespace App\Domain\Hexagon;

use App\Domain\Hexagon\HexagonNotFoundException;

interface HexagonRepository
{
    /**
     * @return Hexagon[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     *
     * @throws HexagonNotFoundException
     */
    public function findHexagonOfId(int $id);

    /**
     * @param array $hexagon
     *
     * @return Hexagon
     */
    public function addHexagon(array $hexagon): Hexagon;

    /**
     * @param int $id
     * @return array
     */
    public function getNeighborsOfHexagon(int $id): array;

    /**
     * @param string $name
     *
     * @return bool
     *
     * @throws \App\Domain\Hexagon\HexagonNotFoundException
     */
    public function deleteHexagonOfName(string $name): bool;
}
